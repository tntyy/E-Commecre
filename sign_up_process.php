<?php
session_start();
require_once 'conn/connect.php';

$username = $password = $email = "";
$error = array();

if (isset($_POST['token']) && trim($_POST['token']) == trim($_SESSION['token'])) {
    $username = input_data($_POST['username']);
    $password = input_data($_POST['password']);
    $password_repeat = input_data($_POST['password_repeat']);
    $email = input_data($_POST['email']);

    if (empty($username))
        $error['username'] = "Username không được để trống";
    if (empty($password))
        $error['password'] = "Password không được để trống";
    if (empty($password_repeat))
        $error['password_repeat'] = "Password_repeat không được để trống";
    if (empty($email))
        $error['email'] = "Email không được để trống";

    if (!$error) {
        $password = sha1($password);
        
     
        $connection = Database::getInstance(); // Lấy kết nối PDO từ Class của bạn
        
        $sql_insert = "INSERT INTO Users(username, pass, email, date_expires)
                       VALUES(:username, :password, :email, ADDDATE(NOW(), INTERVAL 1 MONTH))";
        
        $stmt = $connection->prepare($sql_insert);
        $result = $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':email'    => $email
        ]);

        if ($result) {
            header('Location: login.php');
            exit;
        }
        // ---------------------
    }
}

// Hàm lọc dữ liệu đầu vào để tăng bảo mật
function input_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>