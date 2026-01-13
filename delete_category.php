<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'conn/connect.php';

$db = Database::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // bật lỗi PDO

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['msg'] = "Mã số danh mục chưa được cung cấp!";
    header("Location: category.php");
    exit;
}

$id = (int)$_GET['id'];

// Kiểm tra category có tồn tại không
$stmt = $db->prepare("SELECT * FROM category WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    $_SESSION['msg'] = "Danh mục không tồn tại, không thể xóa!";
    header("Location: category.php");
    exit;
}

// Kiểm tra category có sản phẩm liên quan không
$stmt = $db->prepare("SELECT COUNT(*) as total FROM products WHERE id = ?");
$stmt->execute([$id]);
$productCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($productCount > 0) {
    $_SESSION['msg'] = "Không thể xóa danh mục vì nó có $productCount sản phẩm!";
    header("Location: category.php");
    exit;
}

// Xóa category
try {
    $stmt = $db->prepare("DELETE FROM category WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['msg'] = "Danh mục đã được xóa thành công!";
} catch (PDOException $e) {
    $_SESSION['msg'] = "Không thể xóa danh mục: " . $e->getMessage();
}

header("Location: category.php");
exit;
?>
