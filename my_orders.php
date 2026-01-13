<?php
session_start();
require_once __DIR__ . '/conn/connect.php';
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';

// Lấy uid từ session
$uid = $_SESSION['customerid'] ?? 0;

$stmt = $db->prepare("
    SELECT o.*, SUM(oi.pquantity * oi.productprice) AS real_total
    FROM orders o
    JOIN orderitems oi ON o.id = oi.orderid
    WHERE o.uid = ?
    GROUP BY o.id
    ORDER BY o.created_at DESC
");
$stmt->execute([$uid]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h2>My Orders</h2>
    <?php if ($orders): ?>
        <table class="table table-bordered">
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Payment Mode</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= number_format($order['real_total'], 0, ',', '.') ?> VND</td>
                    <td><?= htmlspecialchars($order['orderstatus']) ?></td>
                    <td><?= htmlspecialchars($order['paymentmode']) ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-info btn-sm">View</a>
                        <?php if ($order['orderstatus'] === 'Order placed'): ?>
                            <a href="cancel_order.php?id=<?= $order['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                            Cancel
                            </a>
                            <?php else: ?>
                                <span class="text-muted">Not allowed</span>
                            <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Bạn chưa có đơn hàng nào.</p>
    <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>