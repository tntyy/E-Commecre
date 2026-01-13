<?php
session_start();

// 🔥 PHẢI LẤY custom
$orderId = $_GET['custom'] ?? 0;



// xoá item đã thanh toán
$selectedItems = $_SESSION['selected_items'] ?? [];

foreach ($selectedItems as $id) {
    unset($_SESSION['cart'][$id]);
}

if (empty($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

// dọn session
unset($_SESSION['selected_items']);
unset($_SESSION['cart_total']);
unset($_SESSION['paypal_total']);
unset($_SESSION['payment_mode']);
unset($_SESSION['order_id']);

include __DIR__ . '/../template/header.php';
include __DIR__ . '/../template/nav.php';
?>

<div class="container">
    <h2>Thanh toán thành công!</h2>
    <p>Mã đơn hàng: <strong>#<?= $orderId ?></strong></p>
    <p>Phương thức thanh toán: <strong>PAYPAL</strong></p>
    <a href="../my_orders.php" class="btn btn-info">Xem đơn hàng</a>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
