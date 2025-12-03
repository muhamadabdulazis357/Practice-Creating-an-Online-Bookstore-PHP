<?php
include 'config.php';
$kategoriQuery = mysqli_query($conn, "SELECT * FROM categories");

$cartCount = 0;  
if (isset($_SESSION['user_id'])) { 
    $user_id = $_SESSION['user_id'];
    $countSql = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param("i", $user_id);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $countRow = $countResult->fetch_assoc();
    $cartCount = $countRow['total'] ?? 0;
    $countStmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
/* HEADER */
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    height: 80px;
    display: flex;
    align-items: center;
    padding: 10px 20px;
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.logo img {
    height: 100px;
    width: auto;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 30px; /* Meningkatkan jarak antar menu dari 20px menjadi 30px */
    margin-right: 20px; /* Tambahkan margin kanan */
}

.nav-links a {
    color: #333;
    text-decoration: none;
    font-size: 15px;
    padding: 8px 12px;
    border-radius: 5px;
    transition: background-color 0.3s;
    white-space: nowrap; /* Mencegah text berpindah baris */
}

.nav-links a:hover {
    background-color: #f5f5f5;
}

.nav-item {
    position: relative;
}

.shop-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    border-radius: 5px;
    display: none;
    z-index: 100;
    padding: 15px;
}

.shop-dropdown ul {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 10px;
}

.shop-dropdown li {
    padding: 5px 10px;
    transition: 0.3s;
}

.shop-dropdown li a {
    text-decoration: none;
    color: #333;
    display: block;
}

.shop-dropdown li:hover {
    background: #f5f5f5;
}

/* SEARCH BAR */
.search-bar {
    position: relative;
    width: 100%;
    max-width: 300px;
    margin: 0 30px; /* Tambah margin di kedua sisi */
}

.search-bar input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 50px;
    font-size: 16px;
    transition: all 0.3s ease-in-out;
}

.search-bar input:hover {
    border-color: #007BFF;
}

.search-bar input:focus {
    outline: none;
    border-color: #007BFF;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* === CART ICON === */
.cart-icon {
    position: relative;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px 20px; /* Tambahkan padding kanan dan kiri */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
    margin: 0 20px; /* Tambahkan margin di kedua sisi */
}

.cart-icon i {
    font-size: 28px;
    color: #333;
    transition: 0.3s;
}

.cart-icon:hover i {
    color: #007BFF;
    transform: scale(1.1);
}

/* Badge jumlah item di cart */
#cart-count {
    position: absolute;
    top: -5px;
    right: 10px; /* Sesuaikan posisi */
    background: red;
    color: white;
    font-size: 14px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-weight: bold;
    transition: 0.3s;
}

.buttons {
    display: flex;
    align-items: center;
    gap: 15px; /* Meningkatkan jarak */
    padding-left: 10px; /* Tambahkan padding kiri */
}

.buttons span {
    margin-right: 10px; /* Tambahkan margin kanan untuk text username */
}

.buttons button {
    padding: 10px 20px; /* Tambahkan padding */
    border: none;
    border-radius: 5px;
    font-size: 15px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

/* Tombol Login */
.buttons .login {
    background-color: white;
    border: 2px solid #007BFF;
    color: #007BFF;
}

.buttons .login:hover {
    background-color: #007BFF;
    color: white;
}

/* Tombol Register */
.buttons .register {
    background-color: #007BFF;
    color: white;
}

.buttons .register:hover {
    background-color: #0056b3;
}

/* Tombol Logout */
.buttons .logout {
    background-color: #dc3545;
    color: white;
    margin-left: 10px; /* Tambahan margin kiri */
}

.buttons .logout:hover {
    background-color: #c82333;
}

body {
    padding-top: 90px;
}

/* Untuk layar yang lebih kecil */
@media (max-width: 1200px) {
    .nav-links {
        gap: 20px; /* Kurangi jarak pada layar lebih kecil */
        margin-right: 10px;
    }
    
    .search-bar {
        max-width: 200px;
        margin: 0 15px;
    }
    
    .cart-icon {
        margin: 0 10px;
        padding: 10px;
    }
}

@media (max-width: 992px) {
    .nav-links {
        gap: 15px; /* Kurangi jarak lagi pada layar lebih kecil */
        margin-right: 5px;
    }
    
    .nav-links a {
        font-size: 14px;
        padding: 6px 10px;
    }
    
    .search-bar {
        margin: 0 10px;
    }
    
    .cart-icon {
        margin: 0 5px;
    }
    
    .buttons {
        gap: 10px;
    }
}

/* SEARCH BAR */
.search-bar {
    position: relative;
    width: 100%;
    max-width: 200px;
    margin: 0 20px; /* Tambah margin kiri & kanan */
    display: flex;
    align-items: center;
}

.search-bar input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s ease-in-out;
    padding-right: 15px; /* Tambahkan ruang untuk ikon */
}

.search-bar input:hover,
.search-bar input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* SEARCH BUTTON */
.search-bar .search-btn {
    position: absolute;
    right: 1px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #555;
    font-size: 18px;
    padding: 5px;
    transition: color 0.3s ease-in-out;
}

.search-bar .search-btn:hover {
    color: #007BFF;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .search-bar {
        max-width: 250px;
        margin: 0 10px;
    }
    
    .search-bar input {
        font-size: 14px;
        padding: 10px;
    }
    
    .search-bar .search-btn {
        font-size: 16px;
    }
}

    </style>
</head>
<body>

<header>
    <div class="container">
    <div class="container">
    <div class="logo">
        <a href="index.php">
            <img src="img/logo.png" alt="Logo">
        </a>
    </div>
</div>

         <nav class="nav-links">
            <a href="#" class="shop-link" id="shopLink" style="font-size: 25px;">☰</a>
            <div class="shop-dropdown" id="shopDropdown">
                <ul>
                    <?php while ($kategori = mysqli_fetch_assoc($kategoriQuery)): ?>
                        <li><a href="books.php?kategori=<?= urlencode($kategori['name']); ?>"><?= htmlspecialchars($kategori['name']); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            
            <a href="about.php">Tentang Kami</a>
            <a href="contact.php">Kontak Kami</a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="pesanan_saya.php">Pesanan Saya</a>
            <?php endif; ?>
        </nav>

        <div class="search-bar">
    <form action="books.php" method="GET">
        <input type="text" name="search" placeholder="Cari Buku" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>


        <a href="keranjang.php" class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count"><?= $cartCount; ?></span>
        </a>


        <div class="buttons">
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                <span>Halo, <?= htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['admin_name']); ?>!</span>
                <a href="logout.php">
                    <button class="logout">Keluar</button>
                </a>
            <?php else: ?>
                <a href="login.php?form=login">
                    <button class="login">Masuk</button>
                </a>
                <a href="login.php?form=register">
                    <button class="register">Daftar</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    const shopLink = document.getElementById('shopLink');
    const shopDropdown = document.getElementById('shopDropdown');

    shopLink.addEventListener('click', function(e) {
        e.preventDefault();
        shopDropdown.style.display = (shopDropdown.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function(e) {
        if (!shopLink.contains(e.target) && !shopDropdown.contains(e.target)) {
            shopDropdown.style.display = 'none';
        }
    });

    function updateCartCount() {
      $.ajax({
        url: 'get_cart_count.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            $('#cart-count').text(response.count);
          }
        },
        error: function() {
          console.error("Gagal mengambil jumlah item di keranjang.");
        }
      });
    }
    document.addEventListener("DOMContentLoaded", updateCartCount);

</script>

</body>
</html>