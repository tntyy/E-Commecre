<?php
session_start();
require_once __DIR__ . '/../conn/connect.php';
$db = Database::getInstance();

$orderId = $_SESSION['order_id'] ?? 0;
if ($orderId <= 0) {
    echo "Đơn hàng không hợp lệ";
    exit;
}

$stmt = $db->prepare("SELECT totalprice FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$total = $stmt->fetchColumn();

$usd_amount = number_format($total / 25000, 2, '.', '');

include '../template/header.php';
include '../template/nav.php';
?>
<style>
fieldset {
  border: 2px solid #0070ba; /* màu xanh PayPal */
  border-radius: 8px;
  padding: 20px;
  max-width: 400px;
  margin: 30px auto;
  background: #f9f9f9;
}

legend {
  font-size: 1.2em;
  font-weight: bold;
  color: #0070ba;
  padding: 0 10px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

form input[type="number"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

form input[type="submit"] {
  background-color: #0070ba;
  color: white;
  border: none;
  padding: 10px;
  font-size: 1em;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.3s;
}

form input[type="submit"]:hover {
  background-color: #005c99;
}
</style>

<fieldset>
  <legend>Thanh toán qua cổng PayPal</legend>
  <div style="text-align:center; margin-bottom:20px;">
    <p style="font-size:16px;">
        <strong>Tổng tiền (VNĐ):</strong>
        <?= number_format($total, 0, ',', '.') ?> đ
    </p>
    <p style="font-size:18px; color:#0070ba;">
        <strong>Thanh toán PayPal (USD):</strong>
        $<?= $usd_amount ?>
    </p>
</div>
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="business" value="sb-0z12f48367938@business.example.com">
    <input type="hidden" name="cmd" value="_xclick">

    <input type="hidden" name="item_name" value="HoaDonMuaHang">
    <!-- 🔥 QUAN TRỌNG -->
    <input type="hidden" name="custom" value="<?= $orderId ?>">

    <input type="hidden" name="amount" value="<?= $usd_amount ?>">
    <input type="hidden" name="currency_code" value="USD">

    <input type="hidden" name="return" value="http://localhost/E-Commerce/ThanhToanPayPal/thanhcong.php">
    <input type="hidden" name="cancel_return" value="http://localhost/E-Commerce/loi.php">

    <input type="submit" value="Thanh toán PayPal">
</form>


</fieldset>

<?php
include '../template/footer.php';
?>