<?php
include 'config.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Filter status pesanan jika ada
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Buat query untuk mengambil pesanan
$sql = "SELECT o.*, u.name as user_name FROM orders o 
        JOIN users u ON o.user_id = u.id";

if (!empty($status_filter)) {
    $sql .= " WHERE o.status = '$status_filter'";
}

$sql .= " ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $sql);
$total_orders = mysqli_num_rows($result);

// Hitung statistik pesanan
$pending_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'"))['count'];
$paid_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'paid'"))['count'];
$shipped_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'shipped'"))['count'];
$delivered_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'delivered'"))['count'];
$cancelled_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'cancelled'"))['count'];

// Update status pesanan
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE orders SET status = '$new_status' WHERE id = '$order_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        header('location: admin_orders.php');
        exit();
    } else {
        $error = "Gagal memperbarui status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f3f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            background: #1e293b;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .header nav {
            display: flex;
            gap: 13px;
        }
        .header a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .header a:hover {
            color: #38bdf8;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .page-title {
            text-align: center;
            color: #1e293b;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        /* Dashboard cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-title {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        .card-value {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }
        
        /* Filter tabs */
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 5px;
        }
        .filter-tab {
            padding: 10px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }
        .filter-tab.active {
            background: #38bdf8;
            color: white;
            border-color: #38bdf8;
        }
        .filter-tab:hover:not(.active) {
            background: #f1f1f1;
        }
        
        /* Orders table */
        .orders-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }
        th {
            background: #38bdf8;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background: #f9f9f9;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background: #ffe082;
            color: #f57c00;
        }
        .status-paid {
            background: #c8e6c9;
            color: #388e3c;
        }
        .status-shipped {
            background: #bbdefb;
            color: #1976d2;
        }
        .status-delivered {
            background: #c8e6c9;
            color: #2e7d32;
        }
        .status-cancelled {
            background: #ffcdd2;
            color: #d32f2f;
        }
        
        /* Buttons */
        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
            transition: all 0.3s;
        }
        .btn-detail {
            background: #38bdf8;
            color: white;
        }
        .btn-detail:hover {
            background: #0ea5e9;
        }
        
        /* Order detail modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-content {
            background: white;
            width: 100%;
            max-width: 700px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalFadeIn 0.3s;
        }
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title {
            font-weight: 600;
            margin: 0;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #777;
        }
        .modal-body {
            padding: 20px;
        }
        .update-status {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }
        .empty-state-icon {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 10px;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .orders-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 700px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
      <div>Admin Book Stairs</div>
      <nav>
         <a href="admin_page.php"><i class="fas fa-home"></i> Dashboard</a>
         <a href="admin_tambah_buku.php"><i class="fas fa-plus"></i> Tambah Buku</a>
         <a href="admin_daftar_buku.php"><i class="fas fa-book"></i> Daftar Buku</a>
         <a href="admin_manage_categories.php"><i class="fas fa-tags"></i> Tambah Kategori</a>
         <a href="admin_message.php"><i class="fas fa-comment"></i> Pesan</a>
         <a href="admin_users.php"><i class="fas fa-users"></i> Users</a>
         <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
         <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
   </div>
    
    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Kelola Pesanan</h1>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-title">Total Pesanan</div>
                <div class="card-value"><?php echo $total_orders; ?></div>
            </div>
            <div class="card">
                <div class="card-title">Menunggu Pembayaran</div>
                <div class="card-value"><?php echo $pending_count; ?></div>
            </div>
            <div class="card">
                <div class="card-title">Pembayaran Berhasil</div>
                <div class="card-value"><?php echo $paid_count; ?></div>
            </div>
            <div class="card">
                <div class="card-title">Dalam Pengiriman</div>
                <div class="card-value"><?php echo $shipped_count; ?></div>
            </div>
            <div class="card">
                <div class="card-title">Terkirim</div>
                <div class="card-value"><?php echo $delivered_count; ?></div>
            </div>
        </div>
        
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="admin_orders.php" class="filter-tab <?php echo empty($status_filter) ? 'active' : ''; ?>">Semua Pesanan</a>
            <a href="admin_orders.php?status=pending" class="filter-tab <?php echo $status_filter === 'pending' ? 'active' : ''; ?>">Menunggu Pembayaran</a>
            <a href="admin_orders.php?status=paid" class="filter-tab <?php echo $status_filter === 'paid' ? 'active' : ''; ?>">Pembayaran Berhasil</a>
            <a href="admin_orders.php?status=shipped" class="filter-tab <?php echo $status_filter === 'shipped' ? 'active' : ''; ?>">Dalam Pengiriman</a>
            <a href="admin_orders.php?status=delivered" class="filter-tab <?php echo $status_filter === 'delivered' ? 'active' : ''; ?>">Terkirim</a>
            <a href="admin_orders.php?status=cancelled" class="filter-tab <?php echo $status_filter === 'cancelled' ? 'active' : ''; ?>">Dibatalkan</a>
        </div>
        
        <!-- Orders Table -->
        <div class="orders-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                        $status_classes = [
                                            'pending' => 'status-pending',
                                            'paid' => 'status-paid',
                                            'shipped' => 'status-shipped',
                                            'delivered' => 'status-delivered',
                                            'cancelled' => 'status-cancelled'
                                        ];
                                        $status_labels = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'paid' => 'Pembayaran Berhasil',
                                            'shipped' => 'Dalam Pengiriman',
                                            'delivered' => 'Terkirim',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                    ?>
                                    <span class="status-badge <?php echo $status_classes[$row['status']]; ?>">
                                        <?php echo $status_labels[$row['status']]; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-detail" onclick="showOrderDetail(<?php echo $row['id']; ?>)">Detail</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Tidak ada pesanan</h3>
                    <p>Belum ada pesanan yang dibuat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Order Detail Modal -->
    <div id="orderDetailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Detail Pesanan</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="orderDetailContent">
                <!-- Konten akan diisi melalui AJAX -->
            </div>
        </div>
    </div>
    
    <script>
        // Fungsi untuk menampilkan modal detail pesanan
        function showOrderDetail(orderId) {
            var modal = document.getElementById("orderDetailModal");
            var content = document.getElementById("orderDetailContent");
            
            // Tampilkan modal
            modal.style.display = "flex";
            
            // Ambil detail pesanan menggunakan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_order_detail.php?id=" + orderId, true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    content.innerHTML = this.responseText;
                }
            };
            xhr.send();
        }
        
        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("orderDetailModal").style.display = "none";
        }
        
        // Tutup modal jika user mengklik di luar konten modal
        window.onclick = function(event) {
            var modal = document.getElementById("orderDetailModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>