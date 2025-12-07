<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Akses ditolak!");
}

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan");
}

$order_id = (int)$_GET['id']; 
$sql = "SELECT o.*, u.name as user_name, u.email as user_email FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Pesanan tidak ditemukan");
}

$order = $result->fetch_assoc();

$items_sql = "SELECT oi.*, b.gambar FROM order_items oi LEFT JOIN buku b ON oi.book_id = b.id WHERE oi.order_id = ?"; // Join dengan buku untuk gambar
$items_stmt = $conn->prepare($items_sql);
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();

$status_options = [
    'pending' => 'Menunggu Pembayaran',
    'paid' => 'Pembayaran Berhasil',
    'shipped' => 'Dalam Pengiriman',
    'delivered' => 'Terkirim',
    'cancelled' => 'Dibatalkan'
];
?>

<style>
    .order-info, .customer-info, .payment-info, .order-items, .update-status {
        margin-bottom: 25px; 
       }

    .modal-body h3 { 
        margin-top: 0;
        margin-bottom: 15px;
        color: #1e293b; 
        font-size: 20px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid #eaeaea; 
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px; 
    }

    .info-grid div {
        padding: 12px;
        background: #f8f9fa; 
        border-radius: 6px; 
        font-size: 14px; 
        line-height: 1.6; 
    }
     .info-grid strong {
          font-weight: 600;
          color: #333;
     }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .items-table th, .items-table td {
        padding: 12px;
       text-align: left;
        border-bottom: 1px solid #eaeaea; 
         font-size: 14px; 
    }

    .items-table th {
        background: #f1f3f7;
        font-weight: 600;
        color: #333;
    }
     .items-table tbody tr:hover {
          background-color: #fdfdfe; 
     }
     .items-table img.item-image { 
          width: 40px;
          height: 40px;
          object-fit: cover;
          border-radius: 4px;
          margin-right: 10px;
          vertical-align: middle;
     }
     .items-table .item-title-cell { 
          display: flex;
          align-items: center;
     }


    .items-table tfoot td {
         font-weight: 600;
         border-top: 2px solid #ddd;
         background-color: #f8f9fa; 
    }

    .text-right {
        text-align: right !important; 
        }

    .update-status .form-group {
        margin-bottom: 15px;
        }

    .update-status .form-control { 
        width: 100%;
        padding: 12px; 
        border: 1px solid #ccc; 
        border-radius: 6px; 
        font-size: 14px;
        background-color: #fff; 
        box-sizing: border-box; 
    }

    .update-status .btn-primary { 
        color: white;
        border: none;
        padding: 10px 20px; 
        border-radius: 6px;
        cursor: pointer;
        background-color: #38bdf8; 
        transition: background-color 0.3s;
        font-weight: 600;
       }

    .update-status .btn-primary:hover {
        background-color: #0ea5e9; 
        }

     .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending { background: #ffe082; color: #f57c00; }
        .status-paid { background: #c8e6c9; color: #388e3c; }
        .status-shipped { background: #bbdefb; color: #1976d2; }
        .status-delivered { background: #c8e6c9; color: #2e7d32; }
        .status-cancelled { background: #ffcdd2; color: #d32f2f; }

</style>

<div class="order-info">
    <h3>Informasi Pesanan</h3>
    <div class="info-grid">
        <div>
            <strong>Order ID:</strong> #<?php echo $order['id']; ?>
        </div>
        <div>
            <strong>Tanggal:</strong> <?php echo date('d F Y H:i', strtotime($order['created_at'])); ?>
        </div>
        <div>
            <strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['user_name']); ?> (<?php echo htmlspecialchars($order['user_email']); ?>)
        </div>
        <div>
            <strong>Status Saat Ini:</strong>
            <span class="status-badge status-<?php echo $order['status']; ?>">
                <?php echo $status_options[$order['status']]; ?>
            </span>
        </div>
    </div>
</div>

<div class="customer-info">
    <h3>Informasi Pengiriman</h3>
    <div class="info-grid">
        <div>
            <strong>Penerima:</strong> <?php echo htmlspecialchars($order['nama_penerima']); ?>
        </div>
        <div>
            <strong>No. Telp:</strong> <?php echo htmlspecialchars($order['no_telp']); ?>
        </div>
        <div style="grid-column: 1 / -1;"> <strong>Alamat:</strong> <?php echo htmlspecialchars($order['alamat_pengiriman']); ?>
        </div>
        <div>
            <strong>Kurir:</strong> <?php echo strtoupper(htmlspecialchars($order['ekspedisi'])); ?>
        </div>
    </div>
</div>

<?php if ($order['payment_method']): ?>
<div class="payment-info">
    <h3>Informasi Pembayaran</h3>
    <div class="info-grid">
        <div>
            <strong>Metode:</strong> <?php echo ucfirst(htmlspecialchars($order['payment_method'])); ?>
        </div>
        <div>
            <strong>Nomor Akun:</strong> <?php echo htmlspecialchars($order['payment_number']); ?>
        </div>
        <div>
            <strong>Status Pembayaran:</strong> <span style="color: green; font-weight: bold;"><?php echo ucfirst(htmlspecialchars($order['payment_status'])); ?></span>
        </div>
        <?php if ($order['payment_date']): ?>
        <div>
            <strong>Tanggal Pembayaran:</strong> <?php echo date('d F Y H:i', strtotime($order['payment_date'])); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>


<div class="order-items">
    <h3>Item Pesanan</h3>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Produk</th> <th style="width: 20%;">Harga</th> <th style="width: 10%;">Jumlah</th> <th style="width: 20%;">Subtotal</th> </tr>
        </thead>
        <tbody>
            <?php while ($item = $items_result->fetch_assoc()):
                 $item_image = (!empty($item['gambar']) && file_exists($item['gambar'])) ? htmlspecialchars($item['gambar']) : '../uploads/default-book.jpg'; // Path relatif dari get_order_detail.php
            ?>
            <tr>
                 <td class="item-title-cell">
                      <img src="<?= $item_image ?>" alt="Book cover" class="item-image">
                      <span><?php echo htmlspecialchars($item['judul']); ?></span>
                 </td>
                <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                <td style="text-align: center;"><?php echo $item['quantity']; ?></td> <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Subtotal Produk</strong></td>
                <td>Rp <?php echo number_format($order['total_harga'] - $order['biaya_ongkir'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Biaya Pengiriman</strong></td>
                <td>Rp <?php echo number_format($order['biaya_ongkir'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Total Keseluruhan</strong></td>
                <td><strong>Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="update-status">
    <h3>Perbarui Status Pesanan</h3>
    <form method="post" action="admin_orders.php"> <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
        <div class="form-group">
            <label for="new_status_<?php echo $order['id']; ?>">Pilih Status Baru:</label> <select name="new_status" id="new_status_<?php echo $order['id']; ?>" class="form-control">
                <?php foreach ($status_options as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php echo ($order['status'] == $key) ? 'selected' : ''; /* [Source 773] */ ?>>
                        <?php echo $value; ?>
                        </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="update_status" class="btn btn-primary">Perbarui Status</button>
    </form>
</div>