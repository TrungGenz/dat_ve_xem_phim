<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $mat_khau_nhap = $_POST['mat_khau'] ?? '';

    try {
        $sql = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mat_khau_nhap, $user['mat_khau'])) {
            // Lưu thông tin vào Session để các trang khác nhận diện được Duy
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['vai_tro'] = $user['vai_tro'];

            // Thông báo và tự động nhảy về Trang chủ
            echo "<script>
                alert('Đăng nhập thành công! Chúc bạn xem phim vui vẻ.');
                window.location.href = '../index.php';
            </script>";
        } else {
            echo "<script>alert('Email hoặc mật khẩu không chính xác!'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "Lỗi hệ thống: " . $e->getMessage();
    }
}
?>