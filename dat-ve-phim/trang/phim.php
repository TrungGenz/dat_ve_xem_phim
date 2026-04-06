<?php 
require_once '../cau_hinh/ket_noi_db.php';
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM phim WHERE id = ?");
$stmt->execute([$id]);
$phim = $stmt->fetch();
include '../thanh_phan/header.php';
?>
<div style="display: flex; gap: 30px; padding: 20px;">
    <img src="../tai_nguyen/img/<?= $phim['hinh_anh'] ?>" width="300">
    <div>
        <h1><?= $phim['ten_phim'] ?></h1>
        <p><b>Thời lượng:</b> <?= $phim['thoi_luong'] ?> phút</p>
        <p><b>Mô tả:</b> <?= $phim['mo_ta'] ?></p>
        <a href="suat_chieu.php?phim_id=<?= $id ?>" style="background:red; color:white; padding:15px; text-decoration:none;">CHỌN SUẤT CHIẾU</a>
    </div>
</div>