<?php 
session_start();
require_once __DIR__ . '/conn/connect.php';   // PDO
$db = Database::getInstance();

include 'template/header.php';
include 'template/nav.php';

// Lấy sản phẩm theo ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$r) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<div class="container" style="margin-top: 40px;">
    <div class="row">

        <!-- Cột ảnh -->
        <div class="col-md-6">
            <div class="thumbnail" style="border:none;">
                <img src="images/<?= htmlspecialchars($r['image']) ?>" 
                     alt="<?= htmlspecialchars($r['title']) ?>" 
                     style="width:100%; height:420px; object-fit:cover; border-radius:12px;">
            </div>
        </div>

        <!-- Cột thông tin -->
        <div class="col-md-6">
            <h1 style="font-size:32px; font-weight:700; color:#2c3e50;">
                <?= htmlspecialchars($r['title']) ?>
            </h1>

            <p style="font-size:28px; font-weight:bold; color:#c0392b;">
                <?= number_format($r['price'], 0, ',', '.') ?> VND
            </p>

            <p style="font-size:18px; color:#555; line-height:1.6;">
                <?= nl2br(htmlspecialchars($r['description'])) ?>
            </p>

            <form method="GET" action="addtocart.php" style="margin-top:20px;">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">

                <label style="font-size:16px; font-weight:600;">Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1"
                       style="width:90px; padding:5px; text-align:center;
                              margin-left:10px; border-radius:6px;">

                <br><br>

                <input type="submit" value="Add to Cart"
                       class="btn btn-primary"
                       style="padding:12px 28px; font-size:18px; border-radius:8px;">
            </form>
        </div>

    </div>
</div>

<!-- Sản phẩm liên quan -->
<div class="container">
    <h4 class="heading">Related Products</h4>
    <div class="row">

        <?php 
        $stmtRel = $db->prepare("SELECT * FROM products WHERE catid = ? AND id != ? LIMIT 4");
        $stmtRel->execute([$r['catid'], $r['id']]);
        $related = $stmtRel->fetchAll(PDO::FETCH_ASSOC);

        foreach ($related as $item): ?>
            <div class="thumbnail" style="width:240px; margin:10px;">
                <a href="detail.php?id=<?= $item['id'] ?>">
                    <img src="images/<?= htmlspecialchars($item['image']) ?>" 
                         alt="<?= htmlspecialchars($item['title']) ?>" 
                         style="width:100%; height:150px; object-fit:cover;">
                </a>

                <div class="caption">
                    <h4><?= htmlspecialchars($item['title']) ?></h4>
                    <p><?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                    <p>
                        <a href="addtocart.php?id=<?= $item['id'] ?>" class="btn btn-primary">
                            Add to Cart
                        </a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php include 'template/footer.php'; ?>
