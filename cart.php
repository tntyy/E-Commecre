<?php 
session_start();
require_once __DIR__ . '/conn/connect.php';   // Sử dụng PDO
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';
?>

<div class="container">
    <div class="row">
        <table class="table">
            <tr>
                <th>S.Number</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Currency</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php
                $total = 0;
                $i = 1;

                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                    foreach ($_SESSION['cart'] as $id => $quantity) {

                        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
                        $stmt->execute([$id]);
                        $r = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (!$r) continue;

                        $subTotal = $r['price'] * $quantity;
                        $total += $subTotal;
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= htmlspecialchars($r['title']) ?></td>
                    <td><?= number_format($r['price'], 0, ',', '.') ?> VND</td>

                    <td><?= $quantity ?></td>

                    <td><?= number_format($subTotal, 0, ',', '.') ?> VND</td>

                    <td>
                        <img src="images/<?= htmlspecialchars($r['image']) ?>"
                            style="width:90px;">
                    </td>

                    <td>
                        <a href="delcart.php?remove=<?= $id ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Remove this item?')">
                        Remove
                        </a>
                    </td>
                </tr>
                <?php
                        $i++;
                    }
                }

                $_SESSION['cart_total'] = $total; // luu tổng tiền vào session
                ?>


           <tr>
                <td colspan="4" align="right"><strong>Total</strong></td>
                <td><strong><?= number_format($total, 0, ',', '.') ?> VND</strong></td>
                <td></td>
                <td>
                    <a href="checkout.php" class="btn btn-success btn-sm">Checkout</a>
                </td>
            </tr>


        </table>
    </div>
    <button onclick="window.location.href='index.php'" class="btn btn-primary">
        Continue Shopping   
    </button>
</div>

<?php include 'template/footer.php'; ?>
