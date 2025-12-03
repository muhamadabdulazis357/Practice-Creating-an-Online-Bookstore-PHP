<?php
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

include 'config.php';

// Ambil kategori & pencarian dari URL
$kategoriDipilih = isset($_GET['kategori']) ? $_GET['kategori'] : "Semua Buku";
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";

// Ambil daftar kategori dari database
$kategoriQuery = mysqli_query($conn, "SELECT name FROM categories");
$kategoriList = [];
while ($row = mysqli_fetch_assoc($kategoriQuery)) {
    $kategoriList[] = $row['name'];
}

// Buat query untuk filter berdasarkan kategori & pencarian
$sql = "SELECT * FROM buku WHERE 1";

if (!empty($searchQuery)) {
    $sql .= " AND (judul LIKE ? OR penulis LIKE ? OR kategori LIKE ?)";
}

if ($kategoriDipilih !== "Semua Buku" && in_array($kategoriDipilih, $kategoriList)) {
    $sql .= " AND kategori = ?";
}

$stmt = $conn->prepare($sql);

// Bind parameter sesuai kondisi
if (!empty($searchQuery) && $kategoriDipilih !== "Semua Buku" && in_array($kategoriDipilih, $kategoriList)) {
    $likeQuery = "%$searchQuery%";
    $stmt->bind_param("ssss", $likeQuery, $likeQuery, $likeQuery, $kategoriDipilih);
} elseif (!empty($searchQuery)) {
    $likeQuery = "%$searchQuery%";
    $stmt->bind_param("sss", $likeQuery, $likeQuery, $likeQuery);
} elseif ($kategoriDipilih !== "Semua Buku" && in_array($kategoriDipilih, $kategoriList)) {
    $stmt->bind_param("s", $kategoriDipilih);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .content {
            flex: 1;
        }

        .content {
    max-width: 1200px;
    margin: 40px auto 0 auto; /* Tambahkan margin atas agar tidak terlalu dekat dengan header */
    padding: 20px 40px; /* Tambahkan padding kiri-kanan */
}

        h2 {
    text-align: left; /* Biar judul kategori tetap agak ke kiri */
    margin-left: 35px; /* Beri sedikit jarak dari kiri */
}
        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: flex-start;
            padding-left: 35px; /* Tambahkan sedikit jarak kiri */
        }
        .book-card {
            background: white;
            padding: 8px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
            width: calc(20% - 12px);
            max-width: 150px;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .book-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
            transition: transform 0.3s ease-in-out;
        }
        .book-card .author {
            font-size: 11px;
            color: #777;
            margin-top: 5px;
        }
        .book-card .book-title {
            font-size: 14px;
            font-weight: bold;
            color: black;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 2px 0;
        }
        .book-card .rating {
            font-size: 10px;
            color: #f4c542;
        }
        .book-card .price {
            font-size: 12px;
            font-weight: 600;
        }
        .btn-buy {
            display: inline-block;
            padding: 6px 14px;
            background: linear-gradient(135deg, #007aff, #005ecb);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 3px 6px rgba(0, 122, 255, 0.3);
            border: none;
            cursor: pointer;
        }
        .btn-buy:hover {
            background: linear-gradient(135deg, #005ecb, #0047a3);
            box-shadow: 0 4px 10px rgba(0, 94, 203, 0.5);
            transform: translateY(-2px);
        }
        .empty-state {
            text-align: center;
            margin-top: 50px;
            font-size: 18px;
            color: #888;
        }
        .empty-state i {
            font-size: 50px;
            color: #ccc;
        }
    </style>
</head>
<body>
<header>
    <?php include 'header.php'; ?>
</header>


<main class="content">
        <h2><?php echo htmlspecialchars($kategoriDipilih); ?></h2>
        <div class="book-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $gambarBuku = (!empty($row['gambar']) && file_exists($row['gambar'])) ? $row['gambar'] : 'uploads/default-book.jpg';
                    $idBuku = $row['id'];

                    echo "<div class='book-card'>
                            <a href='detail_buku.php?id=$idBuku'>
                                <img src='$gambarBuku' alt='Gambar Buku'>
                            </a>
                            <p class='author'>Penulis: " . htmlspecialchars($row['penulis']) . "</p>
                            <p class='book-title'>" . htmlspecialchars($row['judul']) . "</p>
                            <p class='price'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                          </div>";
                }
            } else {
                echo "<div class='empty-state'>
                        <i class='fas fa-book-open'></i>
                        <p>Tidak ada buku dalam kategori ini.</p>
                      </div>";
            }
            ?>
        </div>
    </main>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
