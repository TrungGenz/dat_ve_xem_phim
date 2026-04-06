<?php
require_once '../cau_hinh/ket_noi_db.php';
$phim_id = $_GET['phim_id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM suat_chieu WHERE phim_id = ?");
$stmt->execute([$phim_id]);
$ds_suat = $stmt->fetchAll();
include '../thanh_phan/header.php';
?>
<h2>CHỌN GIỜ CHIẾU</h2>
<?php foreach($ds_suat as $s): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <p>Ngày: <?= $s['ngay_chieu'] ?> | Giờ: <?= $s['gio_chieu'] ?></p>
        <a href="ghe.php?suat_id=<?= $s['id'] ?>">CHỌN GHẾ</a>
    </div>
<?php endforeach; ?>