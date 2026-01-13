<?php
// delete_product.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'conn/connect.php';
$db = Database::getInstance();

// Kiểm tra ID sản phẩm được truyền qua GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID sản phẩm không hợp lệ!");
}

$id = (int)$_GET['id'];

// Lấy tên ảnh hiện tại để xóa file nếu có
$stmt = $db->prepare("SELECT image, catid FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Sản phẩm không tồn tại!");
}

// Xóa sản phẩm trong DB
$stmtDel = $db->prepare("DELETE FROM products WHERE id = ?");
$stmtDel->execute([$id]);

// Xóa file ảnh nếu tồn tại
if (!empty($product['image']) && file_exists('images/' . $product['image'])) {
    unlink('images/' . $product['image']);
}

// Chuyển về trang quản lý sản phẩm với category_id
header("Location: xoasua.php?category_id=" . $product['catid']);
exit;
