<?php
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus gambar terkait jika ada
    $query = "SELECT gambar FROM buku WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    if ($gambar && file_exists($gambar)) {
        unlink($gambar); // Hapus gambar dari folder
    }

    // Hapus data buku
    $query = "DELETE FROM buku WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil dihapus!'); window.location.href='admin_daftar_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus buku!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>