<?php
include '../thanh_phan/header.php';
$suat_id = $_POST['suat_id'] ?? 0;
$ghe_ids = $_POST['ghe_ids'] ?? [];
?>
<h2>XÁC NHẬN THANH TOÁN</h2>
<p>Bạn đã chọn <?= count($ghe_ids) ?> ghế.</p>
<form action="../api/xu_ly_thanh_toan.php" method="POST">
    <input type="hidden" name="suat_id" value="<?= $suat_id ?>">
    <p>Phương thức: 
        <select name="phuong_thuc">
            <option>Momo</option>
            <option>Thẻ ngân hàng</option>
        </select>
    </p>
    <button type="submit">THANH TOÁN NGAY</button>
</form>