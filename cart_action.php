<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Anda belum login.']);
    exit;
}

$book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;


if ($action === 'add') {
    $stok_query = "SELECT stok FROM buku WHERE id = ?";
    $stok_stmt = $conn->prepare($stok_query);
    $stok_stmt->bind_param("i", $book_id);
    $stok_stmt->execute();
    $stok_result = $stok_stmt->get_result();

    if ($stok_result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Buku tidak ditemukan']);
        exit;
    }

    $stok_row = $stok_result->fetch_assoc();
    $stok = $stok_row['stok'];
    $stok_stmt->close();
    if ($quantity > $stok) {
            echo json_encode(['status' => 'error', 'message' => 'Stok tidak mencukupi.']);
            exit;
        }

    $check_sql = "SELECT quantity FROM cart WHERE user_id = ? AND book_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $book_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

         if ($new_quantity > $stok) {
            echo json_encode(['status' => 'error', 'message' => 'Stok tidak mencukupi.']);
            exit;
        }

        $update_sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND book_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $book_id);
        $update_stmt->execute();
        $update_stmt->close();


    } else {
        $insert_sql = "INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $book_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();

    }

    echo json_encode(['status' => 'success', 'message' => 'Buku berhasil ditambahkan ke keranjang.']);
    $check_stmt->close();

} elseif ($action === 'update_quantity') {
    $newQuantity = $quantity;

    $stok_query = "SELECT stok FROM buku WHERE id = ?";
    $stok_stmt = $conn->prepare($stok_query);
    $stok_stmt->bind_param("i", $book_id);
    $stok_stmt->execute();
    $stok_result = $stok_stmt->get_result();
    $stok_row = $stok_result->fetch_assoc();
    $stok = $stok_row['stok'];
    $stok_stmt->close();

    $curr_qty_query = "SELECT quantity FROM cart WHERE user_id = ? AND book_id = ?";
    $curr_qty_stmt = $conn->prepare($curr_qty_query);
    $curr_qty_stmt->bind_param("ii", $user_id, $book_id);
    $curr_qty_stmt->execute();
    $curr_qty_result = $curr_qty_stmt->get_result();
    $curr_qty_row = $curr_qty_result->fetch_assoc();
    $currentQuantity = $curr_qty_row['quantity'] ?? 0;  
    $curr_qty_stmt->close();

    $newQuantity = $currentQuantity + $newQuantity;


    if ($newQuantity > $stok) {
        echo json_encode(['status' => 'error', 'message' => 'Stok tidak cukup']);
        exit;
    }

    if ($newQuantity <= 0) {
        $sql = "DELETE FROM cart WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $book_id);
    } else {
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $newQuantity, $user_id, $book_id);
    }


    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Jumlah berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui jumlah']);
    }

} elseif ($action === 'remove') {
    $sql = "DELETE FROM cart WHERE user_id = ? AND book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $book_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Item berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus item.']);
    }
    $stmt->close();

} else {
    echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
}

$conn->close();