<?php
session_start();

if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
}

header("Location: cart.php");
exit;