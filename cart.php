<?php 
session_start();
require_once __DIR__ . '/conn/connect.php';
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';
?>

<div class="container my-4">
    <div class="row">
        <form method="POST" action="checkout.php" id="cartForm">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>S.Number</th>
                        <th>Check</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $i = 1;

                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $id => $quantity) {

                        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
                        $stmt->execute([$id]);
                        $p = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (!$p) continue;

                        $subTotal = $p['price'] * $quantity;
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="text-center">
                            <input type="checkbox"
                                   name="checkout_items[]"
                                   value="<?= $id ?>"
                                   class="item-checkbox"
                                   data-price="<?= $subTotal ?>">
                        </td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> VND</td>
                        <td><?= $quantity ?></td>
                        <td><?= number_format($subTotal, 0, ',', '.') ?> VND</td>
                        <td>
                            <img src="images/<?= htmlspecialchars($p['image']) ?>"
                                 width="80" class="rounded">
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
                    }
                } else {
                    echo '<tr><td colspan="8" class="text-center">Cart is empty</td></tr>';
                }
                ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total</strong></td>
                        <td colspan="2">
                            <strong id="totalAmount">0 VND</strong>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success w-100">
                                Checkout
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <a href="index.php" class="btn btn-primary">
        ← Continue Shopping
    </a>
</div>

<!-- ================= JS ================= -->
<script>
const checkboxes = document.querySelectorAll('.item-checkbox');
const totalEl = document.getElementById('totalAmount');
const form = document.getElementById('cartForm');

function updateTotal() {
    let total = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) {
            total += parseInt(cb.dataset.price);
        }
    });
    totalEl.innerText = total.toLocaleString('vi-VN') + ' VND';
}

checkboxes.forEach(cb => {
    cb.addEventListener('change', updateTotal);
});

// Không cho checkout nếu chưa chọn
form.addEventListener('submit', function (e) {
    const checked = document.querySelectorAll('.item-checkbox:checked');
    if (checked.length === 0) {
        alert('Please select at least one product to checkout!');
        e.preventDefault();
    }
});
</script>

<?php include 'template/footer.php'; ?>
