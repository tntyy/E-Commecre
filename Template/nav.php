<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../conn/connect.php';
$db = Database::getInstance();

function brandKey($name) {
    return strtolower(str_replace(' ', '', $name));}

$sql = "SELECT id, name FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
    /* FONT */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');




/* ========== MENU MERCEDES ========== */
.menu-wrap {
    width: 100%;
    background: #000;
    padding: 12px 0;
    margin-top: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.35);
}

.menu-wrap ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    gap: 28px;
    align-items: center;
}

.menu-wrap ul li {
    position: relative;
}

.menu-wrap ul li a {
    text-decoration: none;
    color: #f7f7f7;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s;
}

.menu-wrap ul li a:hover {
    color: #ffcc00;
}

/* ========== DROPDOWN ========== */
.dropdown2:hover .dropdown-content2 {
    display: block;
}

.dropdown-content2 {
    display: none;
    position: absolute;
    top: 45px;
    background: #1a1a1a;
    min-width: 200px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    z-index: 1000;
}

.dropdown-content2 a {
    padding: 12px 15px;
    color: #eee;
    border-bottom: 1px solid #333;
    font-size: 15px;
}

.dropdown-content2 a:hover {
    background: #333;
    color: #ffcc00;
}

.dropdown-content2 a:last-child {
    border-bottom: none;
}

/* ========== RESPONSIVE ========== */
@media(max-width: 768px) {
    .menu-wrap ul {
        flex-direction: column;
        gap: 15px;
    }

    .dropdown-content2 {
        position: static;
        width: 100%;
        box-shadow: none;
    }
}

</style>

<div class="container">
    <div class="row">
        <div class="menu-wrap">
            <ul>

            <li><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>

            <li class="dropdown2">
                <a href="products.php"><i class="fa-solid fa-car"></i> Cars</a>
                <div class="dropdown-content2">
                    <?php foreach ($categories as $c): ?>
                        <a href="cate.php?brand=<?= brandKey($c['name']) ?>">
                            <i class="fa-solid fa-angles-right"></i>
                            <?= htmlspecialchars($c['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>


            <?php if (isset($_SESSION['customer'])): ?>
                <li class="dropdown2">
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        <?= htmlspecialchars($_SESSION['customer']) ?>
                    </a>
                    <div class="dropdown-content2">
                        <a href="my_orders.php"><i class="fa-solid fa-receipt"></i> My Orders</a>
                        <a href="my_wishlist.php"><i class="fa-solid fa-heart"></i> Wishlist</a>
                        <a href="edit_profile.php"><i class="fa-solid fa-pen"></i> Edit Profile</a>
                        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="sign_up.php">Register</a></li>
            <?php endif; ?>


            <!-- CART -->
            <li>
                <a href="cart.php">
                    <i class="fa-solid fa-cart-shopping"></i> Check Out
                </a>
            </li>

        </ul>

        </div>
    </div>
</div>
