<?php 

session_start();
require('conn/connect.php'); // File kết nối phải ở trên cùng

// Nếu chưa đăng nhập → chuyển về login
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    $_SESSION['redirect_after_login'] = 'checkout.php'; // lưu lại trang muốn vào
    header("Location: login.php");
    exit;
}

// 1. Kiểm tra đăng nhập
if(!isset($_SESSION['customer']) || empty($_SESSION['customer'])){
    header("Location: login.php");
    exit;
}
if (!isset($_POST['checkout_items']) || empty($_POST['checkout_items'])) {
    header("Location: .php");
    exit;
}

$selectedItems = $_POST['checkout_items'];
$_SESSION['selected_items'] = $selectedItems; 
$cart = $_SESSION['cart'];

$uid = $_SESSION['customerid'];
$total = 0;
$countproduct = 0;
$connection = Database::getInstance();

// 2. Xử lý Logic (Tính tiền và Lưu Database)
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    $cart = $_SESSION['cart'];

    // Tính toán tổng tiền
    foreach ($selectedItems as $id){
        if (!isset($cart[$id])) continue;
        $quantity = $cart[$id];
        $stmt = $connection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row_product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row_product){
            $total = $total + ($row_product['price'] * $quantity);
            $countproduct += $quantity;
        }
    }

    // Xử lý khi người dùng nhấn nút "Pay Now"
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])){

        $method = $_POST['payment'] ?? '';   // Lấy giá trị từ radio button "payment"
        if ($_POST['agree'] == "true") {
            // Lấy dữ liệu form
            $country   = $_POST['country'];
            $firstname = $_POST['fname'];
            $lastname  = $_POST['lname'];
            $company   = $_POST['company'];
            $address1  = $_POST['address1'];
            $address2  = $_POST['address2'];
            $city      = $_POST['city'];
            $state     = $_POST['state'];
            $zip       = $_POST['zipcode'];
            $mobile    = $_POST['phone'];
            $payment   = $_POST['payment'];

            // Kiểm tra/Cập nhật usermeta
            $stmt_check = $connection->prepare("SELECT * FROM usersmeta WHERE uid = ?");
            $stmt_check->execute([$uid]);
            
            if ($stmt_check->rowCount() == 1) {
                $sql_meta = "UPDATE usersmeta SET country=?, firstname=?, lastname=?, company=?, address1=?, address2=?, city=?, state=?, zip=?, mobile=? WHERE uid=?";
                $stmt_meta = $connection->prepare($sql_meta);
                $res_meta = $stmt_meta->execute([$country, $firstname, $lastname, $company, $address1, $address2, $city, $state, $zip, $mobile, $uid]);
            } else {
                $sql_meta = "INSERT INTO usersmeta(country, firstname, lastname, company, address1, address2, city, state, zip, mobile, uid) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
                $stmt_meta = $connection->prepare($sql_meta);
                $res_meta = $stmt_meta->execute([$country, $firstname, $lastname, $company, $address1, $address2, $city, $state, $zip, $mobile, $uid]);
            }

            if ($res_meta) {

               
                    $stmt_order = $connection->prepare(
                        "INSERT INTO orders(uid, totalprice, paymentmode, orderstatus)
                        VALUES(?, ?, ?, ?)"
                    );
                    $res_order = $stmt_order->execute([
                        $uid,
                        $total,
                        $method,
                        'Order placed'
                    ]);
                
                if ($res_order) {
                    $orderid = $connection->lastInsertId(); 
                    foreach ($selectedItems as $id) {   // ✅ CHỈ ITEM ĐƯỢC CHECK

                        if (!isset($cart[$id])) continue;

                        $quantity = $cart[$id];

                        $stmt_p = $connection->prepare("SELECT price FROM products WHERE id = ?");
                        $stmt_p->execute([$id]);
                        $price = $stmt_p->fetchColumn();

                        $stmt_item = $connection->prepare("
                            INSERT INTO orderitems(pid, pquantity, orderid, productprice)  
                            VALUES(?,?,?,?)
                        "); 
                        $stmt_item->execute([
                            $id,
                            $quantity,
                            $orderid,
                            $price
                        ]); 
                    }

                    $_SESSION['order_id'] = $orderid; // Lưu order ID vào session để sử dụng sau này
                    // xu lý tiếp theo dựa trên phương thức thanh toán

                    // XỬ LÝ THEO PHƯƠNG THỨC THANH TOÁN
                if ($method === 'cod') {

                    $_SESSION['payment_mode'] = 'cod';
                    $_SESSION['order_id'] = $orderid;

                    // COD → xong luôn
                   foreach ($selectedItems as $id) {
                        unset($_SESSION['cart'][$id]);
                    }

                    header("Location: ThanhToanPayPal/thanhcong.php");
                    exit;
                }

                if ($method === 'paypal') {

                    // PAYPAL → KHÔNG XOÁ CART Ở ĐÂY
                    $_SESSION['payment_mode'] = 'paypal';
                    $_SESSION['order_id'] = $orderid;
                    $_SESSION['paypal_total'] = $total;

                    header("Location: ThanhToanPayPal/TestThanhToan.php");
                    exit;
                }

                    
                }

               
            }
        }
    }
}

