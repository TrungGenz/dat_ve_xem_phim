<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

$response = ['status' => 'error', 'message' => 'Sai email hoặc mật khẩu!'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mat_khau_nhap = isset($_POST['mat_khau']) ? $_POST['mat_khau'] : '';

    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // So sánh trực tiếp mật khẩu (==) để nhóm đăng nhập nhanh bằng 123456
    if ($user && $mat_khau_nhap == $user['mat_khau']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['ho_ten'];
        $_SESSION['vai_tro'] = $user['vai_tro']; 

        $response = [
            'status' => 'success',
            'vai_tro' => $user['vai_tro'] 
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>