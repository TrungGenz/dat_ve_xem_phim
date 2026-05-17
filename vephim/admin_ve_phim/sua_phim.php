<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// 1. Kiểm tra xem có nhận được ID từ URL không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Lấy thông tin phim hiện tại từ database
    $query = "SELECT * FROM phim WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $phim = mysqli_fetch_assoc($result);

    if (!$phim) {
        echo "<script>alert('Không tìm thấy dữ liệu phim!'); window.location.href='admin.php';</script>";
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}

// 2. Xử lý khi người dùng bấm nút "CẬP NHẬT PHIM"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_phim = $_POST['ten_phim'];
    $thoi_luong = $_POST['thoi_luong'];
    $the_loai = $_POST['the_loai'];
    $mo_ta = $_POST['mo_ta'];

    // Khởi tạo câu lệnh UPDATE cơ bản (chưa đụng tới ảnh)
    $sql_update = "UPDATE phim SET 
                    ten_phim = '$ten_phim', 
                    thoi_luong = '$thoi_luong', 
                    the_loai = '$the_loai', 
                    mo_ta = '$mo_ta'";

    // Kiểm tra xem người dùng có chọn upload ảnh mới không
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        $thu_muc_luu = "uploads/";
        $ten_file_goc = basename($_FILES["hinh_anh"]["name"]);
        $hinh_anh_moi = time() . "_" . $ten_file_goc; // Đổi tên cho khỏi trùng
        $duong_dan_luu = $thu_muc_luu . $hinh_anh_moi;
        
        // Di chuyển file mới vào thư mục uploads
        if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $duong_dan_luu)) {
            // NẾU CÓ ẢNH MỚI: Nối thêm đoạn code cập nhật cột hinh_anh vào lệnh SQL
            $sql_update .= ", hinh_anh = '$hinh_anh_moi'";
        }
    }

    // Chốt câu lệnh SQL bằng điều kiện WHERE id
    $sql_update .= " WHERE id = $id";

    // Chạy câu lệnh
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật phim thành công!'); window.location.href='admin.php';</script>";
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phim - 5AESIUNHAN</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="form-wrapper">
        <div class="form-card">
            <h2 class="form-title">SỬA THÔNG TIN PHIM</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tên phim</label>
                    <input type="text" name="ten_phim" value="<?= htmlspecialchars($phim['ten_phim']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Thời lượng (phút)</label>
                    <input type="number" name="thoi_luong" value="<?= htmlspecialchars($phim['thoi_luong']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Thể loại</label>
                    <input type="text" name="the_loai" value="<?= htmlspecialchars($phim['the_loai'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <textarea name="mo_ta" rows="4"><?= htmlspecialchars($phim['mo_ta']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Poster hiện tại</label>
                    <img src="uploads/<?= $phim['hinh_anh'] ?>" alt="Poster" style="width: 150px; border-radius: 8px; margin-bottom: 10px;">
                </div>

                <div class="form-group">
                    <label style="color: #ffcc00;">Chọn poster mới (Để trống nếu bạn không muốn đổi ảnh)</label>
                    <input type="file" name="hinh_anh">
                </div>
                
                <button type="submit" class="btn-submit-large">CẬP NHẬT PHIM</button>
            </form>
            <div class="form-footer">
                <a href="admin.php">← Quay lại danh sách</a>
            </div>
        </div>
    </div>
</body>
</html>