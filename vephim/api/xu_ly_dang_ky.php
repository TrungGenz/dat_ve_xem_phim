<?php
include '../cau_hinh/ket_noi_db.php';
header('Content-Type: application/json'); // Trả về JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['so_dien_thoai'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);

    $check_email = "SELECT * FROM nguoi_dung WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email này đã được đăng ký!']);
    } else {
        $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, vai_tro) 
                VALUES ('$ho_ten', '$email', '$mat_khau', '$sdt', 0)";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công! Đang chuyển sang Đăng nhập...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống!']);
        }
    }
}
?>