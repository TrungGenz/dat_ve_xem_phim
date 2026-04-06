<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

// Bảo mật: Chỉ Admin (vai_tro = 1) mới được vào
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 1) {
    header("Location: ../index.php");
    exit();
}

// Lấy danh sách phim từ Database
$sql = "SELECT * FROM phim ORDER BY id DESC";
$stmt = $conn->query($sql);
$ds_phim = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Quản lý Phim - Admin Duy</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-add { background: green; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
        .btn-edit { color: blue; }
        .btn-delete { color: red; }
    </style>
</head>
<body>
    <h1>Danh sách Phim trong kho</h1>
    <a href="them_phim.php" class="btn-add">+ Thêm Phim Mới</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tên Phim</th>
                <th>Thời lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ds_phim as $phim): ?>
            <tr>
                <td><?= $phim['id'] ?></td>
                <td><img src="../tai_nguyen/img/<?= $phim['hinh_anh'] ?>" width="50"></td>
                <td><?= $phim['ten_phim'] ?></td>
                <td><?= $phim['thoi_luong'] ?> phút</td>
                <td>
                    <a href="sua_phim.php?id=<?= $phim['id'] ?>" class="btn-edit">Sửa</a> | 
                    <a href="xoa_phim.php?id=<?= $phim['id'] ?>" class="btn-delete" onclick="return confirm('Duy chắc chắn muốn xóa phim này không?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="dashboard.php"> < Quay lại Dashboard</a>
</body>
</html>