<?php
// Koneksi ke database MySQL
$conn = new mysqli("localhost", "root", "", "db_shop");

// Cek apakah koneksi berhasil atau gagal
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memulai session untuk mengecek login admin
session_start();

// Cek apakah admin sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Menangani form jika dikirim (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menyimpan data dari form ke variabel
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $penerbit = $_POST["penerbit"];
    $tahun_terbit = $_POST["tahun_terbit"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    $deskripsi = $_POST["deskripsi"];

    // Menangani upload gambar
    $gambar = "";
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $target_dir = "uploads/"; // Direktori tujuan
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat folder jika belum ada
        }
        $gambar = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar); // Pindahkan file ke folder tujuan
    }

    // Simpan data buku ke tabel 'buku' di database
    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori, harga, stok, deskripsi, gambar) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Siapkan statement untuk mencegah SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiiss", $judul, $penulis, $penerbit, $tahun_terbit, $kategori, $harga, $stok, $deskripsi, $gambar);

    // Eksekusi perintah simpan
    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location.href='admin_tambah_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan buku!');</script>";
    }

    // Tutup statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>

    <!-- Ikon FontAwesome dan Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Reset dan set font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f4f4;
        }

        /* Header Admin */
        .header {
            background: #1e293b;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 17px;
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

        /* Form Tambah Buku */
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 40px auto;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }


        .form-group {
            text-align: left;
            margin-bottom: 12px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            font-size: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            transition: 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        textarea {
            resize: none;
            height: 60px;
        }

        .image-preview {
            display: none;
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-top: 10px;
        }

        button {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Header Navigasi Admin -->
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

    <!-- Form Tambah Buku -->
    <div class="container">
        <h2>Tambah Buku</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Input judul buku -->
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" required>
            </div>

            <!-- Input penulis -->
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" required>
            </div>

            <!-- Input penerbit -->
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit" required>
            </div>

            <!-- Input tahun terbit -->
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required>
            </div>

            <!-- Pilih kategori -->
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
    <option value="">Pilih Kategori</option>
    <?php
        $kategoriQuery = mysqli_query($conn, "SELECT * FROM categories");
        while ($kategori = mysqli_fetch_assoc($kategoriQuery)) {
            echo '<option value="' . htmlspecialchars($kategori['name']) . '">' . htmlspecialchars($kategori['name']) . '</option>';
        }
    ?>
</select>

            </div>

            <!-- Input harga -->
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" required>
            </div>

            <!-- Input stok -->
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" required>
            </div>

            <!-- Input deskripsi buku -->
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"></textarea>
            </div>

            <!-- Upload gambar buku -->
            <div class="form-group">
                <label>Upload Gambar</label>
                <input type="file" name="gambar" accept="image/*" onchange="previewImage(event)">
                <img id="image-preview" class="image-preview">
            </div>

            <!-- Tombol simpan -->
            <button type="submit">Simpan Buku</button>
        </form>
    </div>

    <script>
        // Fungsi preview gambar sebelum diupload
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>
</html>