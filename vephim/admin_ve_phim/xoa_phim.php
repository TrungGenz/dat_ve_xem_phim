<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// Kiểm tra xem có nhận được ID của phim cần xóa từ URL không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Tìm và xóa file ảnh trong thư mục uploads trước (để đỡ rác máy)
    $query_anh = "SELECT hinh_anh FROM phim WHERE id = $id";
    $result_anh = mysqli_query($conn, $query_anh);
    
    if ($row = mysqli_fetch_assoc($result_anh)) {
        $ten_file_anh = $row['hinh_anh'];
        $duong_dan_anh = "uploads/" . $ten_file_anh;
        
        // Nếu file ảnh tồn tại và tên ảnh không rỗng thì tiến hành xóa file
        if (!empty($ten_file_anh) && file_exists($duong_dan_anh)) {
            unlink($duong_dan_anh); // Hàm unlink dùng để xóa file vật lý
        }
    }

    // 2. Xóa dữ liệu phim trong Database
    $sql_delete = "DELETE FROM phim WHERE id = $id";

    if (mysqli_query($conn, $sql_delete)) {
        // Xóa thành công thì thông báo và quay lại trang danh sách
        echo "<script>alert('Đã xóa phim thành công!'); window.location.href='admin.php';</script>";
    } else {
        // Nếu có lỗi xảy ra
        echo "<script>alert('Lỗi khi xóa phim: " . mysqli_error($conn) . "'); window.location.href='admin.php';</script>";
    }
} else {
    // Nếu truy cập bậy bạ không có ID thì đẩy về trang admin
    header("Location: admin.php");
    exit();
}
?>