<?php
session_start(); // Memulai sesi untuk melacak data user

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_shop");

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'] ?? null;

// Jika user belum login, redirect ke halaman login
if (!isset($user_id)) {
    header("Location: login.php");
    exit();
}

// Jika tidak ada ID pesanan di URL, redirect ke halaman checkout
if (!isset($_GET['order_id'])) {
    header("Location: checkout.php");
    exit();
}

$order_id = $_GET['order_id']; // Mengambil order ID dari parameter URL

// Ambil data pesanan berdasarkan ID dan user_id untuk verifikasi
$orderSql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("ii", $order_id, $user_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

// Jika pesanan tidak ditemukan atau bukan milik user, tampilkan pesan error
if ($orderResult->num_rows == 0) {
    die("Pesanan tidak ditemukan");
}

// Ambil data pesanan dalam bentuk array asosiatif
$orderData = $orderResult->fetch_assoc();
$totalBayar = $orderData['total_harga']; // Total yang harus dibayar

// Jika form pembayaran disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];     // Metode pembayaran dari input hidden
    $payment_number = $_POST['payment_number'];     // Nomor e-wallet dari input user

    // Simulasi proses pembayaran (dummy), selalu sukses
    $payment_status = "success";
    $payment_date = date("Y-m-d H:i:s"); // Waktu pembayaran sekarang

    // Update data pesanan: metode, nomor, status pembayaran, waktu, dan status pesanan
    $updateSql = "UPDATE orders SET 
                  payment_method = ?, 
                  payment_number = ?, 
                  payment_status = ?, 
                  payment_date = ?,
                  status = 'paid' 
                  WHERE id = ?";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $payment_method, $payment_number, $payment_status, $payment_date, $order_id);
    
    // Jika update berhasil, redirect ke halaman sukses
    if ($updateStmt->execute()) {
        header("Location: payment_success.php?order_id=" . $order_id);
        exit();
    } else {
        $error_message = "Gagal memproses pembayaran: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <!-- Link ke Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Gaya keseluruhan halaman */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        /* Container utama form pembayaran */
        .payment-container {
            max-width: 600px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Judul halaman */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Info pesanan (order ID & total) */
        .payment-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payment-info p {
            margin: 8px 0;
        }

        /* Container pilihan metode pembayaran */
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        /* Gaya tiap metode pembayaran */
        .payment-method {
            flex: 1;
            min-width: 150px;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100px;
        }

        /* Efek hover dan selected */
        .payment-method:hover, .payment-method.selected {
            border-color: #007bff;
            background: #f0f7ff;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.15);
        }

        /* Ukuran gambar/logo metode pembayaran */
        .payment-method img {
            height: 70px;
            width: auto;
            object-fit: contain;
            max-width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .submit-btn {
            background: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #0056b3;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Pembayaran</h2>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if(isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <!-- Info pesanan -->
        <div class="payment-info">
            <p><strong>Order ID:</strong> #<?php echo $orderData['id']; ?></p>
            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($totalBayar, 0, ',', '.'); ?></p>
        </div>
        
        <h3>Pilih Metode Pembayaran</h3>
        
        <!-- Form pembayaran -->
        <form method="post" action="">
            <!-- Pilihan metode pembayaran -->
            <div class="payment-methods">
                <div class="payment-method" data-method="ovo">
                    <img src="img/ovo.png" alt="OVO">
                </div>
                <div class="payment-method" data-method="gopay">
                    <img src="img/gopay.png" alt="GoPay">
                </div>
                <div class="payment-method" data-method="shopeepay">
                    <img src="img/sppay.png" alt="ShopeePay">
                </div>
            </div>

            <!-- Input tersembunyi untuk menyimpan metode pembayaran yang dipilih -->
            <input type="hidden" id="payment_method" name="payment_method" value="">

            <!-- Input nomor e-wallet -->
            <div class="form-group">
                <label for="payment_number">Nomor <span id="payment-label">E-wallet</span></label>
                <input type="text" id="payment_number" name="payment_number" required placeholder="Masukkan nomor e-wallet Anda">
            </div>

            <!-- Tombol submit pembayaran -->
            <button type="submit" class="submit-btn">Bayar Sekarang</button>
        </form>
    </div>

    <!-- Script untuk menangani klik metode pembayaran dan validasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('.payment-method');
            const paymentMethodInput = document.getElementById('payment_method');
            const paymentLabel = document.getElementById('payment-label');

            // Event listener untuk memilih metode pembayaran
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    // Hapus kelas 'selected' dari semua elemen
                    paymentMethods.forEach(m => m.classList.remove('selected'));

                    // Tambahkan kelas 'selected' pada elemen yang diklik
                    this.classList.add('selected');

                    // Set nilai input tersembunyi
                    const methodName = this.getAttribute('data-method');
                    paymentMethodInput.value = methodName;

                    // Update label sesuai metode
                    paymentLabel.textContent = methodName.charAt(0).toUpperCase() + methodName.slice(1);
                });
            });

            // Validasi form saat submit
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!paymentMethodInput.value) {
                    e.preventDefault(); // Cegah submit
                    alert('Silakan pilih metode pembayaran');
                }
            });
        });
    </script>
</body>
</html>
