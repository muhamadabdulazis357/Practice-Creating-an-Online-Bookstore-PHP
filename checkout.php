<?php
$conn = new mysqli("localhost", "root", "", "db_shop");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit();
}

$userId = $_SESSION['user_id'];
$cartItems = [];
$totalHarga = 0;
$isBuyNow = false; 

if (isset($_GET['id'])) {
    $isBuyNow = true;
    $bookId = (int)$_GET['id'];
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
    
    $sql = "SELECT * FROM buku WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("Buku tidak ditemukan.");
    }
    
    $row = $result->fetch_assoc();
    $row['quantity'] = $quantity; 
    $cartItems[] = $row;
    $totalHarga = $row['harga'] * $quantity; 
    $stmt->close();
    
} else {
    $sql = "SELECT c.quantity, b.* 
            FROM cart c 
            JOIN buku b ON c.book_id = b.id 
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header("Location: keranjang.php");
        exit();
    }

    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $totalHarga += $row['harga'] * $row['quantity']; 
    }
    $stmt->close();
}

$alamatSql = "SELECT * FROM alamat WHERE id_user = ? ORDER BY id DESC LIMIT 1";
$alamatStmt = $conn->prepare($alamatSql);
$alamatStmt->bind_param("i", $userId);
$alamatStmt->execute();
$alamatResult = $alamatStmt->get_result();
$alamatData = $alamatResult->fetch_assoc();
$alamatStmt->close();

$biayaOngkir = 0; 
$totalBayar = $totalHarga + $biayaOngkir;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
<div class="checkout-container">
    <div class="progress-bar">
        <div class="step active">1. Pengiriman</div>
        <div class="step">2. Pembayaran</div>
    </div>

    <div class="checkout-content">
        <div class="left-section">
             <h2>Alamat Pengiriman</h2>
            <?php if ($alamatData): ?>
            <div class="alamat-box">
                <p><strong><?php echo htmlspecialchars($alamatData['nama_penerima']); ?></strong> (<?php echo htmlspecialchars($alamatData['label']); ?>)</p>
                <p><?php echo htmlspecialchars($alamatData['no_telp']); ?></p>
                <p><?php echo htmlspecialchars($alamatData['alamat_lengkap']); ?></p>
                <p><?php echo htmlspecialchars($alamatData['lokasi']); ?>, <?php echo htmlspecialchars($alamatData['kode_pos']); ?></p>
            </div>
            <button class="btn" id="btnAlamat">Ubah Alamat</button>
            <?php else: ?>
            <p>Belum ada alamat yang terdaftar.</p>
            <button class="btn" id="btnAlamat">Buat Alamat</button>
            <?php endif; ?>


            <h2>Pesanan Anda</h2>

            <?php foreach ($cartItems as $item): ?>
            <div class="order-item">
                <img src="<?php echo htmlspecialchars($item['gambar']); ?>" alt="Buku">
                <div>
                    <h3><?php echo htmlspecialchars($item['judul']); ?></h3>
                    <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?> x <?php echo $item['quantity']; ?></p>
                    <strong>Subtotal: Rp <?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></strong>
                </div>
            </div>
            <?php endforeach; ?>

             <h2>Metode Pengiriman</h2>
            <select id="ekspedisi" class="ekspedisi">
                <option value="jne">JNE - Rp 20.000</option>
                <option value="sicepat">SiCepat - Rp 18.000</option>
                <option value="anteraja">AnterAja - Rp 15.000</option>
            </select>
        </div>

        <div class="right-section">
            <h2>Ringkasan Belanja</h2>
            <p>Subtotal: Rp <span id="subtotal"><?php echo number_format($totalHarga, 0, ',', '.'); ?></span></p>
            <p>Biaya Pengiriman: Rp <span id="biayaOngkir">0</span></p>
            <strong>Total Bayar: Rp <span id="totalBayar"><?php echo number_format($totalBayar, 0, ',', '.'); ?></span></strong>
            <button class="btn btn-primary">Lanjut Pembayaran</button>
        </div>
    </div>
</div>

