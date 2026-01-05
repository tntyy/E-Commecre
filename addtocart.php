<?php
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = (int) $_GET['id'];

    $quantity = (isset($_GET['quantity']) && $_GET['quantity'] > 0)
                ? (int) $_GET['quantity']
                : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu đã có sản phẩm → cộng số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } 
    // Nếu chưa có → thêm mới
    else {
        $_SESSION['cart'][$id] = $quantity;
    }

    header("Location: cart.php?status=success");
    exit;
}

header("Location: cart.php?status=failed");
exit;
?>