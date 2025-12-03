<?php
include 'config.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Hapus user jika ada permintaan, tapi hanya user biasa (bukan admin)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id' AND user_type = 'user'") or die('Query gagal');
    header('location: admin_users.php');
}

// Ambil hanya pengguna biasa, bukan admin
$users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('Query gagal');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna | Admin</title>
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
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #38bdf8;
            color: white;
            font-weight: 600;
        }
        td {
            background: #f9f9f9;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Header & Navigasi -->
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

    <!-- Kontainer Daftar Pengguna -->
    <div class="container">
        <h2>Daftar Pengguna</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($users)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="admin_users.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Hapus user ini?');">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="admin_page.php" class="back-btn">Kembali ke Admin</a>
    </div>

</body>
</html>
