<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<style>
    /* Global Style */
body {
    font-family: "Poppins", sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Container */
.about-container {
    max-width: 800px;
    margin: 10px auto 50px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: left;
}

/* Banner Image */
.about-banner {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* Title */
.about-title {
    font-size: 32px;
    font-weight: 600;
    color: #222;
    margin-bottom: 10px;
    text-align: center;
}

.about-subtitle {
    font-size: 24px;
    font-weight: 500;
    color: #00ab9f;
    margin-top: 20px;
}

/* Description */
.about-description {
    font-size: 16px;
    color: #555;
    line-height: 1.8;
}

/* Highlight */
.highlight {
    font-weight: 600;
    color: #00ab9f;
}

/* List */
.about-list {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.about-list li {
    font-size: 16px;
    color: #444;
    padding: 8px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Social Media */
.social-media {
    margin-top: 30px;
    text-align: center;
}

.social-media h3 {
    font-size: 20px;
    margin-bottom: 15px;
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-icons a {
    color: #fff;
    background: #00ab9f;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    background: #008c82;
    transform: translateY(-3px);
}

/* Ending */
.about-ending {
    font-size: 18px;
    font-weight: 500;
    margin-top: 30px;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .about-container {
        width: 90%;
        padding: 20px;
    }
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<!-- Header -->
<?php include 'header.php'; ?>

<!-- Konten -->
<div class="about-container">
    <img src="img/tentang kami" alt="Gramedia Banner" class="about-banner">
    
    <div class="about-content">
        <h1 class="about-title">Tentang Kami</h1>
        <p class="about-description">
            Sekilas informasi mengenai <span class="highlight">Book stairs</span>
        </p>
        
        <h2 class="about-subtitle">Apa itu Book stairs?</h2>
        <p class="about-description">
        Book stairs adalah toko buku online terbesar dan terlengkap di Indonesia yang menyediakan aneka buku berkualitas, alat tulis, hingga perlengkapan kantor lainnya.
        </p>
        
        <p class="about-description">
            Sejak tahun 2009 Book stairs membangun toko online. Toko ini merupakan bagian dari Toko Book stairs Matraman.
        </p>

        <p class="about-description">
            Pada tahun 2016 hingga saat ini, Book stairs dikelola oleh PT. Book stairs Asri Media. Kini Book stairs telah terintegrasi dengan lebih dari 100 cabang toko Book stairs se-Indonesia. Para pelanggan dapat berbelanja dan melakukan pembelian dari Book stairs terdekat di kota Anda. Dan pengiriman pun dapat dilakukan dari seluruh toko Book stairs se-Indonesia.
        </p>

        <h2 class="about-subtitle">Misi Kami</h2>
        <p class="about-description">
            Misi kami adalah meningkatkan literasi dan memberikan kemudahan akses pada dunia pengetahuan di seluruh Indonesia dengan memanfaatkan teknologi.
        </p>

        <h2 class="about-subtitle">Komitmen Kami</h2>
        <p class="about-description">
            Kenyamanan dan kepuasan para pelanggan merupakan prioritas kami. Kami ingin memberikan pengalaman yang lebih baik kepada para pelanggan saat belanja online maupun offline, dengan terus mengembangkan fitur-fitur produk. Memberikan pelayanan yang terbaik menjadi tujuan kami dengan dukungan manajemen yang proaktif dan kreatif.
        </p>
        
        <p class="about-description">
            Book stairs dapat diakses melalui website maupun aplikasi. Silakan unduh aplikasi di Google Play Store atau Apple App Store.
        </p>
</div>
</div>

       <footer>
         <!-- Footer -->
        <?php include 'footer.php'; ?>
       </footer>
</body>
</html>
