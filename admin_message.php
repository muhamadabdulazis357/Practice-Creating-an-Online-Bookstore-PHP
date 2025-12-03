<?php
include 'config.php';

session_start();

date_default_timezone_set('Asia/Jakarta'); // set timezone ke Jakarta

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit;
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_message.php');
   exit;
}

// Tambahkan kolom created_at jika belum ada
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM `message` LIKE 'created_at'");
if(mysqli_num_rows($check_column) == 0) {
   mysqli_query($conn, "ALTER TABLE `message` ADD `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages | Admin Panel</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <style>
      :root {
         --light-bg: #f5f5f5;
         --black: #333;
         --red: #e74c3c;
         --white: #fff;
         --blue: #3498db;
         --light-color: #666;
         --border: .1rem solid rgba(0,0,0,.2);
         --box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
      }
      
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Poppins', sans-serif;
         text-decoration: none;
         outline: none;
      }
      
      *::selection {
         background-color: var(--blue);
         color: var(--white);
      }
      
      html {
         font-size: 62.5%;
         overflow-x: hidden;
      }
      
      body {
         background-color: #f8f9fa;
      }
      
      .header {
         background: #1e293b;
         color: white;
         padding: 15px 20px;
         display: flex;
         justify-content: space-between;
         align-items: center;
         font-size: 18px;
         font-weight: 600;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }
      
      .header nav {
         display: flex;
         gap: 13px;
      }
      
      .header a {
         color: white;
         text-decoration: none;
         font-weight: 500;
         transition: 0.3s;
      }
      
      .header a:hover {
         color: #38bdf8;
      }
      
      .title {
         text-align: center;
         margin-bottom: 2rem;
         font-size: 3rem;
         color: #343a40;
         text-transform: uppercase;
         padding: 1rem 0;
      }
      
      .messages {
         max-width: 1200px;
         margin: 2rem auto;
         padding: 2rem;
      }
      
      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
         gap: 1.5rem;
      }
      
      .box {
         background-color: var(--white);
         border-radius: .5rem;
         padding: 2rem;
         box-shadow: var(--box-shadow);
         transition: transform 0.3s ease;
      }
      
      .box:hover {
         transform: translateY(-5px);
      }
      
      .box p {
         padding: 1rem 0;
         font-size: 1.6rem;
         color: var(--light-color);
         line-height: 1.8;
      }
      
      .box p span {
         color: var(--black);
      }
      
      .empty {
         padding: 1.5rem;
         text-align: center;
         border: var(--border);
         background-color: var(--white);
         color: var(--red);
         font-size: 2rem;
      }
      
      .delete-btn {
         margin-top: 1rem;
         display: inline-block;
         padding: 1rem 3rem;
         font-size: 1.6rem;
         color: var(--white);
         background-color: var(--red);
         border-radius: .5rem;
         cursor: pointer;
         text-transform: capitalize;
      }
      
      .delete-btn:hover {
         background-color: #c0392b;
      }
      
      .alert {
         position: fixed;
         top: 10%;
         left: 50%;
         transform: translateX(-50%);
         padding: 1.5rem;
         border-radius: .5rem;
         color: var(--white);
         font-size: 1.8rem;
         text-align: center;
         z-index: 10000;
         display: none;
      }
      
      .alert.success {
         background-color: #2ecc71;
      }
      
      .alert.error {
         background-color: var(--red);
      }
      
      .loading {
         position: fixed;
         top: 0;
         left: 0;
         height: 100%;
         width: 100%;
         background-color: rgba(0,0,0,0.5);
         z-index: 10000;
         display: flex;
         align-items: center;
         justify-content: center;
         display: none;
      }
      
      .loading img {
         height: 8rem;
         width: 8rem;
      }
      
      .message-date {
         font-size: 1.4rem;
         color: #718096;
         font-style: italic;
         text-align: right;
         margin-bottom: 1rem;
      }
   </style>
