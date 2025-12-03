<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit();
}

if(isset($_POST['send'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'Message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'Message sent successfully!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

   <style>
   .message-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10000;
   }
   
   .message{
      background-color: #fff;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 300px;
      position: relative;
   }

   .message span{
      font-size: 1.2rem;
      color: #333;
      display: block;
      margin-bottom: 1rem;
   }

   .message i{
      cursor: pointer;
      color: #dc3545;
      font-size: 1.5rem;
      position: absolute;
      top: 10px;
      right: 10px;
   }

   .message i:hover{
      transform: rotate(90deg);
   }
   
   section.contact {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem 1rem;
      min-height: 70vh;
   }
   
   .contact form{
      width: 100%;
      max-width: 500px;
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin: 0 auto;
      border: 1px solid #e0e0e0;
   }
   
   .contact form h3{
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
      color: #333;
      font-weight: normal;
   }
   
   .contact form .box{
      width: 95%;
      margin: 0.7rem auto;
      padding: 0.8rem 1rem;
      border: 1px solid #ccc;
      font-size: 1rem;
      color: #495057;
      border-radius: 4px;
      background: #ffffff;
      display: block;
   }
   
   .contact form textarea{
      height: 10rem;
      resize: none;
   }
   
   .btn{
      display: block;
      width: 95%;
      margin: 1rem auto;
      cursor: pointer;
      border-radius: 4px;
      font-size: 1rem;
      padding: 0.8rem;
      background: #4a6bff;
      color: #ffffff;
      text-align: center;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
   }
   
   .btn:hover{
      background: #3451d1;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
   }
   
   .form-error{
      color: #dc3545;
      font-size: 0.8rem;
      display: none;
      margin-left: 2.5%;
      margin-bottom: 0.5rem;
   }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<!-- Center Modal Messages -->
<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message-overlay">
         <div class="message">
            <span>'.$msg.'</span>
            <i class="fas fa-times" onclick="this.parentElement.parentElement.remove();"></i>
         </div>
      </div>
      ';
   }
}
?>

<section class="contact">
   <form action="" method="post" id="contactForm">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box" id="name">
      <span class="form-error" id="name-error">Please enter a valid name</span>
      
      <input type="email" name="email" required placeholder="enter your email" class="box" id="email">
      <span class="form-error" id="email-error">Please enter a valid email address</span>
      
      <input type="number" name="number" required placeholder="enter your number" class="box" id="number">
      <span class="form-error" id="number-error">Please enter a valid phone number</span>
      
      <textarea name="message" class="box" placeholder="enter your message" id="message" cols="30" rows="10" required></textarea>
      <span class="form-error" id="message-error">Message cannot be empty</span>
      
      <button type="submit" name="send" class="btn" id="submit-btn">send message</button>
   </form>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link -->
<script>
document.addEventListener('DOMContentLoaded', function() {
   const contactForm = document.getElementById('contactForm');
   const nameInput = document.getElementById('name');
   const emailInput = document.getElementById('email');
   const numberInput = document.getElementById('number');
   const messageInput = document.getElementById('message');
   
   const nameError = document.getElementById('name-error');
   const emailError = document.getElementById('email-error');
   const numberError = document.getElementById('number-error');
   const messageError = document.getElementById('message-error');
   
   // Form validation function
   function validateForm(e) {
      let isValid = true;
      
      // Validate name (at least 2 characters)
      if (nameInput.value.trim().length < 2) {
         nameError.style.display = 'block';
         nameInput.style.borderColor = '#dc3545';
         isValid = false;
      } else {
         nameError.style.display = 'none';
         nameInput.style.borderColor = '';
      }
      
      // Validate email
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(emailInput.value)) {
         emailError.style.display = 'block';
         emailInput.style.borderColor = '#dc3545';
         isValid = false;
      } else {
         emailError.style.display = 'none';
         emailInput.style.borderColor = '';
      }
      
      // Validate phone number (at least 10 digits)
      const numberLength = numberInput.value.trim().length;
if (numberLength < 10 || numberLength > 13) {
   numberError.style.display = 'block';
   numberInput.style.borderColor = '#dc3545';
   isValid = false;
} else {
   numberError.style.display = 'none';
   numberInput.style.borderColor = '';
}
      
      // Validate message (not empty)
      if (messageInput.value.trim() === '') {
         messageError.style.display = 'block';
         messageInput.style.borderColor = '#dc3545';
         isValid = false;
      } else {
         messageError.style.display = 'none';
         messageInput.style.borderColor = '';
      }
      
      if (!isValid) {
         e.preventDefault();
      }
   }
   
   // Add form submission event listener
   contactForm.addEventListener('submit', validateForm);
   
   // Real-time validation
   nameInput.addEventListener('input', function() {
      if (nameInput.value.trim().length >= 2) {
         nameError.style.display = 'none';
         nameInput.style.borderColor = '';
      }
   });
   
   emailInput.addEventListener('input', function() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailPattern.test(emailInput.value)) {
         emailError.style.display = 'none';
         emailInput.style.borderColor = '';
      }
   });
   
   numberInput.addEventListener('input', function() {
      if (numberInput.value.trim().length >= 10) {
         numberError.style.display = 'none';
         numberInput.style.borderColor = '';
      }
   });
   
   messageInput.addEventListener('input', function() {
      if (messageInput.value.trim() !== '') {
         messageError.style.display = 'none';
         messageInput.style.borderColor = '';
      }
   });
   
   // Close message alert functionality
   const messageOverlays = document.querySelectorAll('.message-overlay');
   messageOverlays.forEach(function(overlay) {
      const closeBtn = overlay.querySelector('.fas.fa-times');
      if (closeBtn) {
         closeBtn.addEventListener('click', function() {
            overlay.remove();
         });
         
         // Auto-hide messages after 5 seconds
         setTimeout(function() {
            overlay.style.opacity = '0';
            overlay.style.transition = 'opacity 1s ease';
            setTimeout(function() {
               overlay.remove();
            }, 1000);
         }, 5000);
      }
   });
});
</script>

</body>
</html>