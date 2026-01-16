<?php
session_start();
require 'conn/connect.php';
include 'template/header.php';
include 'template/nav.php';

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}


?>
<style>
   

/* Avatar */
.avatar {
  border-radius: 50%;
  border: 3px solid #007bff;
  margin-bottom: 15px;
}

/* Input */
.form-control {
  border-radius: 5px;
  border: 1px solid #ccc;
  transition: 0.3s;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 8px rgba(0,123,255,0.3);
}

/* Nút */
.btn {
  border-radius: 5px;
  padding: 8px 20px;
  font-weight: bold;
}

.btn-primary {
  background-color: #007bff;
  border: none;
}

.btn-info {
  background-color: #17a2b8;
  border: none;
}

/* Link Sign Up */
a {
  display: inline-block;
  margin-top: 10px;
  color: #007bff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

/* Căn giữa form */
.chinhcss {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 50px;
}

/* Panel */
.panel {
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  background: #fff;
  padding: 25px;
  transition: transform 0.3s ease;
}

.panel:hover {
  transform: translateY(-5px);
}

</style>
<div class="chinhcss">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="panel">
          <div class="panel-body">

            <form action="lost_password_handle.php" method="post">
              <div class="text-center">
                <h3>Lost Password</h3>
                <img width="100" height="100" src="images/human-avatar.jpg" class="avatar">
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="text-center mt-3">
                <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include 'template/footer.php';
?>