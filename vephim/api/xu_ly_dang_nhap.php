<?php
session_start();
include '../cau_hinh/ket_noi_db.php'; 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['mat_khau'] ?? '';

    if (empty($email) || empty($pass)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin!']);
        exit;
    }

    $sql = "SELECT * FROM nguoi_dung WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($pass, $user['mat_khau'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['ho_ten'];
    $_SESSION['vai_tro'] = $user['vai_tro']; // Lúc này giá trị sẽ là "admin" hoặc "user"

    echo json_encode([
        'status' => 'success',
        'message' => 'Đăng nhập thành công!',
        'vai_tro' => $user['vai_tro'] // Trả về chữ "admin"
    ]);
} else {
            echo json_encode(['status' => 'error', 'message' => 'Mật khẩu không chính xác!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tài khoản không tồn tại!']);
    }
}
?>