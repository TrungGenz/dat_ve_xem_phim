<?php
require_once '../cau_hinh/ket_noi_db.php';
$suat_id = $_GET['suat_id'] ?? 0;
// Lấy danh sách ghế
$stmt = $conn->query("SELECT * FROM ghe");
$ds_ghe = $stmt->fetchAll();
include '../thanh_phan/header.php';
?>
<h2>SƠ ĐỒ CHỖ NGỒI</h2>
<form action="thanh_toan.php" method="POST">
    <input type="hidden" name="suat_id" value="<?= $suat_id ?>">
    <div style="display: grid; grid-template-columns: repeat(10, 40px); gap: 10px;">
        <?php foreach($ds_ghe as $g): ?>
            <label>
                <input type="checkbox" name="ghe_ids[]" value="<?= $g['id'] ?>">
                <?= $g['ten_ghe'] ?>
            </label>
        <?php endforeach; ?>
    </div>
    <br><button type="submit">TIẾP TỤC THANH TOÁN</button>
</form>