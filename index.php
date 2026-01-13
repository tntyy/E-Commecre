<?php require 'template/header.php'; ?>
<?php require 'template/nav.php'; ?>
<?php require 'conn/connect.php'; ?>

<?php
$db = Database::getInstance();

// Lấy tổng số sản phẩm xe hơi
$stmtTotal = $db->query("SELECT COUNT(*) AS t FROM products WHERE status=1");
$total = $stmtTotal->fetch(PDO::FETCH_ASSOC);

// Lấy danh sách xe hơi
$sql = "
    SELECT p.*, c.name AS cat_name 
    FROM products p 
    JOIN category c ON p.catid = c.id 
    WHERE p.status = 1
    ORDER BY p.date_added DESC
";
$stmt = $db->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
        /* HERO */
        .hero{
            height:520px;
            background:url('images/audi-a8l.jpg') center/cover no-repeat;
            position:relative;
        }
        .hero-overlay{
            background:rgba(0,0,0,0.45);
            height:100%;
            display:flex;
            align-items:center;
        }
        .hero-content{
            max-width:1200px;
            margin:auto;
            color:white;
        }
        .hero-content h1{
            font-size:64px;
            font-weight:800;
            line-height:1.1;
        }
        .hero-content h1 span{
            font-weight:300;
        }
        .hero-content p{
            font-size:20px;
            margin:20px 0 30px;
        }
        .hero-btn{
            background:#c0392b;
            color:white;
            padding:14px 36px;
            font-size:16px;
            border-radius:50px;
            text-decoration:none;
            font-weight:600;
        }

        /* GRID XE */
        .car-section{
            padding:60px 20px;
            max-width:1300px;
            margin:auto;
        }
        .car-title{
            text-align:center;
            font-size:40px;
            margin-bottom:10px;
            color:#2b5876;
        }
        .car-sub{
            text-align:center;
            font-size:18px;
            margin-bottom:50px;
            color:#666;
        }
        .car-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
            gap:30px;
        }
        .car-card{
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.12);
            transition:.3s;
        }
        .car-card:hover{
            transform:translateY(-10px);
        }
        .car-card img{
            width:100%;
            height:220px;
            object-fit:cover;
        }
        .car-body{
            padding:20px;
            text-align:center;
        }
        .car-cat{
            background:#2b5876;
            color:white;
            padding:5px 14px;
            border-radius:20px;
            font-size:12px;
        }
        .car-body h3{
            margin:15px 0;
            font-size:20px;
            height:52px;
            overflow:hidden;
        }
        .car-price{
            color:#c0392b;
            font-size:26px;
            font-weight:bold;
            margin:15px 0;
        }
        .car-btn{
            display:inline-block;
            background:#2b5876;
            color:white;
            padding:12px 28px;
            border-radius:50px;
            text-decoration:none;
            font-weight:600;
        }
        /* BRAND SECTION */
        .brand-section{
            background:#f8f9fa;
            padding:70px 20px;
        }
        .brand-title{
            text-align:center;
            font-size:38px;
            color:#2b5876;
            margin-bottom:15px;
        }
        .brand-sub{
            text-align:center;
            font-size:18px;
            color:#666;
            margin-bottom:50px;
        }
        .brand-grid{
            max-width:1200px;
            margin:auto;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:30px;
        }
        .brand-card{
            background:white;
            border-radius:16px;
            padding:30px;
            text-align:center;
            box-shadow:0 8px 25px rgba(0,0,0,.08);
            transition:.3s;
        }
        .brand-card:hover{
            transform:translateY(-8px);
        }
        .brand-card img{
            height:70px;
            margin-bottom:20px;
        }
        .brand-card h3{
            font-size:24px;
            margin-bottom:15px;
            color:#333;
        }
        .brand-card p{
            color:#666;
            font-size:15px;
            line-height:1.6;
        }
        .brand-btn{
            display:inline-block;
            margin-top:20px;
            padding:10px 26px;
            border-radius:50px;
            background:#2b5876;
            color:white;
            text-decoration:none;
            font-weight:600;
            font-size:14px;
        }

        /* BRAND DETAIL SECTION */
    .brand-detail{
        padding:80px 20px;
    }
    .brand-detail:nth-child(even){
        background:#f8f9fa;
    }
    .brand-wrap{
        max-width:1200px;
        margin:auto;
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:50px;
        align-items:center;
    }
    .brand-wrap.reverse{
        direction:rtl;
    }
    .brand-wrap.reverse *{
        direction:ltr;
    }

    .brand-img img{
        width:100%;
        border-radius:18px;
        box-shadow:0 15px 40px rgba(0,0,0,.15);
    }

    .brand-content h2{
        font-size:42px;
        color:#2b5876;
        margin-bottom:20px;
    }
    .brand-content p{
        font-size:17px;
        line-height:1.7;
        color:#555;
    }
    .brand-list{
        margin:25px 0;
    }
    .brand-list li{
        margin-bottom:10px;
        font-size:16px;
    }
    .brand-detail-btn{
        display:inline-block;
        margin-top:20px;
        padding:14px 38px;
        border-radius:50px;
        background:#c0392b;
        color:white;
        text-decoration:none;
        font-weight:600;
    }


</style>

<div class="container">
    <section class="hero">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>DOMINATE<br><span>THE INTERNET</span></h1>
            <p>Attract, Engage & Convert more<br><strong>qualified vehicle shoppers</strong></p>
            <a href="#cars" class="hero-btn">Xem xe ngay</a>
        </div>
    </div>
</section>
</div>

