<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// Lấy danh sách phim để đưa vào hộp chọn (dropdown)
$phim_query = "SELECT id, ten_phim FROM phim ORDER BY id DESC";
$phim_result = mysqli_query($conn, $phim_query);

// Lấy danh sách phòng chiếu
$phong_query = "SELECT id, ten_phong FROM phong";
$phong_result = mysqli_query($conn, $phong_query);

// Xử lý khi bấm nút "TẠO SUẤT CHIẾU"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phim_id = $_POST['phim_id'];
    $phong_id = $_POST['phong_id'];
    $ngay_chieu = $_POST['ngay_chieu'];
    $gio_chieu = $_POST['gio_chieu'];
    $gia_ve = $_POST['gia_ve'];

    // Lưu suất chiếu mới vào database
    $sql_insert = "INSERT INTO suat_chieu (phim_id, phong_id, ngay_chieu, gio_chieu, gia_ve) 
                   VALUES ('$phim_id', '$phong_id', '$ngay_chieu', '$gio_chieu', '$gia_ve')";

    if (mysqli_query($conn, $sql_insert)) {
        echo "<script>alert('Thêm suất chiếu thành công!'); window.location.href='suat_chieu.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Suất Chiếu - 5AESIUNHAN</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* CSS cho các ô chọn (select) đẹp và đồng bộ với input */
        .form-group select {
            background-color: #000000; 
            border: 1px solid #333;
            padding: 14px;
            color: white;
            border-radius: 6px;
            outline: none;
            font-size: 15px;
            width: 100%;
            cursor: pointer;
            appearance: none; /* Xóa mũi tên mặc định xấu xí của trình duyệt */
        }
        .form-group select:focus {
            border-color: #ff0000;
        }
        .form-group select option {
            background-color: #222;
            color: white;
        }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <div class="form-card">
            <h2 class="form-title">TẠO SUẤT CHIẾU MỚI</h2>
            <form action="" method="POST">
                
                <div class="form-group">
                    <label>Chọn Phim</label>
                    <select name="phim_id" required>
                        <option value="" disabled selected>-- Vui lòng chọn phim --</option>
                        <?php while($p = mysqli_fetch_assoc($phim_result)): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['ten_phim']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Chọn Phòng Chiếu</label>
                    <select name="phong_id" required>
                        <option value="" disabled selected>-- Vui lòng chọn phòng --</option>
                        <?php while($ph = mysqli_fetch_assoc($phong_result)): ?>
                            <option value="<?= $ph['id'] ?>"><?= htmlspecialchars($ph['ten_phong']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày chiếu</label>
                    <input type="date" name="ngay_chieu" required>
                </div>

                <div class="form-group">
                    <label>Giờ chiếu</label>
                    <input type="time" name="gio_chieu" required>
                </div>

                <div class="form-group">
                    <label>Giá vé (VNĐ)</label>
                    <input type="number" name="gia_ve" value="75000" required>
                </div>

                <button type="submit" class="btn-submit-large">LƯU SUẤT CHIẾU</button>
            </form>
            <div class="form-footer">
                <a href="suat_chieu.php">← Quay lại danh sách suất chiếu</a>
            </div>
        </div>
    </div>
</body>
</html>