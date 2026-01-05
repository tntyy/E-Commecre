<?php
session_start();
require_once 'conn/connect.php'; // file chứa class Database

$db = Database::getInstance();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy & lọc dữ liệu
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    // Truy vấn lấy user theo email
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra mật khẩu
    if ($user && $user['pass'] === sha1($password)) {
        // Nếu bạn đang lưu mật khẩu bằng SHA1
        $_SESSION['customer'] = $user['email'];
        $_SESSION['customerid'] = $user['id'];
       // KIỂM TRA XEM CÓ GIỎ HÀNG KHÔNG
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Nếu có hàng, đẩy sang trang thanh toán
            header("Location: checkout.php");
        } else {
            // Nếu không có hàng (đăng nhập bình thường), đẩy về trang chủ
            header("Location: index.php"); 
        }
        exit;
    } else {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}