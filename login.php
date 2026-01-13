<?php
require 'conn/connect.php';
include 'template/header.php';
include 'template/nav.php';
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
  margin-left: 500px;
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
  <div class="row">
    <div class="content-blog">
      <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <form action="login_process.php" method="post">
              <div class="text-center">
                <h3>Login Form</h3>
                <img width="100" height="100" src="images/human-avatar.jpg" alt="Avatar" class="avatar" >
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
              <button type="button" class="btn btn-info">Cancel</button>
              <a href="sign_up.php">Sign Up</a> (If you do not already have an account)
            </form><br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
include 'template/footer.php';
?>