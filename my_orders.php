<?php
session_start();
require_once __DIR__ . '/conn/connect.php';
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';

// Lấy uid từ session
$uid = $_SESSION['uid'] ?? 0;

if ($uid > 0) {
    $stmt = $db->prepare("SELECT * FROM orders WHERE uid = ? ORDER BY created_at DESC");
    $stmt->execute([$uid]);
} else {
    $stmt = $db->query("SELECT * FROM orders ORDER BY created_at DESC");
}
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
                    <td><?= number_format($order['totalprice'], 0, ',', '.') ?> VND</td>
                    <td><?= htmlspecialchars($order['orderstatus']) ?></td>
                    <td><?= htmlspecialchars($order['paymentmode']) ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td>
                        <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Bạn chưa có đơn hàng nào.</p>
    <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>