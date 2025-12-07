<?php
include 'config.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Keamanan tambahan
session_regenerate_id(true);

// Query gabungan untuk optimasi
$sql = "
   SELECT 'users' AS type, COUNT(*) AS count FROM users WHERE user_type = 'user'
   UNION ALL
   SELECT 'admins', COUNT(*) FROM users WHERE user_type = 'admin'
   UNION ALL
   SELECT 'orders', COUNT(*) FROM orders WHERE status = 'paid'
   UNION ALL
   SELECT 'products', COUNT(*) FROM buku
   UNION ALL
   SELECT 'messages', COUNT(*) FROM message
";
$result = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['type']] = $row['count'];
}
$total_all_users = $data['users'] + $data['admins'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

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
         flex-wrap: wrap;
      }
      .header nav {
         display: flex;
         gap: 13px;
         flex-wrap: wrap;
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

      .dashboard {
         max-width: 1200px;
         margin: 40px auto;
         background: white;
         padding: 30px;
         border-radius: 12px;
         box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      }
      .title {
         text-align: center;
         color: #1e293b;
         font-size: 28px;
         font-weight: 700;
         margin-bottom: 30px;
      }
      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
         gap: 20px;
      }
      .box {
         background: #fff;
         color: #333;
         padding: 20px;
         border-radius: 12px;
         text-align: center;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
         transition: all 0.3s ease-in-out;
         border-left: 5px solid #38bdf8;
      }
      .box:hover {
         transform: translateY(-5px);
         box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      }
      .box i {
         font-size: 30px;
         margin-bottom: 10px;
      }
      .box h3 {
         margin: 0;
         font-size: 22px;
         font-weight: 600;
      }
      .box p {
         margin: 5px 0 0;
         font-size: 15px;
         font-weight: 400;
         opacity: 0.8;
      }

      .box:nth-child(1) { border-left-color: #10b981; } /* Hijau: Pesanan */
      .box:nth-child(2) { border-left-color: #f59e0b; } /* Kuning: Produk */
      .box:nth-child(3) { border-left-color: #14A3C7; } /* Biru Muda: Message */
      .box:nth-child(4) { border-left-color: #3b82f6; } /* Biru: User */
      .box:nth-child(5) { border-left-color: #ef4444; } /* Merah: Admin */
      .box:nth-child(6) { border-left-color: #6366f1; } /* Ungu: Semua Users */

      @media (max-width: 768px) {
         .header {
            flex-direction: column;
            align-items: flex-start;
         }
         .header nav {
            flex-direction: column;
            gap: 10px;
            width: 100%;
         }
      }
   </style>
</head>
<body>
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

   <section class="dashboard">
      <h1 class="title">DASHBOARD</h1>
      <div class="box-container">
         <div class="box">
            <i class="fas fa-shopping-bag" style="color:#10b981;"></i>
            <h3><?= $data['orders']; ?></h3>
            <p>Pesanan Berhasil</p>
         </div>
         <div class="box">
            <i class="fas fa-box-open" style="color:#f59e0b;"></i>
            <h3><?= $data['products']; ?></h3>
            <p>Produk Ditambahkan</p>
         </div>
         <div class="box">
            <i class="fas fa-comment" style="color:#14A3C7;"></i>
            <h3><?= $data['messages']; ?></h3>
            <p>Message</p>
         </div>
         <div class="box">
            <i class="fas fa-user" style="color:#3b82f6;"></i>
            <h3><?= $data['users']; ?></h3>
            <p>Normal Users</p>
         </div>
         <div class="box">
            <i class="fas fa-user-shield" style="color:#ef4444;"></i>
            <h3><?= $data['admins']; ?></h3>
            <p>Admin Users</p>
         </div>
         <div class="box">
            <i class="fas fa-users" style="color:#6366f1;"></i>
            <h3><?= $total_all_users; ?></h3>
            <p>Total Semua Pengguna</p>
         </div>
      </div>
   </section>
</body>
</html>