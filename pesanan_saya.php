<?php
// Mulai session agar bisa akses data user yang login
session_start();

date_default_timezone_set('Asia/Jakarta'); // set timezone ke Jakarta
// Ambil ID user dari session (pastikan user sudah login)
$user_id = $_SESSION['user_id'] ?? null;

// Jika user belum login, redirect ke halaman login
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_shop");

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua pesanan milik user yang sedang login, diurutkan dari yang terbaru
$orderSql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("i", $user_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1100px;
    margin: 80px auto;
    padding: 20px;
}

/* Header */
.page-header {
            text-align: center;
            margin-bottom: 30px;
        }

/* Order List */
.order-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 kolom sejajar */
    gap: 20px;
    align-items: stretch; /* Memastikan kartu memiliki tinggi yang seragam */
}

h1{
    
}
/* Order Card */
.order-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 280px; /* Mengatur tinggi minimum agar sejajar */
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Order Header */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.order-date {
    font-size: 14px;
    color: #666;
}

.order-id {
    font-weight: 600;
}

/* Order Status */
.order-status {
    font-size: 14px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    text-align: center;
    white-space: nowrap;
}

/* Status Colors */
.status-pending { background: #FFF3CD; color: #856404; }
.status-paid { background: #D4EDDA; color: #155724; }
.status-shipped { background: #D1ECF1; color: #0C5460; }
.status-delivered { background: #C3E6CB; color: #155724; }
.status-cancelled { background: #F8D7DA; color: #721C24; }

/* Order Items */
.order-items {
    max-height: 220px;
    overflow-y: auto;
    margin: 15px 0;
    padding: 12px;
    border-radius: 5px;
    background: #fafafa;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #ececec;
}

.item-title {
    font-weight: 500;
    color: #333;
}

.item-price {
    color: #666;
    font-size: 14px;
}

.item-quantity {
    font-size: 14px;
    text-align: center;
    width: 50px;
    color: #666;
}

/* Order Footer */
.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #eee;
    margin-top: auto; /* Memastikan footer berada di bawah */
}

.order-total-price {
    font-size: 20px;
    font-weight: bold;
    color: #D32F2F;
}

/* Order Actions */
.order-actions {
    margin-top: 15px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Buttons */
.btn {
    padding: 10px 15px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.2s ease;
}

.btn-primary {
    background: #007BFF;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #0056b3;
}

/* Empty Order */
.empty-order {
    text-align: center;
    padding: 40px 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    grid-column: 1 / -1; /* Membuat elemen kosong memenuhi seluruh kolom */
}

.empty-icon {
    font-size: 60px;
    color: #ccc;
    margin-bottom: 20px;
}

/* Responsiveness */
@media (max-width: 768px) {
    .order-list {
        grid-template-columns: 1fr; /* Mengubah menjadi 1 kolom di layar kecil */
    }

    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .order-list {
        grid-template-columns: 1fr; /* Pastikan tetap 1 kolom pada layar ekstra kecil */
    }
}

    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
       
    
        <div class="order-list">
        <h1>Pesanan Saya</h1>
        <div class="page-header">
        </div>
            <?php if ($orderResult->num_rows > 0): ?>
                <?php while ($order = $orderResult->fetch_assoc()): ?>
                    
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-date">
                                    <?php echo date('d F Y H:i', strtotime($order['created_at'])); ?>
                                </div>
                                <div class="order-id">
                                    Order #<?php echo $order['id']; ?>
                                </div>
                            </div>
                            <div class="order-status status-<?php echo $order['status']; ?>">
                                <?php 
                                    $status_labels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Pembayaran Berhasil',
                                        'shipped' => 'Dalam Pengiriman',
                                        'delivered' => 'Terkirim',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                    echo $status_labels[$order['status']];
                                ?>
                            </div>
                        </div>
                        
                        <div class="order-items">
                            <?php 
                                // Ambil detail item pesanan
                                $itemSql = "SELECT * FROM order_items WHERE order_id = ?";
                                $itemStmt = $conn->prepare($itemSql);
                                $itemStmt->bind_param("i", $order['id']);
                                $itemStmt->execute();
                                $itemResult = $itemStmt->get_result();
                                
                                while ($item = $itemResult->fetch_assoc()):
                            ?>
                                <div class="order-item">
                                    <div class="item-detail">
                                        <div class="item-title"><?php echo $item['judul']; ?></div>
                                        <div class="item-price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></div>
                                    </div>
                                    <div class="item-quantity">
                                        x<?php echo $item['quantity']; ?>
                                    </div>
                                    <div class="item-subtotal">
                                        Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <div class="order-footer">
                            <div>
                                <div class="order-total-label">Total Pembayaran</div>
                                <?php if ($order['payment_method']): ?>
                                <div class="payment-info">
                                    Dibayar dengan <span class="payment-method"><?php echo ucfirst($order['payment_method']); ?></span>
                                    <?php if ($order['payment_date']): ?>
                                        pada <?php echo date('d F Y H:i', strtotime($order['payment_date'])); ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="order-total-price">
                                Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?>
                            </div>
                        </div>
                        
                        <div class="order-actions">
                            <?php if ($order['status'] == 'pending'): ?>
                                <a href="payment.php?order_id=<?php echo $order['id']; ?>" class="btn btn-primary">Bayar</a>
                            <?php endif; ?>
                           
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-order">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>Belum ada pesanan</h3>
                    <p>Anda belum memiliki pesanan apapun. Yuk, belanja sekarang!</p>
                    <a href="index.php" class="btn btn-primary">Belanja Sekarang</a>
                </div>
            <?php endif; ?>
        </div>
</body>
</html>