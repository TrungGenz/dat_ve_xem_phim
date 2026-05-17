<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';
include '../thanh_phan/header.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

$suat_id = $_POST['suat_id'] ?? 0;
$ghe_ids = $_POST['ghe_ids'] ?? [];

// Lấy thông tin chi tiết suất chiếu và phim để hiển thị cho khách xem lại
$stmt = $conn->prepare("SELECT s.*, p.ten_phim, p.hinh_anh FROM suat_chieu s JOIN phim p ON s.phim_id = p.id WHERE s.id = ?");
$stmt->execute([$suat_id]);
$info = $stmt->fetch();

$tong_tien = count($ghe_ids) * ($info['gia_ve'] ?? 0);
?>

<div style="max-width: 600px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
    <h2>XÁC NHẬN THÔNG TIN ĐẶT VÉ</h2>
    <img src="../tai_nguyen/img/<?= $info['hinh_anh'] ?>" width="100">
    <p><b>Phim:</b> <?= $info['ten_phim'] ?></p>
    <p><b>Suất chiếu:</b> <?= $info['gio_chieu'] ?> | <?= $info['ngay_chieu'] ?></p>
    <p><b>Số lượng ghế:</b> <?= count($ghe_ids) ?></p>
    <hr>
    <h3>Tổng tiền: <span style="color:red"><?= number_format($tong_tien) ?>đ</span></h3>

    <form action="../api/xu_ly_dat_ve.php" method="POST">
        <input type="hidden" name="suat_chieu_id" value="<?= $suat_id ?>">
        <?php foreach($ghe_ids as $id): ?>
            <input type="hidden" name="ghe_ids[]" value="<?= $id ?>">
        <?php endforeach; ?>
        <input type="hidden" name="tong_tien" value="<?= $tong_tien ?>">
        
        <button type="submit" style="background: green; color: white; padding: 15px; width: 100%; border: none; cursor: pointer;">
            XÁC NHẬN ĐẶT VÉ & THANH TOÁN
        </button>
    </form>
</div>