<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Toko Buku</title>
    <style>
        .footer {
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            border-top: 1px solid #333; /* Menambahkan garis pembatas di atas footer */
        }

        .footer-container {
            width: 80%;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-logo img {
            width: 200px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .footer-column ul {
            list-style-type: none;
            padding: 0;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-column ul li a:hover {
            text-decoration: underline;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="img/logo.png" alt="Logo Toko Buku" class="footer-logo-img">
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h3>Informasi</h3>
                    <ul>
                        <li><a href="about.php">Tentang Kami</a></li>
                        <li><a href="contact.php">Kontak Kami</a></li>
                        <li><a href="sk.php">Syarat & Ketentuan</a></li>
                        <li><a href="privasi.php">Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Bantuan</h3>
                    <ul>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="pembayaran.php">Pembayaran</a></li>
                        <li><a href="pengiriman.php">Pengiriman</a></li>
                        <li><a href="message.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
    <h3>Ikuti Kami</h3>
    <ul class="social-links">
        <li><a href="https://www.facebook.com/share/1AHzu3ju1s/"><i class="fab fa-facebook-f"></i></a></li>
        <li><a href="https://x.com/soyakurokawa01?t=FFUn67KUowczpDS5dmdLZw&s=08#"><i class="fab fa-twitter"></i></a></li>
        <li><a href="https://www.instagram.com/sadsia01?igsh=bmR0eXM3OGFsaHQx"><i class="fab fa-instagram"></i></a></li>
    </ul>
</div>
            </div>
        </div>
    </footer>

</body>
</html>
