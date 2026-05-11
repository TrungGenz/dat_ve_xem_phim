<?php
session_start();
// Nếu chưa đăng nhập hoặc không phải là admin, đá về trang chủ
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once 'cau_hinh/ket_noi_db.php'; 

?>
<?php
session_start();
// Gọi file kết nối để lấy dữ liệu từ database
require_once 'cau_hinh/ket_noi_db.php'; 

// --- PHẦN 1: TRUY VẤN DỮ LIỆU THỐNG KÊ ---

// 1. Đếm số lượng phim[cite: 2]
$sql_phim = "SELECT COUNT(*) as total FROM phim";
$stmt_phim = $conn->query($sql_phim);
$tong_phim = $stmt_phim->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// 2. Đếm số lượng thành viên[cite: 2]
$sql_user = "SELECT COUNT(*) as total FROM nguoi_dung";
$stmt_user = $conn->query($sql_user);
$tong_user = $stmt_user->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// 3. Đếm số vé đã bán (Kiểm tra tên bảng 'dat_ve' trong DB của bạn)[cite: 2]
try {
    $sql_ve = "SELECT COUNT(*) as total FROM dat_ve";
    $stmt_ve = $conn->query($sql_ve);
    $tong_ve = $stmt_ve->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (Exception $e) {
    $tong_ve = 0; 
}

// 4. Tính tổng doanh thu từ bảng 'thanh_toan'[cite: 2]
try {
    $sql_revenue = "SELECT SUM(tong_tien) as total FROM thanh_toan"; 
    $stmt_revenue = $conn->query($sql_revenue);
    $doanh_thu_raw = $stmt_revenue->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (Exception $e) {
    $doanh_thu_raw = 0;
}

// Nhúng phần đầu trang (thanh điều hướng của admin)[cite: 2]
include 'thanh_phan/header.php'; 
?>

<div class="admin-container">
    <!-- Cấu trúc Menu khớp với các file trong thư mục quan_tri của bạn[cite: 2] -->
    <div class="sidebar">
        <h2>7AE ADMIN</h2>
        <a href="admin.php" class="nav-item active">📊 Tổng Quan</a>
        <a href="quan_tri/quan_ly_phim.php" class="nav-item">🎬 Quản Lý Phim</a>
        <a href="quan_tri/quan_ly_nguoi_dung.php" class="nav-item">👥 Người Dùng</a>
        <a href="quan_tri/quan_ly_lich_chieu.php" class="nav-item">📅 Lịch Chiếu</a>
        <a href="quan_tri/quan_ly_ve.php" class="nav-item">🎟️ Đơn Đặt Vé</a>
        <a href="index.php" class="nav-item" style="margin-top: 100px; color: #666;">← Về Trang Chủ</a>
    </div>

    <div class="main-content">
        <div class="header-info">
            <h1>Bảng Điều Khiển Hệ Thống</h1>
            <div>
                <!-- Hiển thị tên người dùng từ Session[cite: 2] -->
                Chào, <b><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></b> 
                <span style="color: #666; margin-left: 10px;">| <?= date('d/m/Y') ?></span>
            </div>
        </div>

        <!-- Các thẻ hiển thị con số thống kê thực tế[cite: 2] -->
        <div class="dashboard-cards">
            <div class="card">
                <p>PHIM ĐANG CHIẾU</p>
                <h3><?= number_format($tong_phim) ?></h3>
            </div>
            <div class="card">
                <p>THÀNH VIÊN</p>
                <h3><?= number_format($tong_user) ?></h3>
            </div>
            <div class="card">
                <p>VÉ ĐÃ BÁN</p>
                <h3><?= number_format($tong_ve) ?></h3>
            </div>
            <div class="card">
                <p>DOANH THU (VNĐ)</p>
                <h3><?= number_format($doanh_thu_raw, 0, ',', '.') ?>đ</h3>
            </div>
        </div>

        <div style="margin-top: 50px; background: #111; padding: 30px; border-radius: 15px; border: 1px solid #222;">
            <h2 style="color: var(--primary-red);">Thông tin hệ thống</h2>
            <ul style="color: #ccc; line-height: 1.8;">
                <li>Dữ liệu đang được đồng bộ trực tiếp từ Database <b><?= DB_NAME ?? 'cinema_star' ?></b>.</li>
                <li>Hệ thống ghi nhận <b><?= $tong_user ?></b> tài khoản đang hoạt động.</li>
                <li>Tổng doanh thu hiện tại: <b style="color: #00ff00;"><?= number_format($doanh_thu_raw, 0, ',', '.') ?> VNĐ</b>.</li>
            </ul>
        </div>
    </div>
</div>

<?php 
include 'thanh_phan/footer.php'; 
?>