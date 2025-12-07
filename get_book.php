<?php
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT id, judul, harga, gambar, stok FROM buku WHERE id = $id"); 
    if ($result->num_rows > 0) {
        $buku = $result->fetch_assoc();
        $buku['gambar'] = (!empty($buku['gambar']) && file_exists($buku['gambar'])) ? $buku['gambar'] : 'uploads/default-book.jpg';
        echo json_encode($buku);
    } else {
        echo json_encode(null);
    }
}
?>