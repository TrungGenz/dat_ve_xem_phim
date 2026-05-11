<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

$response = ['status' => 'error', 'message' => 'Sai email hoặc mật khẩu!'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mat_khau_nhap = $_POST['mat_khau'];

    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mat_khau_nhap, $user['mat_khau'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['ho_ten'];
        $response = ['status' => 'success'];
    }
}

// Trả về kết quả cho JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>