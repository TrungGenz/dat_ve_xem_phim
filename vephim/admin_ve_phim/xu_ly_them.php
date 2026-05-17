<?php
include '../cau_hinh/ket_noi_db.php';
if(isset($_POST['btn_them'])) {
    $ten = $_POST['ten_phim'];
    $tg = $_POST['thoi_luong'];
    $the_loai = $_POST['the_loai'];
    $mota = $_POST['mo_ta'];
    
    // Xử lý upload ảnh
    $hinh_anh = $_FILES['hinh_anh']['name'];
    $tmp_name = $_FILES['hinh_anh']['tmp_name'];
    move_uploaded_file($tmp_name, "uploads/".$hinh_anh);

    // Chèn vào bảng phim theo cấu trúc trong image_1f0ad9.jpg
    $sql = "INSERT INTO phim (ten_phim, thoi_luong, the_loai, mo_ta, hinh_anh) 
            VALUES ('$ten', '$tg', '$the_loai', '$mota', '$hinh_anh')";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin.php"); // Xong thì quay lại trang quản lý
    }
}
?>