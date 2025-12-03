<?php
$conn = new mysqli("localhost", "root", "", "db_shop");
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if(!isset($user_id)){
    header('location:login.php');
    exit; 
}

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$idBuku = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM buku WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idBuku);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Buku tidak ditemukan.");
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['judul']); ?> - Detail Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* ... (CSS Anda) ... */
     body {
          font-family: Arial, sans-serif;
          background: #f8f9fa;
          margin: 0;
          padding: 20px;}


         .book-image {
             width: 40%;
             position: relative;
         }
         .book-image img {
             width: 80%;
             border-radius: 8px;
             transition: transform 0.3s ease-in-out;
         }
         .book-image img:hover {
             transform: scale(1.05);
         }
         .book-info {
             width: 60%;
         }
         .book-info h2 {
             font-size: 26px;
             margin-bottom: 10px;
         }
         .book-info p {
             font-size: 16px;
             margin-bottom: 8px;
         }
         .rating {
             color: #f4c542;
             font-size: 14px;
             margin-bottom: 10px;
         }
         .price {
             font-size: 24px;
             font-weight: bold;
             color: #007BFF;
             margin-bottom: 15px;
         }
         .quantity {
             display: flex;
             align-items: center;
             margin-bottom: 20px;
         }
         .quantity button {
             background: #007BFF;
             color: white;
             border: none;
             padding: 8px 12px;
             font-size: 18px;
             cursor: pointer;
             transition: 0.3s;
         }
         .quantity button:hover {
             background: #0056b3;
         }
         .quantity input {
             width: 40px;
             text-align: center;
             font-size: 16px;
             border: 1px solid #ddd;
             margin: 0 8px;
             padding: 5px;
         }
        .btn-cart {
            display: inline-block;
            padding: 12px 20px;
            background: #FF5733;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
            transition: 0.3s;
            border: none; 
            cursor: pointer; 
        }

        .btn-cart:hover {
            background: #C70039;
        }
          .btn-buy {
              display: inline-block;
              padding: 12px 20px;
              background: #28A745;
              color: white;
              text-decoration: none;
              border-radius: 5px;
              font-size: 16px;
              transition: 0.3s;
              border:none;
              cursor: pointer;
          }
          .btn-buy:hover {
              background: #1E7E34;
          }
         .tabs {
             margin-top: 20px;
         }
         .tabs button {
             background: #ddd;
             border: none;
             padding: 10px;
             margin-right: 5px;
             cursor: pointer;
         }
         .tabs button.active {
             background: #007BFF;
             color: white;
         }
         .tab-content {
             display: none;
             padding: 15px;
             border: 1px solid #ddd;
             margin-top: 10px;
         }
         .tab-content.active {
             display: block;
         }

    </style>
</head>
<body>

    <header>
        <?php include 'header.php'; ?>
    </header>

<div class="container">
    <div class="book-image">
        <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Buku">
    </div>
    <div class="book-info">
        <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
        <p class="rating">★★★★★ (4.8/5)</p>
        <p><strong>Penulis:</strong> <?php echo htmlspecialchars($row['penulis']); ?></p>
        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($row['kategori']); ?></p>
        <p class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>

        <div class="quantity">
            <button onclick="ubahJumlah(-1)">-</button>
            <input type="number" id="jumlah" value="1" min="1" max="<?php echo $row['stok']; ?>">
            <button onclick="ubahJumlah(1)">+</button>
        </div>
        <button class="btn-cart" data-id="<?= $row['id']; ?>">Tambah ke Keranjang</button>


        <div class="tabs">
            <button class="tab-button active" onclick="bukaTab(event, 'deskripsi')">Deskripsi</button>
            <button class="tab-button" onclick="bukaTab(event, 'ulasan')">Ulasan</button>
        </div>

        <div id="deskripsi" class="tab-content active">
            <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
        </div>

        <div id="ulasan" class="tab-content">
            <p>Belum ada ulasan.</p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function bukaTab(evt, tabName) {
    var i, tabcontent, tabbuttons;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function ubahJumlah(perubahan) {
    var inputJumlah = document.getElementById("jumlah");
    var jumlah = parseInt(inputJumlah.value);
    var stok = parseInt(inputJumlah.max); 

    jumlah += perubahan;

    if (jumlah < 1) {
        jumlah = 1;
    } else if (jumlah > stok) {
        jumlah = stok; 
        alert('Stok hanya '+stok+' item');
    }

    inputJumlah.value = jumlah;
}


$(document).ready(function() {
     $('.btn-cart').click(function() {
            let bookId = $(this).data('id');
            let quantity = $('#jumlah').val();
            let stok = parseInt($('#jumlah').attr('max'));

            if (quantity > stok) {
               alert('Stok tidak cukup');
                return;
            }

            $.ajax({
                url: 'cart_action.php',
                type: 'POST',
                data: {
                    action: 'add',
                    book_id: bookId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        updateCartCount();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
});
</script>

</body>
</html>