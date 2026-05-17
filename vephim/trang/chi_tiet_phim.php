<?php
session_start();
// Kết nối database (chú ý đường dẫn vì file này đang nằm trong thư mục 'trang')
require_once '../cau_hinh/ket_noi_db.php'; 

// Kiểm tra xem có nhận được ID phim từ URL không
if (!isset($_GET['id_phim'])) {
    header("Location: ../index.php");
    exit();
}

$id_phim = $_GET['id_phim'];

// 1. Lấy thông tin chi tiết của bộ phim
$query_phim = "SELECT * FROM phim WHERE id = $id_phim";
$result_phim = mysqli_query($conn, $query_phim);
$phim = mysqli_fetch_assoc($result_phim);

// Nếu phim không tồn tại thì báo lỗi và quay về trang chủ
if (!$phim) {
    echo "<script>alert('Phim này không tồn tại!'); window.location.href='../index.php';</script>";
    exit();
}

// Xử lý đường dẫn ảnh chuẩn xác
$path_hinh = "";
if (strpos($phim['hinh_anh'], 'http') === 0) {
    $path_hinh = $phim['hinh_anh'];
} else {
    $path_hinh = !empty($phim['hinh_anh']) ? "../admin_ve_phim/uploads/" . $phim['hinh_anh'] : "../tai_nguyen/img/default.jpg";
}

// 2. Lấy danh sách suất chiếu của phim này (Chỉ lấy các suất chiếu từ ngày hôm nay trở đi)
$query_suat = "SELECT suat_chieu.*, phong.ten_phong 
               FROM suat_chieu 
               JOIN phong ON suat_chieu.phong_id = phong.id 
               WHERE phim_id = $id_phim AND ngay_chieu >= CURDATE()
               ORDER BY ngay_chieu ASC, gio_chieu ASC";
$result_suat = mysqli_query($conn, $query_suat);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($phim['ten_phim']) ?> - 5AESIUNHAN</title>
    <link rel="stylesheet" href="../tai_nguyen/css/style.css">
    <style>
        body { background-color: #121212; padding-top: 80px; }
        .movie-detail-container {
            display: flex; gap: 40px; padding: 50px 10%; max-width: 1200px; margin: auto;
        }
        .movie-poster img {
            width: 300px; border-radius: 10px; box-shadow: 0 5px 15px rgba(229, 9, 20, 0.3);
        }
        .movie-info h1 { color: #fff; font-size: 36px; margin-bottom: 15px; }
        .movie-info p { color: #bbb; line-height: 1.6; margin-bottom: 15px; font-size: 16px; }
        .movie-info .highlight { color: #e50914; font-weight: bold; }
        
        .showtimes-box { margin-top: 30px; background: #1e1e1e; padding: 25px; border-radius: 10px; }
        .showtimes-box h3 { color: #fff; border-bottom: 2px solid #e50914; padding-bottom: 10px; margin-bottom: 20px; }
        
        .date-group { margin-bottom: 25px; }
        .date-title { color: #ffcc00; font-weight: bold; margin-bottom: 10px; font-size: 18px; }
        .time-btn {
            display: inline-block; padding: 10px 20px; background-color: #333; color: white;
            text-decoration: none; border-radius: 5px; margin-right: 10px; margin-bottom: 10px;
            transition: 0.3s; border: 1px solid #444;
        }
        .time-btn:hover { background-color: #e50914; border-color: #e50914; transform: translateY(-2px); }
        .time-btn span { display: block; font-size: 12px; color: #aaa; margin-top: 3px; }
        .time-btn:hover span { color: #fff; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar" style="background: #000;">
            <div class="logo">5AE<span>SIUNHAN</span></div>
            <ul class="nav-links">
                <li><a href="../index.php">← Quay lại Trang Chủ</a></li>
            </ul>
        </nav>
    </header>

    <div class="movie-detail-container">
        <div class="movie-poster">
            <img src="<?= $path_hinh ?>" alt="<?= htmlspecialchars($phim['ten_phim']) ?>">
        </div>

        <div class="movie-info">
            <h1><?= htmlspecialchars($phim['ten_phim']) ?></h1>
            <p><span class="highlight">Thể loại:</span> <?= htmlspecialchars($phim['the_loai'] ?? 'Đang cập nhật') ?></p>
            <p><span class="highlight">Thời lượng:</span> <?= htmlspecialchars($phim['thoi_luong']) ?> phút</p>
            <p><span class="highlight">Mô tả:</span> <br><?= nl2br(htmlspecialchars($phim['mo_ta'])) ?></p>

            <div class="showtimes-box">
                <h3>Lịch Chiếu & Đặt Vé</h3>
                
                <?php if (mysqli_num_rows($result_suat) > 0): ?>
                    <?php 
                        $current_date = '';
                        while ($suat = mysqli_fetch_assoc($result_suat)): 
                            $ngay = date('d/m/Y', strtotime($suat['ngay_chieu']));
                            
                            // Phân nhóm suất chiếu theo từng ngày
                            if ($ngay != $current_date): 
                                if ($current_date != '') echo "</div>"; // Đóng nhóm cũ
                                $current_date = $ngay;
                    ?>
                                <div class="date-group">
                                    <div class="date-title">Ngày: <?= $ngay ?></div>
                    <?php endif; ?>
                    
                            <a href="chon_ghe.php?id_suat=<?= $suat['id'] ?>" class="time-btn">
                                <b><?= date('H:i', strtotime($suat['gio_chieu'])) ?></b>
                                <span><?= htmlspecialchars($suat['ten_phong']) ?></span>
                            </a>
                            
                    <?php endwhile; echo "</div>"; // Đóng nhóm cuối cùng ?>
                <?php else: ?>
                    <p style="color: #ff4444;">Hiện tại bộ phim này chưa có lịch chiếu nào. Vui lòng quay lại sau!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>