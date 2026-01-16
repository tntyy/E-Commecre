<?php
session_start();
require 'conn/connect.php';
include 'template/header.php';
include 'template/nav.php';

// kiểm tra đăng nhập
if (!isset($_SESSION['customerid'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<style>
    /* ===== ADD CATEGORY FORM ONLY ===== */
.add-category-wrapper {
    background: #ffffff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

.add-category-wrapper h1 {
    font-size: 36px;
    font-weight: 700;
    color: #2b5876;
    margin-bottom: 30px;
}

.add-category-wrapper .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.add-category-wrapper .form-control {
    border-radius: 12px;
    padding: 14px;
    font-size: 15px;
    border: 1px solid #ddd;
}

.add-category-wrapper .form-control:focus {
    border-color: #ffcc00;
    box-shadow: 0 0 0 0.2rem rgba(255, 204, 0, 0.25);
}

.add-category-wrapper .btn-primary {
    background: linear-gradient(135deg, #ffcc00, #f7b500);
    border: none;
    color: #000;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 30px;
}

.add-category-wrapper .btn-primary:hover {
    opacity: 0.9;
}

.add-category-wrapper .btn-secondary {
    border-radius: 30px;
    padding: 12px 28px;
}

.add-category-wrapper .alert {
    border-radius: 12px;
    font-size: 14px;
}

</style>
<div class="container add-category-wrapper" style="padding: 40px 20px; max-width: 700px; margin: 40px auto;">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="panel">
        <h3 class="text-center">Update Password</h3>

        <form action="update_password_handle.php" method="post">
          <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="old_password" class="form-control" required>
          </div>

          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Repeat New Password</label>
            <input type="password" name="re_password" class="form-control" required>
          </div>

          <div class="text-center mt-3">
            <button class="btn btn-primary">Update</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
