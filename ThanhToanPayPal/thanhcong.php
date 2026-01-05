<?php
session_start();
require_once __DIR__ . '/../conn/connect.php';
$db = Database::getInstance();

// Lấy uid từ session
$uid = $_SESSION['id'] ?? 0;
if ($uid == 0) {
    echo "<p>Bạn cần đăng nhập trước khi thanh toán.</p>";
    exit;
}
$total = $_SESSION['cart_total'] ?? 0;

// Nếu không có giỏ hàng thì thoát
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Không có giỏ hàng để lưu đơn.</p>";
    exit;
}

// Lưu đơn hàng vào bảng orders
$stmt = $db->prepare("INSERT INTO orders (uid, totalprice, orderstatus, paymentmode) VALUES (?, ?, ?, ?)");
$stmt->execute([$uid, $total, 'Order placed', 'paypal']);
$orderId = $db->lastInsertId();

// Lưu chi tiết sản phẩm vào bảng orderitems
foreach ($_SESSION['cart'] as $pid => $quantity) {
    $stmt = $db->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$pid]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $stmt = $db->prepare("INSERT INTO orderitems (orderid, pid, pquantity, productprice) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $pid, $quantity, $product['price']]);
    }
}

// Xoá giỏ hàng sau khi lưu
unset($_SESSION['cart']);
unset($_SESSION['cart_total']);

include 'template/header.php';
include 'template/nav.php';
?>

<div class="container">
    <h2> Thanh toán thành công qua PayPal!</h2>
    <p>Đơn hàng #<?= $orderId ?> đã được ghi nhận.</p>
    <a href="my_orders.php" class="btn btn-info">Xem đơn hàng</a>
</div>

<?php include 'template/footer.php'; ?>