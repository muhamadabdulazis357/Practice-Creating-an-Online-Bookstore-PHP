<?php
// Mulai session
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_shop");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah request-nya POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: checkout.php");
    exit();
}

// Ambil ID user dari session
$userId = $_SESSION['user_id'] ?? null;

// Jika user belum login, arahkan ke halaman login
if (!$userId) {
    header("Location: login.php"); 
    exit();
}

// Ambil dan sanitasi data dari form
$namaPenerima   = mysqli_real_escape_string($conn, $_POST['namaPenerima'] ?? '');
$noTelp         = mysqli_real_escape_string($conn, $_POST['noTelp'] ?? '');
$label          = mysqli_real_escape_string($conn, $_POST['label'] ?? '');
$lokasi         = mysqli_real_escape_string($conn, $_POST['lokasi'] ?? '');
$kodePos        = mysqli_real_escape_string($conn, $_POST['kodePos'] ?? '');
$alamatLengkap  = mysqli_real_escape_string($conn, $_POST['alamatLengkap'] ?? '');

// Ambil parameter beli sekarang jika ada
$buyNowId   = $_POST['buy_now_id'] ?? null;
$buyNowQty  = $_POST['buy_now_qty'] ?? 1;

// Validasi input tidak boleh kosong
if (empty($namaPenerima) || empty($noTelp) || empty($label) || empty($lokasi) || empty($kodePos) || empty($alamatLengkap)) {
    $error = urlencode("Semua kolom alamat wajib diisi!");
    // Redirect sesuai konteks beli sekarang atau tidak
    if ($buyNowId) {
        header("Location: checkout.php?id=$buyNowId&quantity=$buyNowQty&error=$error");
    } else {
        header("Location: checkout.php?error=$error");
    }
    exit();
}

// Cek apakah alamat untuk user ini sudah ada
$cekSql = "SELECT id FROM alamat WHERE id_user = ?";
$cekStmt = $conn->prepare($cekSql);
$cekStmt->bind_param("i", $userId);
$cekStmt->execute();
$cekResult = $cekStmt->get_result();

// Jika data alamat user sudah ada, lakukan update
if ($cekResult->num_rows > 0) {
    $sql = "UPDATE alamat 
            SET nama_penerima = ?, no_telp = ?, label = ?, lokasi = ?, kode_pos = ?, alamat_lengkap = ?, created_at = NOW() 
            WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $namaPenerima, $noTelp, $label, $lokasi, $kodePos, $alamatLengkap, $userId);
} else {
    // Jika belum ada, lakukan insert data baru
    $sql = "INSERT INTO alamat (id_user, nama_penerima, no_telp, label, lokasi, kode_pos, alamat_lengkap, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $userId, $namaPenerima, $noTelp, $label, $lokasi, $kodePos, $alamatLengkap);
}

// Jalankan query insert/update dan cek hasilnya
if ($stmt->execute()) {
    $success = urlencode("Alamat berhasil disimpan");
    if ($buyNowId) {
        header("Location: checkout.php?id=$buyNowId&quantity=$buyNowQty&success=$success");
    } else {
        header("Location: checkout.php?success=$success");
    }
    exit();
} else {
    $error = urlencode("Gagal menyimpan alamat: " . $stmt->error);
    if ($buyNowId) {
        header("Location: checkout.php?id=$buyNowId&quantity=$buyNowQty&error=$error");
    } else {
        header("Location: checkout.php?error=$error");
    }
    exit();
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>