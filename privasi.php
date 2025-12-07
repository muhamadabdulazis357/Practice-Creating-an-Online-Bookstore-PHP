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
  <title>Kebijakan Privasi - Book Stairs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
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
    <img src="img/privasi" alt="Ilustrasi Kebijakan Privasi">
  </div>

  <div class="content">
    <h1>Kebijakan Privasi</h1>

    <p>Privasi Anda penting bagi kami. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan situs Book Stairs.</p>

    <h3>1. Informasi yang Kami Kumpulkan</h3>
    <ul>
      <li>Nama, email, dan informasi kontak lainnya saat Anda mendaftar.</li>
      <li>Informasi pesanan dan transaksi saat Anda berbelanja di situs kami.</li>
      <li>Data aktivitas penggunaan website seperti halaman yang dikunjungi dan waktu akses.</li>
    </ul>

    <h3>2. Penggunaan Informasi</h3>
    <p>Informasi yang dikumpulkan digunakan untuk:</p>
    <ul>
      <li>Mengelola akun dan pesanan Anda</li>
      <li>Meningkatkan layanan kami</li>
      <li>Mengirim pembaruan dan promosi jika Anda menyetujuinya</li>
    </ul>

    <h3>3. Perlindungan Data</h3>
    <p>Kami menjaga keamanan data Anda dengan sistem enkripsi dan akses terbatas hanya untuk pihak yang berwenang.</p>

    <h3>4. Hak Anda</h3>
    <p>Anda berhak untuk mengakses, memperbaiki, atau menghapus data pribadi Anda dari sistem kami kapan saja.</p>

    <h3>5. Perubahan Kebijakan</h3>
    <p>Kebijakan ini dapat diperbarui sewaktu-waktu. Perubahan akan diinformasikan melalui website kami.</p>

    <p>Jika Anda memiliki pertanyaan terkait privasi, silakan hubungi kami melalui kontak yang tersedia.</p>
  </div>

  <?php include 'footer.php'; ?>

</body>
</html>
