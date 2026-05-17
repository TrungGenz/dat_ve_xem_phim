<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

// 1. Nếu khách chưa đăng nhập thì đá về trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: dang_nhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // 2. Lấy thông tin chi tiết của khách
    $sql_user = "SELECT * FROM nguoi_dung WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->execute([$user_id]);
    $user = $stmt_user->fetch();

    // 3. Lấy lịch sử đặt vé (Join 3 bảng: hoa_don, ve, phim)
    $sql_ve = "SELECT h.ngay_dat, h.tong_tien, p.ten_phim, s.gio_chieu, s.ngay_chieu
               FROM hoa_don h
               JOIN ve v ON h.id = v.hoa_don_id
               JOIN suat_chieu s ON v.suat_chieu_id = s.id
               JOIN phim p ON s.phim_id = p.id
               WHERE h.ngay_dat_ve = ? 
               GROUP BY h.id 
               ORDER BY h.ngay_dat DESC";
    // Duy lưu ý: Kiểm tra lại tên cột ngày đặt trong bảng hoa_don của Duy là 'ngay_dat' hay 'ngay_dat_ve' nhé!
    
    $stmt_ve = $conn->prepare("SELECT h.*, p.ten_phim FROM hoa_don h 
                               JOIN ve v ON h.id = v.hoa_don_id 
                               JOIN suat_chieu s ON v.suat_chieu_id = s.id 
                               JOIN phim p ON s.phim_id = p.id 
                               WHERE h.nguoi_dung_id = ? GROUP BY h.id");
    $stmt_ve->execute([$user_id]);
    $lich_su = $stmt_ve->fetchAll();

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hồ sơ cá nhân - <?= $user['ho_ten'] ?></title>
    <style>
        .profile-box { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; border-radius: 10px; }
        .ticket-item { background: #f9f9f9; padding: 10px; margin-bottom: 10px; border-left: 5px solid red; }
    </style>
</head>
<body>
    <h1>Chào mừng, <?= $user['ho_ten'] ?>!</h1>
    
    <div class="profile-box">
        <h3>Thông tin tài khoản</h3>
        <p>Email: <?= $user['email'] ?></p>
        <p>Số điện thoại: <?= $user['so_dien_thoai'] ?></p>
    </div>

    <h2>Lịch sử đặt vé của bạn</h2>
    <?php if (count($lich_su) > 0): ?>
        <?php foreach($lich_su as $ve): ?>
            <div class="ticket-item">
                <strong>Phim: <?= $ve['ten_phim'] ?></strong> <br>
                Mã hóa đơn: #<?= $ve['id'] ?> | Tổng tiền: <?= number_format($ve['tong_tien']) ?>đ <br>
                Trạng thái: <?= $ve['trang_thai'] == 'da_thanh_toan' ? '✅ Đã thanh toán' : '❌ Chưa thanh toán' ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Bạn chưa mua vé nào. <a href="../index.php">Mua ngay!</a></p>
    <?php endif; ?>

    <br>
    <a href="../index.php">Quay lại Trang chủ</a> | <a href="../api/dang_xuat.php">Đăng xuất</a>
</body>
</html>