// 3. Hiển thị Giao diện (Sau khi đã xử lý xong logic)
include('template/header.php');
include('template/nav.php');
?>



<style>
    /* Tổng thể trang */
    body { background-color: #f8f9fa; }
    .content { padding: 40px 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    /* Khối trắng bao quanh (Card) */
    .checkout-card {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    h3, h4 { 
        color: #333; 
        font-weight: 600; 
        border-bottom: 2px solid #eee; 
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    /* Tùy chỉnh Input */
    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        height: auto;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.25);
    }
    label { font-weight: 500; margin-bottom: 8px; color: #555; }

    /* Bảng đơn hàng */
    .table { margin-top: 10px; }
    .table th { background-color: #fdfdfd; color: #666; font-weight: 600; }
    .table td { font-weight: 700; color: #333; }

    /* Phương thức thanh toán */
    .payment-method {
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 6px;
        margin-bottom: 15px;
        transition: 0.3s;
    }
    .payment-method:hover { background: #fcfcfc; }
    .payment-method p { font-size: 13px; color: #888; margin-top: 5px; }

    /* Nút bấm */
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 12px 40px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }
</style>
<div class="content">
    <div class="container">
        <form method="post">
            <?php foreach ($selectedItems as $id): ?>
                <input type="hidden" name="checkout_items[]" value="<?= $id ?>">
            <?php endforeach; ?>

            <div class="row">
                <div class="col-md-7">
                    <div class="checkout-card">
                        <h3><i class="fa fa-map-marker"></i> Billing Details</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Country</label>
                                <select name="country" class="form-control">
                                    <option value="">Select Country</option>
                                    <option value="VN">Việt Nam</option>
                                    <option value="CH">China</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3" style="margin-top: 15px;">
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="fname" placeholder="John" required>
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="lname" placeholder="Doe" required>
                            </div>
                        </div>

                        <div class="mt-3" style="margin-top: 15px;">
                            <label>Company (Optional)</label>
                            <input type="text" class="form-control" name="company" required>
                        </div>

                        <div class="mt-3" style="margin-top: 15px;">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address1" placeholder="Street address" required>
                            <input type="text" class="form-control mt-2" name="address2" placeholder="Apartment, suite, unit etc. (optional)" style="margin-top: 10px;" required>
                        </div>

                        <div class="row mt-3" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" required>
                            </div>
                            <div class="col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" required>
                            </div>
                            <div class="col-md-4">
                                <label>Postcode</label>
                                <input class="form-control" type="text" min="1" step="1" required name="zipcode" required>
                            </div>
                        </div>

                        <div class="mt-3" style="margin-top: 15px;">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]{10,}" minlength="10" name="phone">
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="checkout-card">
                        <h4>Your Order</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Cart Subtotal</th>
                                <td class="text-right"><?php echo $countproduct; ?> items</td>
                            </tr>
                            <tr>
                                <th>Shipping</th>
                                <td class="text-success text-right">Free Shipping</td>
                            </tr>
                            <tr style="font-size: 1.2em; background: #f9f9f9;">
                                <th>Total</th>
                                <td class="text-primary text-right"><?php echo number_format($total); ?> VNĐ</td>
                            </tr>
                        </table>

                        <h4 class="mt-4" style="margin-top: 30px;">Payment Method</h4>
                        <div class="payment-method">
                            <input type="radio" name="payment" value="cod" id="cod" checked>
                            <label for="cod">Cash On Delivery (COD)</label>
                            <p>Pay with cash upon delivery.</p>
                        </div>

                        <div class="payment-method">
                            <input type="radio" name="payment" value="paypal" id="paypal">
                            <label for="paypal">PayPal</label>
                            <p>Pay via PayPal; you can pay with credit card.</p>
                        </div>

                        <div class="mt-4" style="margin-top: 20px;">
                            <label style="font-weight: normal; cursor: pointer;">
                                <input type="checkbox" name="agree" value="true" required> 
                                I've read and accept the <a href="#">terms & conditions</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block w-100" style="width: 100%; margin-top: 20px;">
                            Place Order Now
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php 
include('template/footer.php');
?>


