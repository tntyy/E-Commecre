<?php
session_start();
require_once __DIR__ . '/../conn/connect.php';
$db = Database::getInstance();

$total = $_SESSION['cart_total'] ?? 0;
$usd_amount = round($total / 25000, 2); // quy đổi sang USD

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
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="business" value="sb-0z12f48367938@business.example.com">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="HoaDonMuaHang">

    <label for="amount">Nhập số tiền hóa đơn :</label>
    <input type="number" id="amount" name="amount" value="<?php echo $usd_amount; ?>" readonly>

    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="http://localhost/E-Commerce/thanhcong.php">
    <input type="hidden" name="cancel_return" value="http://localhost/E-Commerce/loi.php">

    <input type="submit" name="submit" value="Thanh toán qua Paypal">
  </form>
</fieldset>

<?php
include '../template/footer.php';
?>