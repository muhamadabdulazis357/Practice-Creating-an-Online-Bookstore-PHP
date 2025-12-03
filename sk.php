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
  <title>Syarat dan Ketentuan - Book Stairs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #fdfdfd;
      color: #333;
      line-height: 1.6;
    }

    .header-img-container {
      width: 100%;
      background-color: #01F9C6;
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
      padding: 30px;
    }

    h2 {
      color: #2c3e50;
      border-bottom: 2px solid #ddd;
      padding-bottom: 5px;
      text-align: center;
    }

    h3 {
      color: #2980b9;
      margin-top: 30px;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 8px;
    }

    p {
      margin: 10px 0;
    }

    a {
      color: #3498db;
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
  <img src="img/sk" alt="Ilustrasi Syarat dan Ketentuan">
</div>

<div class="content">
  <h2>📜 Syarat dan Ketentuan Penggunaan</h2>

  <h3>1. Ketentuan Umum</h3>
  <p>Dengan menggunakan layanan Book Stairs, Anda setuju untuk mematuhi semua syarat dan ketentuan yang berlaku. Kami berhak untuk mengubah syarat ini sewaktu-waktu tanpa pemberitahuan terlebih dahulu.</p>

  <h3>2. Akun Pengguna</h3>
  <ul>
    <li>Pengguna harus memberikan informasi yang benar dan akurat saat mendaftar.</li>
    <li>Setiap aktivitas yang dilakukan dengan akun Anda adalah tanggung jawab Anda sepenuhnya.</li>
    <li>Dilarang menggunakan akun untuk tujuan ilegal atau melanggar hukum.</li>
  </ul>

  <h3>3. Pemesanan dan Pembayaran</h3>
  <ul>
    <li>Pemesanan dianggap sah setelah Anda menyelesaikan proses pembayaran.</li>
    <li>Semua harga sudah termasuk PPN kecuali dinyatakan lain.</li>
    <li>Kami berhak membatalkan pesanan jika ada kesalahan harga atau stok.</li>
  </ul>

  <h3>4. Pengiriman</h3>
  <p>Kami akan mengirimkan produk sesuai estimasi waktu, namun keterlambatan karena pihak ekspedisi bukan tanggung jawab kami sepenuhnya.</p>

  <h3>5. Retur dan Refund</h3>
  <ul>
    <li>Retur hanya diterima maksimal 2 hari kerja setelah barang diterima.</li>
    <li>Barang harus dalam kondisi seperti saat diterima.</li>
    <li>Refund akan diproses 1–7 hari kerja setelah retur disetujui.</li>
  </ul>

  <h3>6. Hak Kekayaan Intelektual</h3>
  <p>Seluruh konten di website Book Stairs dilindungi oleh hak cipta dan tidak boleh digunakan tanpa izin tertulis dari kami.</p>

  <h3>7. Pembatasan Tanggung Jawab</h3>
  <p>Kami tidak bertanggung jawab atas kerusakan atau kerugian yang timbul dari penggunaan layanan kami secara langsung maupun tidak langsung.</p>

  <h3>8. Kontak</h3>
  <p>Untuk pertanyaan lebih lanjut, silakan hubungi kami melalui halaman <a href="contact.php">Hubungi Kami</a>.</p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
