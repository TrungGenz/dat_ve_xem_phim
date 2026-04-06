<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';
include '../thanh_phan/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy danh sách hóa đơn và tên phim tương ứng
$sql = "SELECT h.*, p.ten_phim, s.ngay_chieu, s.gio_chieu 
        FROM hoa_don h 
        JOIN ve v ON h.id = v.hoa_don_id 
        JOIN suat_chieu s ON v.suat_chieu_id = s.id 
        JOIN phim p ON s.phim_id = p.id 
        WHERE h.nguoi_dung_id = ? 
        GROUP BY h.id 
        ORDER BY h.ngay_dat DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$lich_su = $stmt->fetchAll();
?>

<div style="padding: 20px;">
    <h2>VÉ PHIM ĐÃ ĐẶT</h2>
    <?php if (count($lich_su) > 0): ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <tr style="background: #eee;">
                <th>Mã đơn</th>
                <th>Tên Phim</th>
                <th>Suất chiếu</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
            <?php foreach($lich_su as $item): ?>
            <tr>
                <td align="center">#<?= $item['id'] ?></td>
                <td><?= $item['ten_phim'] ?></td>
                <td><?= $item['gio_chieu'] ?> ngày <?= $item['ngay_chieu'] ?></td>
                <td><?= number_format($item['tong_tien']) ?>đ</td>
                <td align="center">
                    <?= $item['trang_thai'] == 'da_thanh_toan' ? '✅ Thành công' : '⏳ Chờ thanh toán' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Bạn chưa có giao dịch nào. <a href="../index.php">Đặt vé ngay!</a></p>
    <?php endif; ?>
</div>