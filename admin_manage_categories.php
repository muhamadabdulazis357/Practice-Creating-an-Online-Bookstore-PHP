<?php
include 'config.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Tambah kategori
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $query = "INSERT INTO categories (name) VALUES ('$name')";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_manage_categories.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM categories WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_manage_categories.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Edit kategori
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $query = "UPDATE categories SET name = '$name' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_manage_categories.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil semua kategori
$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori | Admin</title>
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
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        input, button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .edit, .delete {
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            border: none;
        }
        .edit {
            background: #ffc107;
        }
        .edit:hover {
            background: #e0a800;
        }
        .delete {
            background: #dc3545;
        }
        .delete:hover {
            background: #c82333;
        }
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            position: relative;
        }
    </style>
    <script>
        function openModal(id, name) {
            console.log("Edit ID:", id, "Nama:", name); // Debugging
            document.getElementById("editModal").style.display = "flex";
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
        }
        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }
        window.onclick = function(event) {
            let modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
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

    <div class="container">
        <h2>Manajemen Kategori</h2>

        <form method="post">
            <input type="text" name="name" placeholder="Nama Kategori" required>
            <button type="submit" name="add">Tambah</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td class="actions">
                        <button class="edit" onclick="openModal(<?= $row['id']; ?>, '<?= htmlspecialchars($row['name']); ?>')">Edit</button>
                        <a href="admin_manage_categories.php?delete=<?= $row['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>Edit Kategori</h3>
            <form method="post">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="name" id="editName" required>
                <button type="submit" name="edit">Simpan</button>
                <button type="button"  onclick="closeModal()">Tutup</button>
            </form>
        </div>
    </div>

</body>
</html>
