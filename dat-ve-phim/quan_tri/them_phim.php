<?php
session_start();
// Nhảy ra ngoài thư mục quan_tri để vào cau_hinh
require_once '../cau_hinh/ket_noi_db.php'; 

// 1. Kiểm tra quyền Admin (Để tránh người lạ tự ý vào thêm phim)
// Giả sử quy định vai_tro = 1 là Admin
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 1) {
    // Nếu không phải admin, đẩy về trang chủ ngay
    header("Location: ../index.php");
    exit();
}

// 2. Xử lý khi nhấn nút "Lưu Phim"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_phim = $_POST['ten_phim'];
    $thoi_luong = $_POST['thoi_luong'];
    $mo_ta = $_POST['mo_ta'];
    
    // Xử lý Upload ảnh (Cần cẩn thận đường dẫn)
    $hinh_anh = $_FILES['hinh_anh']['name'];
    // kiểm tra xem thư mục tai_nguyen/img có tồn tại chưa nhé
    $target = "../tai_nguyen/img/" . basename($hinh_anh);

    if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target)) {
        try {
            $sql = "INSERT INTO phim (ten_phim, thoi_luong, mo_ta, hinh_anh) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$ten_phim, $thoi_luong, $mo_ta, $hinh_anh]);
            
            echo "<script>
                alert('Thêm phim thành công!'); 
                window.location.href='quan_ly_phim.php';
            </script>";
        } catch (PDOException $e) {
            echo "<p style='color:red'>Lỗi Database: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<script>alert('Lỗi tải ảnh! kiểm tra lại thư mục tai_nguyen/img.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Phim Mới | Admin</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .form-container { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        input, textarea { width: 100%; margin-bottom: 10px; padding: 8px; }
        button { background: #e50914; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Thêm Phim Mới vào Hệ Thống</h2>
        <form method="POST" enctype="multipart/form-data">
            <p>Tên phim: <input type="text" name="ten_phim" placeholder="Nhập tên phim..." required></p>
            <p>Thời lượng (phút): <input type="number" name="thoi_luong" placeholder="Ví dụ: 120" required></p>
            <p>Mô tả: <textarea name="mo_ta" rows="4" placeholder="Viết mô tả phim..."></textarea></p>
            <p>Chọn Poster phim: <input type="file" name="hinh_anh" required></p>
            <button type="submit">Lưu Phim</button>
        </form>
        <br>
        <a href="quan_ly_phim.php">← Quay lại danh sách quản lý</a>
    </div>
</body>
</html>