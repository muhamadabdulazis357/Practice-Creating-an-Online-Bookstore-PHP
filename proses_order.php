<?php
// Mulai session
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_shop");

// Cek koneksi database
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

// Ambil ID user dari session
$user_id = $_SESSION['user_id'] ?? null;

// Jika user belum login
if (!isset($user_id)) {
    die(json_encode(["status" => "error", "message" => "Silakan login terlebih dahulu"]));
}

// Cek apakah pembelian melalui fitur "Buy Now"
$is_buy_now = isset($_POST['is_buy_now']) && $_POST['is_buy_now'] == 'true';
$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

// Jika bukan pembelian "Buy Now", maka cek apakah keranjang kosong
if (!$is_buy_now) {
    $cartSql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
    $cartStmt = $conn->prepare($cartSql);
    $cartStmt->bind_param("i", $user_id);
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();
    $cartCount = $cartResult->fetch_assoc()["count"];

    if ($cartCount == 0) {
        die(json_encode(["status" => "error", "message" => "Keranjang belanja kosong"]));
    }
}

// Ambil alamat pengiriman terakhir user
$alamatSql = "SELECT * FROM alamat WHERE id_user = ? ORDER BY id DESC LIMIT 1";
$alamatStmt = $conn->prepare($alamatSql);
$alamatStmt->bind_param("i", $user_id);
$alamatStmt->execute();
$alamatResult = $alamatStmt->get_result();

// Jika belum ada alamat, tampilkan pesan error
if ($alamatResult->num_rows == 0) {
    die(json_encode(["status" => "error", "message" => "Alamat pengiriman belum diisi"]));
}

$alamatData = $alamatResult->fetch_assoc();

// Ambil data ekspedisi, ongkir, dan total dari POST
$ekspedisi = $_POST['ekspedisi'] ?? '';
$ongkir = floatval($_POST['ongkir'] ?? 0);
$total = floatval($_POST['total'] ?? 0);

// Mulai transaksi database
$conn->begin_transaction();

try {
    // Buat pesanan baru (insert ke tabel orders)
    $orderSql = "INSERT INTO orders (
                    user_id, 
                    total_harga, 
                    biaya_ongkir, 
                    ekspedisi, 
                    nama_penerima,
                    alamat_pengiriman,
                    no_telp,
                    status,
                    created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

    $orderStmt = $conn->prepare($orderSql);
    $alamat_lengkap = $alamatData['alamat_lengkap'] . ', ' . $alamatData['lokasi'] . ', ' . $alamatData['kode_pos'];

    $orderStmt->bind_param(
        "iddssss", 
        $user_id,
        $total,
        $ongkir,
        $ekspedisi,
        $alamatData['nama_penerima'],
        $alamat_lengkap,
        $alamatData['no_telp']
    );

    $orderStmt->execute();
    $order_id = $conn->insert_id;

    // Jika pembelian "Buy Now"
    if ($is_buy_now) {
        $bookSql = "SELECT * FROM buku WHERE id = ?";
        $bookStmt = $conn->prepare($bookSql);
        $bookStmt->bind_param("i", $book_id);
        $bookStmt->execute();
        $bookResult = $bookStmt->get_result();

        if ($bookResult->num_rows > 0) {
            $book = $bookResult->fetch_assoc();

            // Tambahkan item ke order_items
            $detailSql = "INSERT INTO order_items (
                            order_id,
                            book_id,
                            judul,
                            quantity,
                            harga,
                            subtotal
                          ) VALUES (?, ?, ?, ?, ?, ?)";

            $quantity = 1; // Buy Now hanya 1 quantity
            $subtotal = $quantity * $book['harga'];

            $detailStmt = $conn->prepare($detailSql);
            $detailStmt->bind_param(
                "iisidi",
                $order_id,
                $book['id'],
                $book['judul'],
                $quantity,
                $book['harga'],
                $subtotal
            );

            $detailStmt->execute();

            // Kurangi stok
            $updateStokSql = "UPDATE buku SET stok = stok - ? WHERE id = ?";
            $updateStokStmt = $conn->prepare($updateStokSql);
            $updateStokStmt->bind_param("ii", $quantity, $book['id']);
            $updateStokStmt->execute();
        }
    } else {
        // Jika checkout dari keranjang
        $cartDetailsSql = "SELECT c.book_id, c.quantity, b.harga, b.judul
                          FROM cart c
                          JOIN buku b ON c.book_id = b.id
                          WHERE c.user_id = ?";

        $cartDetailsStmt = $conn->prepare($cartDetailsSql);
        $cartDetailsStmt->bind_param("i", $user_id);
        $cartDetailsStmt->execute();
        $cartDetailsResult = $cartDetailsStmt->get_result();

        // Masukkan semua item dari keranjang ke order_items
        while ($item = $cartDetailsResult->fetch_assoc()) {
            $detailSql = "INSERT INTO order_items (
                            order_id,
                            book_id,
                            judul,
                            quantity,
                            harga,
                            subtotal
                          ) VALUES (?, ?, ?, ?, ?, ?)";

            $subtotal = $item['quantity'] * $item['harga'];

            $detailStmt = $conn->prepare($detailSql);
            $detailStmt->bind_param(
                "iisidi",
                $order_id,
                $item['book_id'],
                $item['judul'],
                $item['quantity'],
                $item['harga'],
                $subtotal
            );

            $detailStmt->execute();

            // Kurangi stok
            $updateStokSql = "UPDATE buku SET stok = stok - ? WHERE id = ?";
            $updateStokStmt = $conn->prepare($updateStokSql);
            $updateStokStmt->bind_param("ii", $item['quantity'], $item['book_id']);
            $updateStokStmt->execute();
        }

        // Hapus semua isi keranjang setelah berhasil buat order
        $emptyCartSql = "DELETE FROM cart WHERE user_id = ?";
        $emptyCartStmt = $conn->prepare($emptyCartSql);
        $emptyCartStmt->bind_param("i", $user_id);
        $emptyCartStmt->execute();
    }

    // Commit transaksi jika semua berhasil
    $conn->commit();

    // Kirim response sukses
    echo json_encode([
        "status" => "success",
        "message" => "Pesanan berhasil dibuat",
        "order_id" => $order_id
    ]);

} catch (Exception $e) {
    // Rollback transaksi jika ada error
    $conn->rollback();

    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan: " . $e->getMessage()
    ]);
}

// Tutup koneksi database
$conn->close();
