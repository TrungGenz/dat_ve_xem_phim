<link rel="stylesheet" href="../tai_nguyen/css/phim_style.css">
<?php 
// 1. Luôn để session_start() ở dòng đầu tiên
session_start();

// 2. Nhúng kết nối và Header
require_once '../cau_hinh/ket_noi_db.php';
include '../thanh_phan/header.php'; 

// 3. Lấy ID phim và kiểm tra dữ liệu
$id_phim = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM phim WHERE id = ?");
$stmt->execute([$id_phim]);
$phim = $stmt->fetch();

if (!$phim) {
    echo "<div style='color:white; text-align:center; padding:100px;'><h2>Không tìm thấy phim này!</h2><a href='../index.php' style='color:red;'>Quay lại trang chủ</a></div>";
    include '../thanh_phan/footer.php';
    exit;
}
?>

<link rel="stylesheet" href="../tai_nguyen/css/phim_style.css">

<div class="detail-container">
    <div class="movie-left">
        <img src="../tai_nguyen/img/<?= !empty($phim['hinh_anh']) ? $phim['hinh_anh'] : 'default.jpg' ?>" alt="<?= htmlspecialchars($phim['ten_phim']) ?>">
    </div>

    <div class="movie-right">
        <h1><?= htmlspecialchars($phim['ten_phim']) ?></h1>
        <p><b>Thời lượng:</b> <?= $phim['thoi_luong'] ?> phút</p>
        <p><b>Mô tả:</b> <?= nl2br(htmlspecialchars($phim['mo_ta'] ?? 'Đang cập nhật...')) ?></p>
        
        <hr style="border: 0.5px solid #333; margin: 30px 0;">

        <h3>CHỌN SUẤT CHIẾU</h3>
        <div class="showtime-list">
            <?php
            // Lấy suất chiếu từ Database
            $sql_suat = "SELECT * FROM suat_chieu WHERE id_phim = ? AND ngay_chieu >= CURDATE() ORDER BY ngay_chieu ASC, gio_bat_dau ASC";
            $stmt_suat = $conn->prepare($sql_suat);
            $stmt_suat->execute([$id_phim]);
            $suat_chieus = $stmt_suat->fetchAll();

            if ($suat_chieus):
                foreach ($suat_chieus as $sc): 
            ?>
                <a href="chon_ghe.php?id_suat=<?= $sc['id'] ?>" class="btn-time">
                    <span><?= date('d/m/Y', strtotime($sc['ngay_chieu'])) ?></span>
                    <b><?= date('H:i', strtotime($sc['gio_bat_dau'])) ?></b>
                </a>
            <?php 
                endforeach; 
            else:
                echo "<p style='color: #888;'>Phim hiện tại chưa có suất chiếu phù hợp.</p>";
            endif;
            ?>
        </div>
    </div>
</div>

<?php include '../thanh_phan/footer.php'; ?>
