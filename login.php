<?php
include 'config.php';
session_start();

$formType = isset($_GET['form']) && $_GET['form'] === 'register' ? 'register' : 'login';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $message = [];

    if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20) {
        $message[] = 'Password harus antara 8-20 karakter!';
    } else {
        // Cek user berdasarkan email & password
        $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pass'") or die('Query gagal');

        if (mysqli_num_rows($select_users) > 0) {
            $row = mysqli_fetch_assoc($select_users);

            // Cek apakah admin atau user
            if ($row['user_type'] === 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
            } else {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }
            exit();
        } else {
            $message[] = 'Email atau password salah!';
        }
    }
}

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $user_type = 'user';

    if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20) {
        $message[] = 'Password harus antara 8-20 karakter!';
    } else {
        $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($check_email) > 0) {
            $message[] = 'Email sudah digunakan!';
        } else {
            $insert_user = mysqli_query($conn, "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$pass', '$user_type')") or die('query failed');

            if ($insert_user) {
                $message[] = 'Pendaftaran berhasil!';
                // Redirect ke halaman login setelah registrasi berhasil
                header("Location: login.php?form=login");
                exit();
            } else {
                $message[] = 'Pendaftaran gagal!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Gramedia</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            width: 900px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left {
            width: 50%;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .left img {
            max-width: 100%;
        }

        .right {
            width: 50%;
            padding: 40px;
        }

        .tab {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab button {
            background: none;
            border: none;
            font-size: 18px;
            padding: 10px 20px;
            cursor: pointer;
            color: #6c757d;
            transition: 0.3s;
        }

        .tab button.active {
            border-bottom: 2px solid #007bff;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .social-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .social-btn img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .social-btn:hover {
            background: #f1f1f1;
        }

        .social-btn.google {
            border-color: #db4437;
            color: #db4437;
        }

        .social-btn.myvalue {
            border-color: #0056b3;
            color: #0056b3;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <img src="img/gramedia.jpg" alt="Illustrasi Membaca">
    </div>
    <div class="right">
    
        <div class="tab">
            <button class="<?= $formType === 'login' ? 'active' : ''; ?>" onclick="showForm('login')">Login</button>
            <button class="<?= $formType === 'register' ? 'active' : ''; ?>" onclick="showForm('register')">Register</button>
        </div>

        <!-- Login Form -->
<form action="" method="post" id="login-form" class="form-container <?= $formType === 'login' ? 'active' : ''; ?>">
    <h2>Masuk Akun Gramedia</h2>
    <?php if ($formType === 'login' && !empty($message)) : ?>
        <?php foreach ($message as $msg) : ?>
            <p style="color:red; font-size: 14px; margin-bottom: 10px;"><?= $msg; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" placeholder="Kata Sandi" required minlength="8" maxlength="20">
    </div>
    <button type="submit" name="submit" class="btn-login">Masuk</button>
</form>

        <!-- Register Form -->
<form action="" method="post" id="register-form" class="form-container <?= $formType === 'register' ? 'active' : ''; ?>">
    <h2>Daftar Akun Gramedia</h2>
    <?php if ($formType === 'register' && !empty($message)) : ?>
        <?php foreach ($message as $msg) : ?>
            <p style="color:<?= (stripos($msg, 'berhasil') !== false ? 'green' : 'red'); ?>; font-size: 14px; margin-bottom: 10px;"><?= $msg; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-group">
        <input type="text" name="name" placeholder="Nama Lengkap" required>
    </div>
    <div class="form-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" placeholder="Kata Sandi" required minlength="8" maxlength="20">
    </div>
    <button type="submit" name="register" class="btn-login">Daftar</button>
</form>

        <div class="social-login">
            <button class="social-btn google">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/09/IOS_Google_icon.png" alt="Google">
                Masuk dengan Google
            </button>
        </div>
    </div>
</div>

<script>
    function showForm(formType) {
        window.location.href = "login.php?form=" + formType;
    }
</script>

</body>
</html>
