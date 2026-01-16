<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'conn/connect.php';
$db = Database::getInstance();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);

    if ($category_name === '') {
        $msg = '<div class="alert alert-danger">Tên danh mục là bắt buộc</div>';
    } else {
        // Kiểm tra category đã tồn tại chưa
        $stmt = $db->prepare("SELECT id FROM category WHERE name = ?");
        $stmt->execute([$category_name]);
        if ($stmt->rowCount() > 0) {
            $msg = '<div class="alert alert-danger">Danh mục đã tồn tại</div>';
        } else {
            // Thêm category mới
            $stmt = $db->prepare("INSERT INTO category(name, status) VALUES(?, NOW())");
            $stmt->execute([$category_name]);
            $msg = '<div class="alert alert-success">Danh mục đã được thêm thành công</div>';
        }
    }
}
$sql = "SELECT id, name FROM category";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

            <li><a href="admin.php"><i class="fa-solid fa-house">ADMIN</i></a></li>

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






<div class="container add-category-wrapper" style="padding: 40px 20px; max-width: 700px; margin: 40px auto;">

    <h1 style="text-align:center; font-size:42px; color:#2b5876; margin:30px 0;">
         ADD CATEGORY
    </h1>
    <div class="row justify-content-center mt-4">
    <div class="col-md-6">

        <?= $msg ?>

        <div class="card shadow">
            <div class="card-body">

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category Name</label>
                        <input type="text" 
                               name="category_name" 
                               class="form-control"
                               placeholder="Enter category name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>

                    <a href="category.php" class="btn btn-secondary">
                        Back
                    </a>
                </form>

            </div>
        </div>

    </div>
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