<div id="modalAlamat" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Detail Alamat</h2>
        <form id="formAlamat" method="post" action="simpan_alamat.php">
            <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">
    <?php if (isset($_GET['id'])): ?>
        <input type="hidden" name="buy_now_id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <input type="hidden" name="buy_now_qty" value="<?= htmlspecialchars($_GET['quantity'] ?? 1) ?>">
    <?php endif; ?>
            <label for="namaPenerima">Nama Penerima</label>
            <input type="text" id="namaPenerima" name="namaPenerima" placeholder="Masukkan Nama Penerima"
                   value="<?php echo $alamatData ? htmlspecialchars($alamatData['nama_penerima']) : ''; ?>" required>

            <label for="noTelp">No. Telp</label>
            <input type="text" id="noTelp" name="noTelp"
                   value="<?php echo $alamatData ? htmlspecialchars($alamatData['no_telp']) : '+62'; ?>" required>

            <label for="label">Label</label>
            <select id="label" name="label" required>
                <option value="Rumah" <?php echo ($alamatData && $alamatData['label'] == 'Rumah') ? 'selected' : ''; ?>>Rumah</option>
                <option value="Kantor" <?php echo ($alamatData && $alamatData['label'] == 'Kantor') ? 'selected' : ''; ?>>Kantor</option>
                <option value="Lainnya" <?php echo ($alamatData && $alamatData['label'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
            </select>

            <label for="lokasi">Provinsi, Kota, Kecamatan</label>
            <select id="lokasi" name="lokasi" required>
                <option value="">Pilih Lokasi</option>
                <option value="Jakarta" <?php echo ($alamatData && $alamatData['lokasi'] == 'Jakarta') ? 'selected' : ''; ?>>Jakarta</option>
                <option value="Banten" <?php echo ($alamatData && $alamatData['lokasi'] == 'Banten') ? 'selected' : ''; ?>>Banten</option>
                <option value="Malang" <?php echo ($alamatData && $alamatData['lokasi'] == 'Malang') ? 'selected' : ''; ?>>Malang</option>
                <option value="Denpasar" <?php echo ($alamatData && $alamatData['lokasi'] == 'Denpasar') ? 'selected' : ''; ?>>Denpasar</option>
                <option value="Kyoto" <?php echo ($alamatData && $alamatData['lokasi'] == 'Kyoto') ? 'selected' : ''; ?>>Kyoto</option>
                <option value="Bandung" <?php echo ($alamatData && $alamatData['lokasi'] == 'Bandung') ? 'selected' : ''; ?>>Bandung</option>
                <option value="Surabaya" <?php echo ($alamatData && $alamatData['lokasi'] == 'Surabaya') ? 'selected' : ''; ?>>Surabaya</option>
                <option value="Yogyakarta" <?php echo ($alamatData && $alamatData['lokasi'] == 'Yogyakarta') ? 'selected' : ''; ?>>Yogyakarta</option>
                <option value="Medan" <?php echo ($alamatData && $alamatData['lokasi'] == 'Medan') ? 'selected' : ''; ?>>Medan</option>
                <option value="Makassar" <?php echo ($alamatData && $alamatData['lokasi'] == 'Makassar') ? 'selected' : ''; ?>>Makassar</option>
                </select>

            <label for="kodePos">Kode Pos</label>
            <input type="text" id="kodePos" name="kodePos" placeholder="Kode Pos"
                   value="<?php echo $alamatData ? htmlspecialchars($alamatData['kode_pos']) : ''; ?>" required>

            <label for="alamatLengkap">Alamat Lengkap</label>
            <textarea id="alamatLengkap" name="alamatLengkap" placeholder="Masukkan Alamat Lengkap" required><?php echo $alamatData ? htmlspecialchars($alamatData['alamat_lengkap']) : ''; ?></textarea>

            <button type="submit" class="btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>


document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("modalAlamat");
    var btn = document.getElementById("btnAlamat");
    var span = document.querySelector(".close");

    btn.onclick = function() {
        modal.style.display = "flex";
    };

    span.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    var biayaOngkir = {
        "jne": 20000,
        "sicepat": 18000,
        "anteraja": 15000
    };

    var subtotal = <?php echo $totalHarga; ?>;
    var ongkirElement = document.getElementById("biayaOngkir");
    var totalElement = document.getElementById("totalBayar");
    var ekspedisiSelect = document.getElementById("ekspedisi");

    ekspedisiSelect.addEventListener("change", function() {
        var selectedValue = this.value;
        var ongkir = biayaOngkir[selectedValue] || 0;
        ongkirElement.textContent = ongkir.toLocaleString('id-ID');
        totalElement.textContent = (subtotal + ongkir).toLocaleString('id-ID');
    });

    ekspedisiSelect.dispatchEvent(new Event('change'));

    var formAlamat = document.getElementById("formAlamat");
     if (formAlamat) {
        formAlamat.addEventListener("submit", function(event) {
            var namaPenerima = document.getElementById("namaPenerima").value;
            var noTelp = document.getElementById("noTelp").value;
            var lokasi = document.getElementById("lokasi").value;
            var kodePos = document.getElementById("kodePos").value;
            var alamatLengkap = document.getElementById("alamatLengkap").value;

            if (!namaPenerima || !noTelp || !lokasi || !kodePos || !alamatLengkap) {
                event.preventDefault();
                alert("Mohon lengkapi semua field yang diperlukan");
                return false;
            }
        });
    }

document.querySelector(".btn.btn-primary").addEventListener("click", function() {
    if (!document.querySelector(".alamat-box")) {
        alert("Silakan buat alamat pengiriman terlebih dahulu!");
        return;
    }

    var ekspedisi = document.getElementById("ekspedisi").value;
    var ongkir = biayaOngkir[ekspedisi] || 0;
    var subtotal = <?php echo $totalHarga; ?>; 
    var totalBayar = subtotal + ongkir;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "proses_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            try { 
                var response = JSON.parse(this.responseText);
                if (response.status === "success") {
                    window.location.href = "payment.php?order_id=" + response.order_id;
                } else {
                    alert(response.message || "Terjadi kesalahan yang tidak diketahui."); 
                }
            } catch (e) {
                console.error("Error parsing JSON:", e);
                console.error("Response Text:", this.responseText); 
                alert("Terjadi kesalahan saat memproses respon server.");
            }
        } else if (this.readyState === XMLHttpRequest.DONE) {
             console.error("AJAX Error:", this.status, this.statusText);
             console.error("Response Text:", this.responseText);
             alert("Gagal menghubungi server. Kode status: " + this.status);
        }
    };

    var isBuyNow = <?php echo $isBuyNow ? 'true' : 'false'; ?>;
    var bookId = <?php echo isset($_GET['id']) ? (int)$_GET['id'] : '0'; ?>; 

    var dataToSend = "ekspedisi=" + encodeURIComponent(ekspedisi) +
                     "&ongkir=" + encodeURIComponent(ongkir) +
                     "&total=" + encodeURIComponent(totalBayar) +
                     "&is_buy_now=" + encodeURIComponent(isBuyNow) +
                     "&book_id=" + encodeURIComponent(bookId);

    if (isBuyNow) {
        var buyNowQuantity = <?php echo $isBuyNow ? (isset($quantity) ? (int)$quantity : 1) : 1; ?>;
        dataToSend += "&buy_now_qty=" + encodeURIComponent(buyNowQuantity);
    }

    console.log("Sending data:", dataToSend); 
    xhr.send(dataToSend);
});
});
</script>

