<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? null;
if (!isset($user_id)) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

// Ambil data pesanan
$orderSql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("ii", $order_id, $user_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows == 0) {
    die("Pesanan tidak ditemukan");
}

$orderData = $orderResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .success-container {
            max-width: 600px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        
        h2 {
            color: #28a745;
            margin-bottom: 15px;
        }
        
        .order-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }
        
        .order-details p {
            margin: 10px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 15px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h2>Pembayaran Berhasil!</h2>
        <p>Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses.</p>
        
        <div class="order-details">
            <p><strong>Order ID:</strong> #<?php echo $orderData['id']; ?></p>
            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($orderData['total_harga'], 0, ',', '.'); ?></p>
            <p><strong>Metode Pembayaran:</strong> <?php echo ucfirst($orderData['payment_method']); ?></p>
            <p><strong>Tanggal Pembayaran:</strong> <?php echo date('d F Y H:i', strtotime($orderData['payment_date'])); ?></p>
            <p><strong>Status:</strong> <span style="color: #28a745;">Berhasil</span></p>
        </div>
        
        <a href="pesanan_saya.php" class="btn">Lihat Pesanan Saya</a>
        <a href="index.php" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>