<?php
$conn = new mysqli("localhost", "root", "", "db_shop");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

$kategoriQuery = "SELECT DISTINCT kategori FROM buku";
$kategoriResult = $conn->query($kategoriQuery);

$search = isset($_GET['search']) ? $_GET['search'] : '';

$bukuQuery = "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ?";
$stmt = $conn->prepare($bukuQuery);
$searchParam = "%$search%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title>Daftar Buku</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f4f4f4;
            padding-top: 70px;
        }

        /* Header Fixed di Atas */
        .header {
            background: #1e293b;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 19px;
            font-weight: 600;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
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
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .search-bar {
            display: flex;
            margin-bottom: 15px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        .search-bar button {
            padding: 10px 15px;
            border: none;
            background: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
        }

        .category {
            margin-top: 20px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #ddd;
            background: #fff;
        }

        .category-header {
            background: #007bff;
            color: white;
            padding: 12px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .category-content {
            display: none;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
        }

        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            transition: 0.3s;
            display: inline-block;
        }

        .edit { background: #ffc107; }
        .edit:hover { background: #e0a800; }
        .delete { background: #dc3545; }
        .delete:hover { background: #c82333; }
    </style>
    <script>
        function toggleCategory(element) {
            const content = element.nextElementSibling;
            content.style.display = content.style.display === "block" ? "none" : "block";
        }
    </script>
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

    <div class="container">
        <h2>Daftar Buku</h2>

        <!-- Search Bar -->
        <form class="search-bar" method="GET">
            <input type="text" name="search" placeholder="Cari buku berdasarkan judul, penulis, atau penerbit..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cari</button>
        </form>

        <a href="admin_tambah_buku.php" class="btn edit" style="margin-bottom: 15px;">Tambah Buku</a>

        <?php if ($search): ?>
            <h3>Hasil Pencarian: "<?= htmlspecialchars($search) ?>"</h3>
            <table>
                <tr><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Harga</th><th>Aksi</th></tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['penulis']) ?></td>
                        <td><?= htmlspecialchars($row['penerbit']) ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href='edit.php?id=<?= $row['id'] ?>' class='btn edit'>Edit</a>
                            <a href='hapus.php?id=<?= $row['id'] ?>' class='btn delete' onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <?php while ($kategoriRow = $kategoriResult->fetch_assoc()): ?>
    <div class="category">
        <div class="category-header" onclick="toggleCategory(this)">
            <span><?= htmlspecialchars($kategoriRow['kategori']) ?></span>
        </div>
        <div class="category-content">
            <table>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
                <?php
                // Query buku berdasarkan kategori saat ini
                $kategori = $kategoriRow['kategori'];
                $bukuKategoriQuery = "SELECT * FROM buku WHERE kategori = ?";
                $stmtKategori = $conn->prepare($bukuKategoriQuery);
                $stmtKategori->bind_param("s", $kategori);
                $stmtKategori->execute();
                $bukuKategoriResult = $stmtKategori->get_result();

                while ($row = $bukuKategoriResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['penulis']) ?></td>
                        <td><?= htmlspecialchars($row['penerbit']) ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href='edit.php?id=<?= $row['id'] ?>' class='btn edit'>Edit</a>
                            <a href='hapus.php?id=<?= $row['id'] ?>' class='btn delete' onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
<?php endwhile; ?>

        <?php endif; ?>
    </div>

</body>  
</html>
