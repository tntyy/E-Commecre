<?php
session_start();
require_once __DIR__ . '/conn/connect.php';
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';

if (!isset($_GET['id'], $_SESSION['customerid'])) {
    header('Location: my_orders.php');
    exit;
}

$orderId = (int)$_GET['id'];
$uid = (int)$_SESSION['customerid'];

/* LẤY THÔNG TIN ĐƠN HÀNG */
$stmt = $db->prepare("
    SELECT *
    FROM orders
    WHERE id = ? AND uid = ?
");
$stmt->execute([$orderId, $uid]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo '<div class="container"><div class="alert alert-danger">Order not found</div></div>';
    include 'template/footer.php';
    exit;
}

/* LẤY CHI TIẾT SẢN PHẨM */
$stmt = $db->prepare("
    SELECT 
        oi.pquantity,
        oi.productprice,
        p.title,
        p.image
    FROM orderitems oi
    JOIN products p ON oi.pid = p.id
    WHERE oi.orderid = ?
");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    /* ===== ORDER DETAIL ===== */
.order-title {
    font-weight: 700;
    letter-spacing: 0.5px;
}

.order-info p {
    margin-bottom: 6px;
    font-size: 15px;
}

.badge-status {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 20px;
}

/* trạng thái */
.badge-pending { background: #ffc107; color: #000; }
.badge-completed { background: #28a745; color: #fff; }
.badge-cancelled { background: #dc3545; color: #fff; }

.table th {
    background: #111;
    color: #ffcc00;
    text-align: center;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
    text-align: center;
}

.table td:first-child {
    text-align: left;
    font-weight: 500;
}

.product-img {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.total-box {
    background: #111;
    color: #fff;
    padding: 15px 20px;
    border-radius: 12px;
    text-align: right;
    font-size: 20px;
    font-weight: 700;
}

.total-box span {
    color: #ffcc00;
}

.card {
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.back-btn {
    border-radius: 30px;
    padding: 10px 22px;
}

</style>

<div class="container my-5">

    <h2 class="order-title mb-4">
        Order #<?= $order['id'] ?>
    </h2>



    <!-- THÔNG TIN ĐƠN -->
    <div class="card mb-4">
        <div class="card-body order-info">
            <p>
                <strong>Status:</strong>
                <?php
                    $status = strtolower($order['orderstatus']);
                    $badgeClass = match($status) {
                        'pending' => 'badge-pending',
                        'completed' => 'badge-completed',
                        'cancelled' => 'badge-cancelled',
                        default => 'badge-secondary'
                    };
                ?>
                <span class="badge badge-status <?= $badgeClass ?>">
                    <?= htmlspecialchars($order['orderstatus']) ?>
                </span>
            </p>
            <p><strong>Payment:</strong> <?= htmlspecialchars($order['paymentmode']) ?></p>
            <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
        </div>
    </div>


    <!-- DANH SÁCH SẢN PHẨM -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $grandTotal = 0;
                foreach ($items as $item): 
                    $sub = $item['pquantity'] * $item['productprice'];
                    $grandTotal += $sub;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td>
                            <img src="images/<?= htmlspecialchars($item['image']) ?>" 
                                 width="80" class="product-img">

                        </td>
                        <td><?= number_format($item['productprice'], 0, ',', '.') ?> VND</td>
                        <td><?= $item['pquantity'] ?></td>
                        <td><?= number_format($sub, 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box mt-3">
                Total: <span><?= number_format($grandTotal, 0, ',', '.') ?> VND</span>
            </div>


        </div>
    </div>

    <a href="my_orders.php" class="btn btn-secondary mt-4">← Back to orders</a>

</div>

<?php include 'template/footer.php'; ?>