</body>
</html>


<style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            padding: 50px;
            display: flex;
            justify-content: center;
        }

        /* Container */
        .checkout-container {
            max-width: 1100px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Progress Bar */
        .progress-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .step {
            flex: 1;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            background: #dbe9ff;
            color: #555;
        }

        .step.active {
            background: #007bff;
            color: white;
        }

        /* Layout */
        .checkout-content {
            display: flex;
            gap: 40px;
        }

        /* Kolom Kiri */
        .left-section {
            width: 65%;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* Box Styling */
        .shipping-box, .order-box, .right-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        /* Order Item */
        .order-item {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 15px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 15px;
        }

        .order-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .order-item img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
        }

          /* Ringkasan Belanja */
        .right-section {
            width: 35%;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }

        /* Jarak antar teks lebih luas */
        .right-section p {
            display: flex;
            justify-content: flex;
            margin-bottom: 16px;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Total price section */
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
          /* Buttons */
        .btn {
            padding: 14px 20px;
            background: white;
            border: 2px solid #007bff;
            border-radius: 8px;
            color: #007bff;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 16px;
        }

        .btn:hover {
            background: #007bff;
            color: white;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 16px;
            margin-top: 16px;
        }

        .btn-primary:hover {
            background: #0056b3;
        }


        /* MODAL STYLING */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            overflow: auto;
            padding: 20px;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            text-align: left;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.3s ease-in-out;
            position: relative;
        }
          @media (max-width: 600px) {
            .modal-content {
                width: 95%;
                padding: 15px;
            }
        }

        /* Animasi modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .modal-content h2 {
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        /* Close Button */
        .close {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #777;
            transition: 0.3s;
        }

        .close:hover {
            color: #333;
        }

        /* Input Fields */
        .modal-content input,
        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 14px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            background: #f9f9f9;
            transition: all 0.3s;
        }

        .modal-content input:focus,
        .modal-content select:focus,
        .modal-content textarea:focus {
            border-color: #007bff;
            background: #fff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        /* Disabled Input */
        .modal-content input[disabled] {
            background: #e9ecef;
            cursor: not-allowed;
        }

        /* Select Dropdown */
        .modal-content select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="gray" d="M7 10l5 5 5-5z"></path></svg>') no-repeat right 12px center;
            background-size: 18px;
        }

        /* Tombol Simpan */
        .modal-content .btn-primary {
            width: 100%;
            margin-top: 10px;
            padding: 16px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 16px;
        }

        .modal-content .btn-primary:hover {
            background: #0056b3;
        }

        /* Gaya untuk Select Ekspedisi */
        .ekspedisi {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 8px;
            background: white;
            color: #333;
            appearance: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="gray" d="M7 10l5 5 5-5z"></path></svg>') no-repeat right 12px center;
            background-size: 18px;
        }

        /* Hover dan Fokus */
        .ekspedisi:hover,
        .ekspedisi:focus {
            border-color: #0056b3;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
            outline: none;
        }

          /* Container Select */
        .select-container {
            position: relative;
            width: 100%;
        }

        /* Alamat Box Styling */
        .alamat-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .alamat-box p {
            margin-bottom: 5px;
        }

    </style>