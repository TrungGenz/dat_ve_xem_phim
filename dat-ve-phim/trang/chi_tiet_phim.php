<?php
require_once '../cau_hinh/ket_noi_db.php';

// 1. Lấy ID phim từ link (ví dụ: chi_tiet_phim.php?id_phim=1)
$id_phim = $_GET['id_phim'] ?? 0;

// 2. Lấy thông tin phim từ Database để hiện Mô tả, Tên phim
$stmt = $conn->prepare("SELECT * FROM phim WHERE id = ?");
$stmt->execute([$id_phim]);
$phim = $stmt->fetch();

if (!$phim) {
    die("Duy ơi, chưa có phim này trong Database!");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết phim: <?= $phim['ten_phim'] ?></title>
    <link rel="stylesheet" href="../tai_nguyen/css/style.css">
    <style>
        .container { max-width: 900px; margin: auto; color: white; display: flex; gap: 20px; padding: 20px; }
        .info { flex: 2; }
        .poster { flex: 1; }
        .poster img { width: 100%; border-radius: 10px; }
        h1 { color: #e50914; }
    </style>
</head>
<body style="background-color: #141414;">
    <div class="container">
        <div class="poster">
            <img src="../tai_nguyen/img/<?= $phim['hinh_anh'] ?>" alt="Poster">
        </div>
        <div class="info">
            <h1><?= $phim['ten_phim'] ?></h1>
            <p><strong>Thể loại:</strong> <?= $phim['the_loai'] ?></p>
            <p><strong>Thời lượng:</strong> <?= $phim['thoi_luong'] ?> phút</p>
            <hr>
            <h3>Mô tả phim:</h3>
            <p><?= $phim['mo_ta'] ?></p> 
            
            <br>
            <button style="padding: 10px 20px; background: #e50914; color: white; border: none; cursor: pointer;">
                CHỌN SUẤT CHIẾU
            </button>
        </div>
    </div>
</body>
</html>