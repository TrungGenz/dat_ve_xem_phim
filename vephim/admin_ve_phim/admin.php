<?php
session_start();

if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - 5AESIUNHAN</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <aside class="sidebar">
        <div class="brand">5AESIUNHAN</div>
        <nav class="menu">
            <a href="admin.php" class="menu-item active">Quản lý phim</a>
            <a href="them_phim.php" class="menu-item">Thêm phim mới</a>
            <a href="suat_chieu.php" class="menu-item">Quản lý suất chiếu</a>
            <a href="#" class="menu-item">Quản lý vé</a>
            <hr class="nav-divider">
            <a href="../api/dang_xuat.php" class="menu-item logout">Đăng xuất</a>
        </nav>
    </aside>

    <main class="content">
        <h1>Danh sách phim đang chiếu</h1>
        
        <div class="action-bar">
            <a href="them_phim.php" class="btn-add">+ Thêm phim mới</a>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>POSTER</th>
                        <th>TÊN PHIM</th>
                        <th>THỂ LOẠI</th>
                        <th>THỜI LƯỢNG</th>
                        <th>THAO TÁC</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Gọi file riêng vào đây -->
                    <?php include 'danh_sach_phim.php'; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>