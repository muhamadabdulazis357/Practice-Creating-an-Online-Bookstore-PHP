<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal"]));
}

$user_id = $_SESSION['user_id'] ?? null;
if (!isset($user_id)) {
     header('Content-Type: application/json'); 
    die(json_encode([])); 
}


$sql = "SELECT c.quantity, b.id as book_id, b.judul, b.harga, b.gambar
        FROM cart c
        JOIN buku b ON c.book_id = b.id
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json'); 
echo json_encode($cartItems);

?>