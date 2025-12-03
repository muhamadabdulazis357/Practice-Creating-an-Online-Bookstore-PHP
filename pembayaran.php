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
  <title>Informasi Pembayaran - Book Stairs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      color: #333;
    }

    .header-img-container {
      width: 100%;
      background-color: #1abc9c;
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
      color: #16a085;
      margin-top: 30px;
    }

    p, li {
      line-height: 1.6;
    }

    ul {
      padding-left: 20px;
    }

    a {
      color: #16a085;
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
  <img src="img/pembayaran" alt="Ilustrasi Pembayaran">
</div>

<div class="content">
  <h1>Informasi Pembayaran</h1>

  <h3>Batas waktu pembayaran?</h3>
  <p>Jenis pembayaran yang bisa dipilih.</p>
  <ul>
    <li><strong>OVO</strong>
    <li><strong>Gopay</strong>
    <li><strong>Shopee Pay</strong>
  </ul>

  <h3>Saya sudah transfer, tapi kenapa status pesanan masih pending?</h3>
  <p>Silakan kirim nomor order dan bukti pembayaran kamu melalui e-mail ke 
    <a href="muhammadabdulazis104@gmail.com">muhammadabdulazis104@gmail.com</a> 
    atau kunjungi 
    <a href="contact.php" target="_blank">halaman kontak kami</a> agar bisa kami bantu cek, ya.
  </p>

  <h3>Saya menerima email tentang pengembalian dana, apa yang harus saya lakukan?</h3>
  <p>Silakan balas e-mail tersebut dengan mengisi formulir yang sudah disediakan. Lengkapi informasi mulai dari bank penerima dana, nomor rekening, dan info cabang bank.</p>

  <h3>Berapa lama proses pengembalian dana?</h3>
  <p>Proses pengembalian dana biasanya berlangsung maksimum 10–14 hari.</p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
