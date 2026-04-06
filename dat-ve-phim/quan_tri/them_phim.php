<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

// 1. Kiểm tra quyền Admin
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 1) {
    header("Location: ../index.php");
    exit();
}

// 2. Xử lý khi Duy nhấn nút "Thêm Phim"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_phim = $_POST['ten_phim'];
    $thoi_luong = $_POST['thoi_luong'];
    $mo_ta = $_POST['mo_ta'];
    
    // Xử lý Upload ảnh
    $hinh_anh = $_FILES['hinh_anh']['name'];
    $target = "../tai_nguyen/img/" . basename($hinh_anh);

    if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target)) {
        try {
            $sql = "INSERT INTO phim (ten_phim, thoi_luong, mo_ta, hinh_anh) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ten_phim, $thoi_luong, $mo_ta, $hinh_anh]);
            echo "<script>alert('Thêm phim thành công!'); window.location='quan_ly_phim.php';</script>";
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        echo "Lỗi tải ảnh!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Phim Mới</title>
</head>
<body>
    <h2>Thêm Phim Mới vào Hệ Thống</h2>
    <form method="POST" enctype="multipart/form-data">
        <p>Tên phim: <input type="text" name="ten_phim" required></p>
        <p>Thời lượng (phút): <input type="number" name="thoi_luong" required></p>
        <p>Mô tả: <textarea name="mo_ta"></textarea></p>
        <p>Chọn Poster phim: <input type="file" name="hinh_anh" required></p>
        <button type="submit">Lưu Phim</button>
    </form>
    <br>
    <a href="quan_ly_phim.php">Quay lại danh sách</a>
</body>
</html>