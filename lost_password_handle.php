<?php
session_start();
require_once 'conn/connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: lost_password.php');
    exit;
}

$email = trim($_POST['email']);

if ($email === '') {
    $_SESSION['msg'] = '<div class="alert alert-danger">Email không được để trống</div>';
    header('Location: lost_password.php');
    exit;
}

$db = Database::getInstance();

// 1. Check email
$stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() === 0) {
    $_SESSION['msg'] = '<div class="alert alert-danger">Email không tồn tại</div>';
    header('Location: lost_password.php');
    exit;
}

// 2. Tạo password mới
$new_password = substr(md5(uniqid()), 0, 8);
$password_hash = sha1($new_password);

// 3. Update
$stmt = $db->prepare("UPDATE users SET pass = ? WHERE email = ?");
$stmt->execute([$password_hash, $email]);

// 4. Thông báo
$_SESSION['msg'] = "
<div class='alert alert-success'>
    Password mới của bạn là: <b>$new_password</b><br>
    Hãy đăng nhập và đổi lại ngay!
</div>";

header('Location: lost_password.php');
exit;
?>