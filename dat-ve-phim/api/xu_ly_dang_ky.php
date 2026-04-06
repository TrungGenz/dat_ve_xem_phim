<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = $_POST['ho_ten'] ?? '';
    $email = $_POST['email'] ?? '';
    $mat_khau = $_POST['mat_khau'] ?? '';
    $sdt = $_POST['sdt'] ?? '';

    if (empty($ho_ten) || empty($email) || empty($mat_khau)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.history.back();</script>";
        exit;
    }

    // Mã hóa mật khẩu
    $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ho_ten, $email, $mat_khau_hash, $sdt]);

        // Thông báo và tự động nhảy sang trang Đăng nhập
        echo "<script>
            alert('Đăng ký thành công! Chào mừng " . $ho_ten . " đến với rạp phim.');
            window.location.href = '../trang/dang_nhap.php';
        </script>";

    } catch (PDOException $e) {
        // Nếu trùng email
        echo "<script>alert('Lỗi: Email này đã được sử dụng!'); window.history.back();</script>";
    }
}
?>