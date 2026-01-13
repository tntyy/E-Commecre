<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'conn/connect.php';

$db = Database::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // bật lỗi PDO

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = (int)$_GET['id'];

// Ngăn xóa chính bản thân nếu đang đăng nhập
if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id) {
    $_SESSION['msg'] = "Bạn không thể xóa chính mình!";
    header("Location: admin.php");
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['msg'] = "Quản trị viên đã xóa thành công";
} catch (PDOException $e) {
    $_SESSION['msg'] = "Không thể xóa admin: " . $e->getMessage();
}

header("Location: admin.php");
exit;
?>