<section class="brand-section">
    <h2 class="brand-title">Các Hãng Xe Nổi Bật</h2>
    <p class="brand-sub">
        Chúng tôi cung cấp những thương hiệu ô tô hàng đầu thế giới
    </p>

    <div class="brand-grid">

        <!-- MERCEDES -->
        <div class="brand-card">
            <img src="images/maybach-s680.jpg" alt="Mercedes">
            <h3>Mercedes-Benz</h3>
            <p>
                Mercedes-Benz là biểu tượng của sự sang trọng, đẳng cấp và công nghệ tiên tiến.
                Các mẫu xe mang thiết kế tinh tế, nội thất cao cấp và khả năng vận hành êm ái.
            </p>
            <a href="cate.php?brand=mercedes-benz" class="brand-btn">Xem xe Mercedes</a>
        </div>

        <!-- BMW -->
        <div class="brand-card">
            <img src="images/bmw-740li.jpg" alt="BMW">
            <h3>BMW</h3>
            <p>
                BMW nổi tiếng với cảm giác lái thể thao, động cơ mạnh mẽ và công nghệ hiện đại.
                Phù hợp cho những ai yêu thích sự năng động và hiệu suất cao.
            </p>
            <a href="cate.php?brand=bmw" class="brand-btn">Xem xe BMW</a>
        </div>

        <!-- AUDI -->
        <div class="brand-card">
            <img src="images/audi-a8l.jpg" alt="Audi">
            <h3>Audi</h3>
            <p>
                Audi mang phong cách hiện đại, trẻ trung cùng công nghệ Quattro trứ danh.
                Nội thất tinh xảo, trải nghiệm lái thông minh và an toàn.
            </p>
            <a href="cate.php?brand=audi" class="brand-btn">Xem xe Audi</a>
        </div>

    </div>
</section>

<section class="brand-detail">
    <div class="brand-wrap">
        <div class="brand-img">
            <img src="images/mer-glc300.jpg" alt="Mercedes">
        </div>
        <div class="brand-content">
            <h2>Mercedes-Benz</h2>
            <p>
                Mercedes-Benz là thương hiệu xe sang hàng đầu thế giới đến từ Đức,
                đại diện cho sự sang trọng, đẳng cấp và công nghệ tiên phong.
            </p>
            <ul class="brand-list">
                <li>✔ Thiết kế sang trọng, tinh tế</li>
                <li>✔ Nội thất cao cấp, tiện nghi</li>
                <li>✔ Công nghệ an toàn hàng đầu</li>
            </ul>
            <a href="cate.php?brand=mercedes" class="brand-detail-btn">
                Xem xe Mercedes
            </a>
        </div>
    </div>
</section>


<section class="brand-detail">
    <div class="brand-wrap reverse">
        <div class="brand-img">
            <img src="images/bmw-x5.jpg" alt="BMW">
        </div>
        <div class="brand-content">
            <h2>BMW</h2>
            <p>
                BMW nổi tiếng với triết lý “The Ultimate Driving Machine” –
                mang đến cảm giác lái thể thao, mạnh mẽ và đầy cảm xúc.
            </p>
            <ul class="brand-list">
                <li>✔ Động cơ mạnh mẽ</li>
                <li>✔ Cảm giác lái thể thao</li>
                <li>✔ Công nghệ hiện đại</li>
            </ul>
            <a href="cate.php?brand=bmw" class="brand-detail-btn">
                Xem xe BMW
            </a>
        </div>
    </div>
</section>

<section class="brand-detail">
    <div class="brand-wrap">
        <div class="brand-img">
            <img src="images/audi-q7.jpg" alt="Audi">
        </div>
        <div class="brand-content">
            <h2>Audi</h2>
            <p>
                Audi là sự kết hợp hoàn hảo giữa thiết kế hiện đại, công nghệ
                tiên tiến và hệ dẫn động Quattro trứ danh.
            </p>
            <ul class="brand-list">
                <li>✔ Thiết kế trẻ trung, hiện đại</li>
                <li>✔ Công nghệ Quattro danh tiếng</li>
                <li>✔ Nội thất tinh xảo</li>
            </ul>
            <a href="cate.php?brand=audi" class="brand-detail-btn">
                Xem xe Audi
            </a>
        </div>
    </div>
</section>



<div class="container" style="padding: 40px 20px; max-width: 1300px; margin: 0 auto;">

    <div id="cars" class="car-section">
    <h2 class="car-title">SHOWROOM Ô TÔ CAO CẤP</h2>
    <p class="car-sub">
        Hiện có <strong><?= $total['t'] ?></strong> mẫu xe đang được bán
    </p>

    <div class="car-grid">
        <?php foreach ($products as $row): ?>
        <div class="car-card">
            <a href="detail.php?id=<?= $row['id'] ?>">
                <img src="images/<?= $row['image'] ?>" alt="">
            </a>
            <div class="car-body">
                <span class="car-cat"><?= htmlspecialchars($row['cat_name']) ?></span>

                <h3>
                    <a href="detail.php?id=<?= $row['id'] ?>" style="text-decoration:none;color:#333;">
                        <?= htmlspecialchars($row['title']) ?>
                    </a>
                </h3>

                <div class="car-price">
                    <?= number_format($row['price'], 0, ',', '.') ?> ₫
                </div>

                <a class="car-btn" href="addtocart.php?id=<?= $row['id'] ?>">
                    Đặt mua ngay
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


    <?php if (count($products) == 0): ?>
        <p style="text-align:center; font-size:22px; color:#999; padding:80px;">
            Chưa có mẫu xe nào được đăng!
        </p>
    <?php endif; ?>
</div>

<?php require 'template/footer.php'; ?>
