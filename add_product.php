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

// Lấy tất cả category để dropdown
$stmt = $db->query("SELECT id, name FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy category_id từ GET nếu có (từ xoasua.php)
$selected_category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $catid = $_POST['catid'];
    $status = isset($_POST['status']) ? 1 : 0;

    // Xử lý ảnh upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
    }

    // Thêm sản phẩm vào DB
    $stmtAdd = $db->prepare("INSERT INTO products (title, price, catid, image, status, date_added) 
                             VALUES (?, ?, ?, ?, ?, NOW())");
    $stmtAdd->execute([$title, $price, $catid, $image, $status]);

    // Redirect về xoasua.php với category_id để xem ngay
    header("Location: xoasua.php?category_id=" . $catid);
    exit;
}
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

/* ===== ADMIN TABLE ===== */
.admin-table {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.admin-table thead {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
}

.admin-table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.5px;
    padding: 14px;
}

.admin-table tbody td {
    padding: 14px;
    font-size: 14px;
    color: #333;
    vertical-align: middle;
}

.admin-table tbody tr {
    transition: all 0.25s ease;
}

.admin-table tbody tr:hover {
    background: #f4f8ff;
    transform: scale(1.005);
}

/* Password hidden */
.admin-pass {
    font-family: monospace;
    letter-spacing: 2px;
}

/* Action buttons */
.admin-actions a {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.admin-actions .btn-primary {
    background: #2a5298;
    border: none;
}

.admin-actions .btn-danger {
    background: #c0392b;
    border: none;
}

/* Add button */
.add-admin-btn {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    border: none;
    padding: 10px 22px;
    border-radius: 25px;
    font-weight: 600;
    color: #fff;
}
.add-admin-btn:hover {
    opacity: 0.9;
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
                <a href="category.php"><i class="fa-solid fa-folder"></i> Category</a>
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
                        <a href="my_wishlist.php"><i class="fa-solid fa-heart"></i> Wishlist</a>
                        <a href="edit_profile.php"><i class="fa-solid fa-pen"></i> Edit Profile</a>
                        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="sign_up.php">Register</a></li>
            <?php endif; ?>


        </ul>

        </div>
    </div>
</div>




<div class="container mt-5">
    <h2>Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="catid" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($c['id'] == $selected_category) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="status" class="form-check-input" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
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