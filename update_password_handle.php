<?php
session_start();
require 'conn/connect.php';

if (!isset($_SESSION['customerid'])) {
    header('Location: login.php');
    exit;
}

$db = Database::getInstance();
$uid = $_SESSION['customerid'];

$old = trim($_POST['old_password']);
$new = trim($_POST['new_password']);
$re  = trim($_POST['re_password']);

if ($old === '' || $new === '' || $re === '') {
    $_SESSION['msg'] = '<div class="alert alert-danger">Không được để trống</div>';
    header('Location: update_password.php');
    exit;
}

if ($new !== $re) {
    $_SESSION['msg'] = '<div class="alert alert-danger">Password mới không khớp</div>';
    header('Location: update_password.php');
    exit;
}

// lấy password hiện tại
$stmt = $db->prepare("SELECT pass FROM users WHERE id = ?");
$stmt->execute([$uid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || sha1($old) !== $user['pass']) {
    $_SESSION['msg'] = '<div class="alert alert-danger">Password hiện tại sai</div>';
    header('Location: update_password.php');
    exit;
}

// update
$stmt = $db->prepare("UPDATE users SET pass = ? WHERE id = ?");
$stmt->execute([sha1($new), $uid]);

$_SESSION['msg'] = '<div class="alert alert-success">Cập nhật password thành công</div>';
header('Location: update_password.php');
exit;
