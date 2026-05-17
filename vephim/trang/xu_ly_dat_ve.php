<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// Lấy ID người dùng. Nếu chưa đăng nhập thì tạm thời lấy ID = 1 để test code không bị lỗi
$nguoi_dung_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

// Nếu có dữ liệu gửi sang từ form đặt vé
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $suat_chieu_id = $_POST['id_suat'];
    $so_ghe = $_POST['danh_sach_ghe']; // Ví dụ: "C4,C5"

    // Câu lệnh lưu thông tin vé vào database
    $sql_insert = "INSERT INTO ve (nguoi_dung_id, suat_chieu_id, so_ghe, trang_thai) 
                   VALUES ('$nguoi_dung_id', '$suat_chieu_id', '$so_ghe', 'thanh_toan_thanh_cong')";

    if (mysqli_query($conn, $sql_insert)) {
        // Nếu thành công, báo hỷ và đẩy về trang chủ
        echo "<script>
                alert('🎉 Đặt vé thành công! Hẹn gặp lại bạn tại rạp 5AESIUNHAN nhé.'); 
                window.location.href='../index.php';
              </script>";
    } else {
        // Nếu lỗi
        echo "<script>
                alert('Có lỗi xảy ra: " . mysqli_error($conn) . "');
                window.location.href='chon_ghe.php?id_suat=$suat_chieu_id';
              </script>";
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>