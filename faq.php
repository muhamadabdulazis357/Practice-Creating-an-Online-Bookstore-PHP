<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>FAQ Book Stairs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      background-color: #fdfdfd;
      color: #333;
      line-height: 1.6;
    }

    .faq-table-container {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
    }

    .faq-image-table {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      text-align: center;
    }

    .faq-img-small {
      width: 180px;
      height: auto;
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
      text-align: left;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 8px;
    }

    a {
      color: #3498db;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>

  <div class="faq-table-container">
    <table class="faq-image-table">
      <tr>
        <td><img src="img/faq.png" alt="Ilustrasi FAQ" class="faq-img-small"></td>
      </tr>
    </table>
  </div>

  <h2>❓ FAQ - Pertanyaan yang Sering Diajukan</h2>

  <h3>Apakah bisa melakukan Pengiriman ke Luar Negeri?</h3>
  <p>Bisa. Bukukita.com dapat mengirim ke Luar Negeri. Silakan tambahkan catatan di kolom <em>keterangan tambahan</em> saat checkout.</p>

  <h3>Apakah bisa melakukan penggantian alamat?</h3>
  <p>Bisa, <strong>asalkan proses pembayaran belum dilakukan</strong>. Hubungi admin segera untuk dibantu penggantiannya.</p>

  <h3>Bagaimana jika ingin menambah buku pada pesanan?</h3>
  <p>Penambahan buku bisa dilakukan <strong>selama status order belum diproses pembayaran atau pengiriman</strong> oleh ekspedisi.</p>

  <h3>Bagaimana cara mengetahui status pengiriman paket?</h3>
  <p>Cek langsung ke website ekspedisi berikut:</p>
  <ul>
    <li><a href="https://anteraja.id/">AnterAja</a></li>
    <li><a href="http://www.jne.co.id/">JNE</a></li>
    <li><a href="https://www.sicepat.com/">SiCepat</a></li>
  </ul>

  <h3>Bagaimana cara konfirmasi pembayaran?</h3>
  <p><strong>1. Jika melalui website Bukukita:</strong><br>
  Login > Transaksi > Konfirmasi Pembayaran (isi sesuai tanggal dan nominal)</p>
  <p><strong>2. Jika melalui WA atau Line:</strong><br>
  Kirim foto bukti transfer + format: <strong>Nama Pemesan + Kode Belanja</strong></p>

  <h3>Paket saya rusak/cacat/tidak sesuai, apakah bisa retur?</h3>
  <p><strong>1. Untuk Buku yang tidak sesuai:</strong><br>
  Bisa diretur. Kirim info terlebih dahulu via komentar pesan, WA atau Line maksimal <strong>2 hari kerja setelah paket diterima</strong>.</p>
  <p><strong>2. Untuk Buku Rusak/Cacat:</strong><br>
  Kirim foto buku yang rusak/cacat ke WA.</p>

  <h3>Bagaimana Syarat Proses Retur?</h3>
  <ul>
    <li>Sertakan catatan dalam paket: <strong>Nama + Kode Belanja + Alasan Retur</strong></li>
    <li>Kirim paket ke: <br>
      <strong>Bumi Permai Sentosa B6/57 Palasari Legok Kab.Tangerang Banten Jawa Barat<br>
      Telp: +62 82328662987</strong></li>
    <li>Konfirmasi nomor resi melalui komentar, WA, atau Line</li>
  </ul>

  <h3>Berapa estimasi retur buku?</h3>
  <p><strong>Maksimal 7 hari kerja</strong> sejak proses retur dilakukan.</p>

  <h3>Berapa lama proses refund (pengembalian uang)?</h3>
  <p>Estimasi pengembalian uang secara transfer <strong>1–2 hari kerja</strong> dan maksimal <strong>1 minggu</strong>.</p>

</body>

<footer>
  <?php include 'footer.php'; ?>
</footer>

</html>
