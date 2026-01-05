<?php
require_once 'sign_up_process.php';
$token = md5(uniqid(rand(), TRUE)); // Tạo token ngẫu nhiên
$_SESSION['token'] = $token;

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
    <div class="col-md-offset-3 col-md-6">
      <h2>Signup Form</h2>
      <form action="sign_up.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        
        <div class="form-group">
          <b>Username</b>
          <input class="form-control" type="text" name="username" placeholder="Enter Username" value="<?php if(isset($lastname)) echo $lastname ?>" />
          <?php if(isset($Error['lastname'])) echo $Error['lastname'] ?><br>
        </div>
        
        <div class="form-group">
          <b>Password</b>
          <input class="form-control" type="password" name="password" placeholder="Enter Password" value="<?php if(isset($password)) echo $password ?>" />
          <?php if(isset($Error['password'])) echo $Error['password'] ?><br>
        </div>
        
        <div class="form-group">
          <b>Repeat Password</b>
          <input class="form-control" type="password" name="password_repeat" placeholder="Repeat Password" value="<?php if(isset($password_repeat)) echo $password_repeat ?>" />
          <?php if(isset($Error['password_repeat'])) echo $Error['password_repeat'] ?><br>
        </div>
        
        <div class="form-group">
          <b>Email</b>
          <input class="form-control" type="text" name="email" placeholder="Enter Email" value="<?php if(isset($email)) echo $email ?>" />
          <?php if(isset($Error['email'])) echo $Error['email'] ?><br>
        </div>
        
        <button type="submit" class="btn btn-primary">Sign Ups</button>
        <button type="button" class="btn btn-info">Cancel</button>
      </form>
    </div>
  </div>
</div>
</div>
<?php
include 'template/footer.php';
?>