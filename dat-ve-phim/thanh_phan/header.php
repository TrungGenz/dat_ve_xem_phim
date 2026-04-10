<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav style="background: #222; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid red;">
    <div>
        <a href="/dat-ve-phim/index.php" style="color: red; text-decoration: none; font-size: 24px; font-weight: bold;">
            RẠP PHIM DUY NOOB
        </a>
    </div>
    
    <div style="display: flex; gap: 20px; align-items: center;">
        <?php if (isset($_SESSION['user_name'])): ?>
            <span style="color: #eee;">Xin chào, <b style="color: #fff;"><?= $_SESSION['user_name'] ?></b></span>
            
            <?php if (isset($_SESSION['vai_tro']) && $_SESSION['vai_tro'] == 1): ?>
                <a href="/dat-ve-phim/quan_tri/dashboard.php" style="color: yellow; text-decoration: none;">Quản trị</a>
            <?php endif; ?>
            
            <a href="/dat-ve-phim/trang/thong_tin_ca_nhan.php" style="color: white; text-decoration: none;">Hồ sơ</a>
            <a href="/dat-ve-phim/api/dang_xuat.php" style="color: #ff4d4d; text-decoration: none; font-weight: bold;">Thoát</a>
            
        <?php else: ?>
            <a href="/dat-ve-phim/trang/dang_nhap.php" style="color: white; text-decoration: none;">Đăng nhập</a>
            <span style="color: #666;">|</span>
            <a href="/dat-ve-phim/trang/dang_ky.php" style="color: white; text-decoration: none;">Đăng ký</a>
        <?php endif; ?>
    </div>
</nav>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QNU Cinema - Hệ thống đặt vé</title>
    <link rel="stylesheet" href="../tai_nguyen/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">7AE<span>SIUNHAN</span></div>
            <ul class="nav-links">
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="dat_ve.php">Lịch Chiếu</a></li>
                <li><a href="#">Phim Hot</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="dang_nhap.php"><button class="btn-login">Đăng Nhập</button></a>
                <a href="dang_ky.php"><button class="btn-signup">Đăng Ký</button></a>
            </div>
        </nav>
    </header>