</head>
<body>
   
   <!-- Header section -->
   <div class="header">
      <div>Admin Book Stairs</div>
      <nav>
         <a href="admin_page.php"><i class="fas fa-home"></i> Dashboard</a>
         <a href="admin_tambah_buku.php"><i class="fas fa-plus"></i> Tambah Buku</a>
         <a href="admin_daftar_buku.php"><i class="fas fa-book"></i> Daftar Buku</a>
         <a href="admin_manage_categories.php"><i class="fas fa-tags"></i> Tambah Kategori</a>
         <a href="admin_message.php"><i class="fas fa-comment"></i> Pesan</a>
         <a href="admin_users.php"><i class="fas fa-users"></i> Users</a>
         <a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
         <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
   </div>

   <!-- Alert messages -->
   <div class="alert" id="alert"></div>
   
   <!-- Loading spinner -->
   <div class="loading" id="loading">
      <img src="images/loader.gif" alt="Loading...">
   </div>

   <!-- Messages section -->
   <section class="messages">
      <h1 class="title">Messages</h1>

      <div class="box-container" id="message-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message` ORDER BY id DESC") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
            // Format date untuk tampilan seperti di gambar kedua (20 Apr 2025 23:43)
            $date_display = '';
            if(isset($fetch_message['created_at']) && !empty($fetch_message['created_at'])) {
               // Menggunakan DateTime untuk format yang benar
               $date = new DateTime($fetch_message['created_at']);
               // Format: "d M Y H:i" - contoh: 20 Apr 2025 23:43
               $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
               $day = $date->format('d');
               $month = $month_names[$date->format('n') - 1];
               $year = $date->format('Y');
               $time = $date->format('H:i');
               $date_display = "$day $month $year $time";
            } else {
               // Jika created_at tidak ada atau kosong, gunakan waktu saat ini
               $now = new DateTime();
               $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
               $day = $now->format('d');
               $month = $month_names[$now->format('n') - 1];
               $year = $now->format('Y');
               $time = $now->format('H:i');
               $date_display = "$day $month $year $time";
            }
   ?>
   <div class="box message-box" data-id="<?php echo $fetch_message['id']; ?>">
      <p>User ID: <span><?php echo $fetch_message['id']; ?></span></p>
      <p>Name: <span><?php echo $fetch_message['name']; ?></span></p>
      <p>Number: <span><?php echo $fetch_message['number']; ?></span></p>
      <p>Email: <span><?php echo $fetch_message['email']; ?></span></p>
      <p>Message: <span><?php echo $fetch_message['message']; ?></span></p>
      
      <div class="message-date">
         <i class="fas fa-calendar-alt"></i> <?php echo $date_display; ?>
      </div>
      
      <a href="javascript:void(0);" 
         onclick="deleteMessage(<?php echo $fetch_message['id']; ?>)" 
         class="delete-btn">Delete Message</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no messages!</p>';
      }
   ?>
</div>
   </section>

   <!-- Custom admin JS file -->
   <script>
      // Show alert function
      function showAlert(message, type = 'success') {
         const alert = document.getElementById('alert');
         alert.textContent = message;
         alert.className = `alert ${type}`;
         alert.style.display = 'block';
         
         setTimeout(() => {
            alert.style.display = 'none';
         }, 3000);
      }
      
      // Show loading spinner
      function showLoading() {
         document.getElementById('loading').style.display = 'flex';
      }
      
      // Hide loading spinner
      function hideLoading() {
         document.getElementById('loading').style.display = 'none';
      }
      
      // Delete message function (using AJAX)
      function deleteMessage(id) {
         if(confirm('Are you sure you want to delete this message?')) {
            showLoading();
            
            // Create AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `admin_message.php?delete=${id}`, true);
            
            xhr.onload = function() {
               if(this.status === 200) {
                  // Remove the message box from DOM
                  const messageBox = document.querySelector(`.message-box[data-id="${id}"]`);
                  if(messageBox) {
                     messageBox.remove();
                  }
                  
                  showAlert('Message deleted successfully');
                  
                  // Check if there are no more messages
                  const messageContainer = document.getElementById('message-container');
                  if(messageContainer.children.length === 0) {
                     messageContainer.innerHTML = '<p class="empty">You have no messages!</p>';
                  }
               } else {
                  showAlert('Failed to delete message', 'error');
               }
               hideLoading();
            };
            
            xhr.onerror = function() {
               showAlert('Request error', 'error');
               hideLoading();
            };
            
            xhr.send();
         }
      }
      
      // Add active class to current menu item
      document.addEventListener('DOMContentLoaded', function() {
         const currentPage = window.location.pathname.split('/').pop();
         const navLinks = document.querySelectorAll('nav a');
         
         navLinks.forEach(link => {
            const linkHref = link.getAttribute('href');
            if(linkHref === currentPage) {
               link.style.color = '#38bdf8';
            }
         });
      });
   </script>

</body>
</html>