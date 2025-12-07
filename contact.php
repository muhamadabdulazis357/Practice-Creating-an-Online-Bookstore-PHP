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
    <title>Hubungi Kami - Gramedia</title>
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
    
    /* Banner Image */
    .contact-banner {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: cover;
        margin-bottom: 30px;
    }
    
    /* Container */
    .contact-container {
        max-width: 1000px;
        margin: 20px auto 50px;
        padding: 0 20px;
    }
    
    /* Title */
    .contact-title {
        font-size: 32px;
        font-weight: 600;
        color: #222;
        margin-bottom: 30px;
    }
    
    /* Contact Options */
    .contact-options {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        flex-wrap: wrap;
    }
    
    /* Contact Card */
    .contact-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        flex: 1;
        min-width: 300px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }
    
    .contact-card h2 {
        font-size: 22px;
        color: #0087c3;
        margin-bottom: 15px;
    }
    
    .contact-card p {
        font-size: 14px;
        color: #555;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .contact-info {
        margin-bottom: 15px;
    }
    
    /* Button */
    .contact-button {
        background-color: #0087c3;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .contact-button:hover {
        background-color: #006da9;
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .contact-options {
            flex-direction: column;
        }
        
        .contact-card {
            width: 100%;
        }
    }
</style>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Konten -->
<div class="contact-container">
    <img src="img/contact" alt="Hubungi Kami" class="contact-banner">
    
    <h1 class="contact-title">Hubungi Kami</h1>
    
    <div class="contact-options">
        <!-- Live Chat -->
        <div class="contact-card">
            <h2><i class="fas fa-comments"></i> Live Chat</h2>
            <div class="contact-info">
                <p>Melayani pada pukul <strong>08:00 - 17:00 WIB</strong></p>
                <p>Dapatkan bantuan langsung dari tim customer service kami melalui WhatsApp.</p>
            </div>
            <button class="contact-button" onclick="window.location.href='https://wa.me/628123456789'">
                <i class="fab fa-whatsapp"></i> Chat via WhatsApp
            </button>
        </div>
        
        <!-- Email -->
        <div class="contact-card">
            <h2><i class="fas fa-envelope"></i> Email</h2>
            <div class="contact-info">
                <p>Alamat email: <strong>abcdefghijklmnopqrstuvwxyz@gmail.com</strong></p>
                <p>Melayani pada pukul <strong>08:00 - 17:00 WIB</strong></p>
                <p>Kirimkan pertanyaan, saran, atau keluhan Anda melalui email kami.</p>
            </div>
            <button class="contact-button" onclick="window.location.href='https://abcdefghijklmnopqrstuvwxyz@gmail.com'">
                <i class="fas fa-paper-plane"></i> Kirim Email
            </button>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>