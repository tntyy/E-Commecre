<?php require 'template/header.php'; ?>
<?php require 'template/nav.php'; ?>
<?php require 'conn/connect.php'; ?>

<?php
$db = Database::getInstance();

/* ===== LẤY BRAND TỪ URL ===== */
$brand = $_GET['brand'] ?? '';
$brand = trim($brand);

if ($brand == '') {
    echo "<p style='padding:50px;text-align:center'>Hãng xe không hợp lệ</p>";
    require 'template/footer.php';
    exit;
}

/* ===== ĐẾM SỐ XE THEO HÃNG ===== */
$sqlTotal = "
    SELECT COUNT(*) AS t
    FROM products p
    JOIN category c ON p.catid = c.id
    WHERE p.status = 1
      AND LOWER(c.name) LIKE :brand
";
$stmtTotal = $db->prepare($sqlTotal);
$stmtTotal->execute([
    ':brand' => '%' . strtolower($brand) . '%'
]);
$total = $stmtTotal->fetch(PDO::FETCH_ASSOC);

/* ===== LẤY DANH SÁCH XE ===== */
$sql = "
    SELECT p.*, c.name AS cat_name
    FROM products p
    JOIN category c ON p.catid = c.id
    WHERE p.status = 1
      AND LOWER(c.name) LIKE :brand
    ORDER BY p.date_added DESC
";
$stmt = $db->prepare($sql);
$stmt->execute([
    ':brand' => '%' . strtolower($brand) . '%'
]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container" style="padding:40px 20px; max-width:1300px; margin:auto;">

    <h1 style="text-align:center; font-size:42px; color:#2b5876; margin:30px 0;">
        HÃNG XE <?= strtoupper(htmlspecialchars($brand)) ?>
    </h1>

    <p style="text-align:center; font-size:20px; color:#555; margin-bottom:40px;">
        Có <strong><?= $total['t'] ?></strong> mẫu xe thuộc hãng <?= htmlspecialchars($brand) ?>
    </p>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
        gap:32px;
    ">

        <?php foreach ($products as $row): ?>
        <div style="
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 8px 30px rgba(0,0,0,0.12);
            transition:.3s;
        "
        onmouseover="this.style.transform='translateY(-8px)'"
        onmouseout="this.style.transform='translateY(0)'">

            <a href="detail.php?id=<?= $row['id'] ?>">
                <img src="images/<?= $row['image'] ?>"
                     alt="<?= htmlspecialchars($row['title']) ?>"
                     style="width:100%; height:230px; object-fit:cover;">
            </a>

            <div style="padding:20px; text-align:center;">
                <span style="
                    background:#2b5876;
                    color:white;
                    padding:6px 14px;
                    border-radius:20px;
                    font-size:12px;
                ">
                    <?= htmlspecialchars($row['cat_name']) ?>
                </span>

                <h3 style="margin:15px 0; font-size:20px; height:50px; overflow:hidden;">
                    <a href="detail.php?id=<?= $row['id'] ?>" style="color:#333; text-decoration:none;">
                        <?= htmlspecialchars($row['title']) ?>
                    </a>
                </h3>

                <p style="color:#c0392b; font-size:26px; font-weight:bold; margin:15px 0;">
                    <?= number_format($row['price'], 0, ',', '.') ?> ₫
                </p>

                <a href="addtocart.php?id=<?= $row['id'] ?>"
                   style="
                        background:#2b5876;
                        color:white;
                        padding:12px 30px;
                        border-radius:50px;
                        text-decoration:none;
                        font-weight:600;
                        display:inline-block;
                   ">
                    Đặt mua ngay
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (count($products) == 0): ?>
        <p style="text-align:center; font-size:22px; color:#999; padding:80px;">
            Chưa có xe nào thuộc hãng này!
        </p>
    <?php endif; ?>

</div>

<?php require 'template/footer.php'; ?>
