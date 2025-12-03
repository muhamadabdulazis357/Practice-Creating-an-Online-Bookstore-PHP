<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Informasi Pengiriman - Book Stairs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      color: #333;
    }

    .header-img-container {
      width: 100%;
      background-color: #3498db;
      padding: 40px 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .header-img-container img {
      max-width: 600px;
      width: 90%;
      height: auto;
      border-radius: 10px;
    }

    .content {
      max-width: 800px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    h3 {
      color: #2980b9;
      margin-top: 30px;
    }

    p {
      line-height: 1.6;
    }

    a {
      color: #2980b9;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .content {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="header-img-container">
  <img src="img/pengiriman" alt="Ilustrasi Pengiriman">
</div>

<div class="content">
  <h1>Informasi Pengiriman</h1>

  <h3>Berapa biaya pengiriman yang dikenakan untuk setiap order?</h3>
  <p>Biaya pengiriman tergantu Buku yang di pilih dan jenis Ekspedisi yang digunakan.</p>

  <h3>Kenapa pesanan saya belum tiba di tujuan?</h3>
  <p>Durasi pengiriman tergantung jarak lokasi kamu dan layanan pengiriman yang digunakan. Silakan cek secara berkala, ya.</p>

  <h3>Jika produk yang diterima tidak sesuai, bagaimana?</h3>
  <p>
    Silakan kirim email ke 
    <a href="muhammadabdulazis104@gmail.com">muhammadabdulazis104@gmail.com</a>, 
    jelaskan kronologi dan sertakan video unboxing dari paket yang diterima, lalu tunggu balasan dari tim Customer Service. 
    Batas maksimal komplain adalah 14 hari sejak pesanan diterima.
  </p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
