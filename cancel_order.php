<?php
session_start();
require_once __DIR__ . '/conn/connect.php';
$db = Database::getInstance();

if (!isset($_GET['id'], $_SESSION['customerid'])) {
    header('Location: my_orders.php');
    exit;
}

$orderId = (int)$_GET['id'];
$uid = (int)$_SESSION['customerid'];

// Kiểm tra đơn hàng có thuộc user không & có được hủy không
$stmt = $db->prepare("
    SELECT orderstatus 
    FROM orders 
    WHERE id = ? AND uid = ?
");
$stmt->execute([$orderId, $uid]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: my_orders.php');
    exit;
}

if ($order['orderstatus'] !== 'Order placed') {
    header('Location: my_orders.php');
    exit;
}

// Cập nhật trạng thái hủy
$stmt = $db->prepare("
    UPDATE orders 
    SET orderstatus = 'Cancelled' 
    WHERE id = ?
");
$stmt->execute([$orderId]);

header('Location: my_orders.php');
exit;
?>