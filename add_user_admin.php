<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'conn/connect.php';
$db = Database::getInstance();


// Khởi tạo biến
$msg = '';
$username = '';
$email = '';
$password = '';
$type = 'Admin'; // mặc định là Admin

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        $msg = '<div class="alert alert-danger">Mã thông báo CSRF không hợp lệ</div>';
    } else {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $type = $_POST['type'] ?? 'Admin';

        // Validation
        if ($username === '' || $email === '' || $password === '') {
            $msg = '<div class="alert alert-danger">Vui lòng điền vào tất cả các trường</div>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<div class="alert alert-danger">Định dạng email không hợp lệ</div>';
        } elseif (strlen($password) < 6) {
            $msg = '<div class="alert alert-danger">Password phải có ít nhất 6 ký tự</div>';
        } else {
            $stmtCheck = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmtCheck->execute([$email]);
            if ($stmtCheck->rowCount() > 0) {
                $msg = '<div class="alert alert-warning">Email đã tồn tại</div>';
            } else {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (username, email, pass, type) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $password_hashed, $type]);
                $msg = '<div class="alert alert-success">Người dùng đã được thêm thành công</div>';
                $username = $email = $password = '';
            }
        }
    }
}
$sql = "SELECT id, name FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <title>Admin Dashboard</title>
     <style>
        /* FONT */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
        }

        /* ========== HEADER MERCEDES ========== */
        header {
            background: #111;
            color: white;
            padding: 18px 0;
            border-bottom: 3px solid #ffcc00;
            box-shadow: 0 3px 10px rgba(0,0,0,0.35);
        }

        header h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffcc00;
        }

        header .subtitle {
            font-size: 13px;
            color: #ccc;
        }

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

   /* FOOTER MERCEDES */
.merc-footer {
    background: #0b0b0b;
    color: #e6e6e6;
    padding: 50px 0 20px;
    font-family: 'Poppins', sans-serif;
    margin-top: 400px;
    box-shadow: 0 -4px 25px rgba(0,0,0,0.4);
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 35px;
}

.footer-col h3, 
.footer-col h4 {
    color: #ffcc00;
    margin-bottom: 18px;
    font-weight: 600;
}

.footer-col p, 
.footer-col a {
    color: #e6e6e6;
    font-size: 15px;
    margin-bottom: 10px;
    display: block;
    text-decoration: none;
    transition: 0.3s ease;
}

.footer-col a:hover {
    color: #ffcc00;
    padding-left: 4px;
}

.footer-social a {
    font-size: 22px;
    color: #e6e6e6;
    margin-right: 15px;
    transition: 0.3s ease;
}

.footer-social a:hover {
    color: #ffcc00;
    transform: translateY(-3px);
}

.footer-bottom {
    border-top: 1px solid #333;
    margin-top: 30px;
    padding-top: 15px;
    text-align: center;
    font-size: 14px;
    color: #b5b5b5;
}
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
</head>
<body>
    <header class="py-3">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <img src="images/logo.jpg" alt="logo" width="110" style="margin-right:16px">
        <div>
          <h1 style="margin:0; font-size:46px; letter-spacing:1px;">SHOWROOM NGOC TY</h1>
          <div style="font-size:13px; color:#666">Xe sang – Bảo hành chính hãng</div>
        </div>
      </div>
      <div>
        <!-- nút giỏ hàng / login nếu cần -->
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
        <div class="menu-wrap">
            <ul>

            <li><a href="admin.php"><i class="fa-solid fa-house">ADMIN</i></a>

                
                        <div class="dropdown-content2">
                            <a href="category.php"><i class="fa-solid fa-receipt"></i>Lost Password</a>
                            <a href="category.php"><i class="fa-solid fa-receipt"></i>Remember me</a>
                            <a href="add_category.php"><i class="fa-solid fa-heart"></i>Add User Admin</a>
                        </div>

            </li>

            <li class="dropdown2">
                <a href="#"><i class="fa-solid fa-folder"></i> Category</a>
                    <div class="dropdown-content2">
                        <a href="category.php"><i class="fa-solid fa-receipt"></i>View Category</a>
                        <a href="add_category.php"><i class="fa-solid fa-heart"></i>Add Category</a>
                    </div>
            </li>

             <li class="dropdown2">
            <a href="xoasua.php"><i class="fa-solid fa-car"></i> Cars</a>
            <div class="dropdown-content2">
                <a href="xoasua.php"><i class="fa-solid fa-angles-right"></i>All Cars</a>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $c): ?>
                        <a href="xoasua.php?category_id=<?= $c['id'] ?>">
                            <i class="fa-solid fa-angles-right"></i>
                            <?= htmlspecialchars($c['name']) ?>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="#">No Categories</a>
                <?php endif; ?>
            </div>
        </li>



            <?php if (isset($_SESSION['customer'])): ?>
                <li class="dropdown2">
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        <?= htmlspecialchars($_SESSION['customer']) ?>
                    </a>
                    <div class="dropdown-content2">
                        <a href="my_orders_admin.php"><i class="fa-solid fa-box"></i> My Orders</a>
                        <a href="lost_password.php"><i class="fa-solid fa-pen"></i> Lost Password</a>
                        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="sign_up.php">Register</a></li>
            <?php endif; ?>


            <!-- CART -->
        
        </ul>

        </div>
    </div>
</div>


<?php
$stmtCate = $db->prepare("SELECT * FROM category ORDER BY id ASC");
$stmtCate->execute();
$listCate = $stmtCate->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container add-category-wrapper" style="padding: 40px 20px; max-width: 700px; margin: 40px auto;">


    <h1 class="text-center mb-4">Add User Admin</h1>

    <?= $msg ?>

    <div class="card shadow p-4">
        <form method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Type</label>
                <select name="type" class="form-select">
                    <option value="">Select type</option>
                    <option value="Admin">Admin</option>
                    <option value="Moderator">Moderator</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add User</button>
            <a href="admin.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
           
</div>

<footer class="merc-footer">
    <div class="container">

        <div class="footer-grid">

            <!-- Cột 1 -->
            <div class="footer-col">
                <h3>SHOWROOM NGOC TY</h3>
                <p>Xe sang – Bảo hành chính hãng</p>
                <p><i class="fa-solid fa-location-dot"></i>Vĩnh Long, Quốc Lộ 1A, Trường đại học Cữu Long</p>
                <p><i class="fa-solid fa-phone"></i> 0909 999 888</p>
                <p><i class="fa-solid fa-envelope"></i> NgocTy@mercedes.com</p>
            </div>

            <!-- Cột 2 -->
            <div class="footer-col">
                <h4>Liên kết nhanh</h4>
                <a href="index.php">Trang chủ</a>
                <a href="products.php">Sản phẩm</a>
                <a href="#">Giới thiệu</a>
                <a href="#">Liên hệ</a>
            </div>

            <!-- Cột 3 -->
            <div class="footer-col">
                <h4>Theo dõi chúng tôi ngay nào</h4>
                <div class="footer-social">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            © 2025 Showroom NGOC TY - All rights reserved.
        </div>
        
    </div>
</footer>


</body>
</html>