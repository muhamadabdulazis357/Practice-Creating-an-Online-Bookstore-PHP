

<?php

// Memasukkan file konfigurasi yang biasanya berisi koneksi ke database
include 'config.php';

session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
body {
    font-family: "Poppins", sans-serif; /* Menggunakan font Poppins untuk tampilan modern */
    background-color: #f9f9f9; /* Warna latar belakang abu-abu terang */
    margin: 0; /* Menghilangkan margin bawaan browser */
    padding: 0; /* Menghilangkan padding bawaan browser */
    color: #333; /* Warna teks utama abu-abu tua */
}

/* Promo Banner */
.promo-banner {
    display: flex;
    justify-content: center;
    align-items: stretch;
    margin: 20px auto 40px;
    max-width: 1200px;
    gap: 20px;
}

.promo-left {
    flex: 3.5;
}

.promo-left img {
    width: 100%;
    height: 435px; /* Tinggi yang lebih lebar */
    object-fit: cover;
    border-radius: 15px;
}

.promo-right {
    flex: 1.8;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.promo-item {
    width: 100%;
    height: 210px; /* Lebih proporsional */
    border-radius: 15px;
    overflow: hidden;
}

.promo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

    </style>
</head>
<body>

    <header>
        <?php include 'header.php'; ?>
    </header>

     <!-- Promo Banner -->
     <div class="promo-banner">
        <div class="promo-left">
            <img src="img/iklan1" alt="Promo Besar">
        </div>
        <div class="promo-right">
            <div class="promo-item">
                <img src="img/iklan2" alt="Promo Kecil 1">
            </div>
            <div class="promo-item">
                <img src="img/iklan3" alt="Promo Kecil 2">
            </div>
        </div>
    </div>

<footer>
<?php include 'footer.php'; ?>
</footer>
       
</body>
</html>
