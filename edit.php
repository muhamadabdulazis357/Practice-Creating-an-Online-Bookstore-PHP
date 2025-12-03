<?php
$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM buku WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();    
}

$kategoriResult = $conn->query("SELECT name FROM categories");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $penerbit = $_POST["penerbit"];
    $tahun_terbit = $_POST["tahun_terbit"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    $deskripsi = $_POST["deskripsi"];

    $query = "UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, kategori=?, harga=?, stok=?, deskripsi=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssiisi", $judul, $penulis, $penerbit, $tahun_terbit, $kategori, $harga, $stok, $deskripsi, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil diperbarui!'); window.location.href='admin_daftar_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui buku!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Data Buku</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" value="<?= htmlspecialchars($buku['judul']) ?>" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="<?= htmlspecialchars($buku['tahun_terbit']) ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <div class="form-group">
    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        if ($kategoriResult->num_rows > 0) {
            while ($row = $kategoriResult->fetch_assoc()) {
                $kategoriNama = $row['name'];
                $selected = ($kategoriNama == $buku['kategori']) ? 'selected' : '';
                echo "<option value=\"$kategoriNama\" $selected>$kategoriNama</option>";
            }
        } else {
            echo "<option value=\"\">Kategori belum tersedia</option>";
        }
        ?>
    </select>
</div>

            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" value="<?= htmlspecialchars($buku['harga']) ?>" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" value="<?= htmlspecialchars($buku['stok']) ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"><?= htmlspecialchars($buku['deskripsi']) ?></textarea>
            </div>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>