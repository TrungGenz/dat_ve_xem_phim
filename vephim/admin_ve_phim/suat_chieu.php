<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// Câu lệnh JOIN để lấy danh sách suất chiếu kèm tên phim và tên phòng
$query = "SELECT suat_chieu.*, phim.ten_phim, phong.ten_phong 
          FROM suat_chieu 
          JOIN phim ON suat_chieu.phim_id = phim.id 
          JOIN phong ON suat_chieu.phong_id = phong.id 
          ORDER BY suat_chieu.ngay_chieu DESC, suat_chieu.gio_chieu DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Suất Chiếu - 5AESIUNHAN</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <aside class="sidebar">
        <div class="brand">5AESIUNHAN</div>
        <nav class="menu">
            <a href="admin.php" class="menu-item">Quản lý phim</a>
            <a href="suat_chieu.php" class="menu-item active">Quản lý suất chiếu</a>
            <a href="#" class="menu-item">Quản lý vé</a>
            <hr class="nav-divider">
            <a href="../api/dang_xuat.php" class="menu-item logout">Đăng xuất</a>
        </nav>
    </aside>

    <main class="content">
        <h1>Danh sách suất chiếu</h1>
        
        <div class="action-bar">
            <a href="them_suat_chieu.php" class="btn-add">+ Thêm suất chiếu mới</a>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TÊN PHIM</th>
                        <th>PHÒNG CHIẾU</th>
                        <th>NGÀY CHIẾU</th>
                        <th>GIỜ CHIẾU</th>
                        <th>GIÁ VÉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td style="font-weight: bold; color: #ffcc00;"><?= htmlspecialchars($row['ten_phim']) ?></td>
                                <td><?= htmlspecialchars($row['ten_phong']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['ngay_chieu'])) ?></td>
                                <td><?= date('H:i', strtotime($row['gio_chieu'])) ?></td>
                                <td><?= number_format($row['gia_ve'], 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #888;">Chưa có lịch chiếu nào được xếp.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>