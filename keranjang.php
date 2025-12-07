<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "db_shop");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
       /* Global Styling */
       body {
           font-family: 'Poppins', sans-serif;
           background-color: #f8f9fa;
           color: #333;
           margin: 0;
           padding: 0;
       }

       .cart-container {
           width: 90%;
           max-width: 900px;
           margin: 50px auto;
           background: white;
           padding: 20px;
           border-radius: 10px;
           box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
       }

       h2 {
           text-align: center;
           color: #007BFF;
           margin-bottom: 20px;
       }

       /* Table Styling */
       table {
           width: 100%;
           border-collapse: collapse;
           margin-top: 20px;
           background: white;
           border-radius: 10px;
           overflow: hidden;
       }

       th, td {
           padding: 12px;
           text-align: left;
           border-bottom: 1px solid #ddd;
       }

       th {
           background-color: #007BFF;
           color: white;
       }

       tr:hover {
           background-color: #f1f1f1;
           transition: 0.3s;
       }

       /* Buttons */
       .qty-btn {
           background: #007BFF;
           color: white;
           border: none;
           padding: 5px 10px;
           font-size: 16px;
           border-radius: 5px;
           cursor: pointer;
           transition: 0.3s;
           margin: 0 5px;
       }

       .qty-btn:hover {
           background: #0056b3;
       }

       .remove-btn {
           background: #dc3545;
           color: white;
           padding: 8px 12px;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           transition: 0.3s;
       }

       .remove-btn:hover {
           background: #c82333;
       }

       .checkout-btn {
           display: block;
           width: 100%;
           background: #28a745;
           color: white;
           padding: 12px;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           font-size: 18px;
           text-align: center;
           margin-top: 20px;
           transition: 0.3s;
       }

       .checkout-btn:hover {
           background: #218838;
       }

       /* Total Price */
       .total-container {
           text-align: right;
           font-size: 20px;
           font-weight: bold;
           margin-top: 20px;
           color: #333;
       }

       @media (max-width: 768px) {
           table {
               font-size: 14px;
           }

           th, td {
               padding: 8px;
           }

           .checkout-btn {
               font-size: 16px;
           }
       }
    </style>
</head>
<body>

<div class="cart-container">
    <h2>🛒 Keranjang Belanja</h2>
    <table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Judul Buku</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="cart-items">
    </tbody>
</table>

    <div class="total-container">
        Total: Rp <span id="total-price">0</span>
    </div>

    <button class="checkout-btn" id="checkout-btn">🛍️ Checkout Sekarang</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    let userId = <?php echo json_encode($user_id); ?>;

    loadCart();

    function loadCart() {
    $.ajax({
        url: 'get_cart.php',
        type: 'GET',
        data: { user_id: userId },
        dataType: 'json',
        success: function(cartItems) {
            let totalPrice = 0;
            let cartTable = document.getElementById("cart-items");
            cartTable.innerHTML = "";

            if (cartItems.length === 0) {
                cartTable.innerHTML = "<tr><td colspan='6' style='text-align:center;'>Keranjang Kosong 🛒</td></tr>";
                document.getElementById("total-price").innerText = "0";
                return;
            }

            cartItems.forEach(item => {
                let subtotal = item.harga * item.quantity;
                totalPrice += subtotal;

                let row = `
                    <tr>
                        <td><img src="${item.gambar}" alt="Gambar Buku" style="width: 50px; height: 50px; object-fit: cover;"></td>
                        <td>${item.judul}</td>
                        <td>Rp ${item.harga.toLocaleString()}</td>
                        <td>
                            <button class="qty-btn decrease" data-id="${item.book_id}">➖</button>
                            ${item.quantity}
                            <button class="qty-btn increase" data-id="${item.book_id}">➕</button>
                        </td>
                        <td>Rp ${subtotal.toLocaleString()}</td>
                        <td><button class="remove-btn" data-id="${item.book_id}">Hapus</button></td>
                    </tr>
                `;
                cartTable.innerHTML += row;
            });

            document.getElementById("total-price").innerText = totalPrice.toLocaleString();
        },
        error: function(xhr, status, error) {
            console.error("Error loading cart:", error);
            alert("Terjadi kesalahan saat memuat keranjang.");
        }
    });
}
    $(document).on("click", ".increase", function () {
        let bookId = $(this).data("id");
        updateQuantity(bookId, 1);
    });

    $(document).on("click", ".decrease", function () {
        let bookId = $(this).data("id");
        updateQuantity(bookId, -1);
    });

     // Fungsi untuk menghapus item (terpisah dari updateQuantity)
    function removeItem(bookId) {
        $.ajax({
            url: 'cart_action.php',
            type: 'POST',
            data: {
                action: 'remove', // Gunakan action 'remove'
                book_id: bookId,
                user_id: userId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    loadCart();       // Muat ulang keranjang
                    updateCartCount();  // Update ikon keranjang
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus item.');
            }
        });
    }


    $(document).on("click", ".remove-btn", function () {
        let bookId = $(this).data("id");
        removeItem(bookId); // Panggil fungsi removeItem
    });

    function updateQuantity(bookId, change) {
        $.ajax({
            url: 'cart_action.php',
            type: 'POST',
            data: {
                action: 'update_quantity',  //Tetap update quantity untuk tombol + dan -
                book_id: bookId,
                quantity: change,
                user_id: userId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    loadCart();
                    updateCartCount();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memperbarui keranjang.');
            }
        });
    }


    $('#checkout-btn').click(function() {
        window.location.href = 'checkout.php';
    });
});

</script>
</body>
</html>