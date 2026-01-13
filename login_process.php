<?php
session_start();
require_once 'conn/connect.php';

$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// Lấy dữ liệu (login KHÔNG cần htmlspecialchars)
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Kiểm tra rỗng
if ($email === '' || $password === '') {
    header("Location: login.php");
    exit;
}

// Lấy user theo email
$stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra mật khẩu (SHA1 – giữ đúng DB hiện tại)
if ($user && $user['pass'] === sha1($password)) {

    // Lưu session
    $_SESSION['customer']   = $user['email'];
    $_SESSION['customerid'] = $user['id'];
    $_SESSION['type']       = $user['type'];

    // ===== PHÂN LUỒNG =====
    if ($user['type'] === 'admin') {
        header("Location: admin.php");
        exit;
    }

    // USER THƯỜNG
    if (!empty($_SESSION['cart'])) {
        header("Location: checkout.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

// Sai thông tin
header("Location: login.php?error=1");
exit;
?>