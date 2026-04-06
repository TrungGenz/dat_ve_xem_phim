<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'] ?? ''; // Lấy ID người dùng từ Session Duy đã làm ở file Đăng nhập
    $suat_chieu_id = $_POST['suat_chieu_id'] ?? '';
    $ghe_ids = $_POST['ghe_ids'] ?? []; // Danh sách ID ghế (mảng)
    $tong_tien = $_POST['tong_tien'] ?? 0;

    if (!$user_id) {
        die(json_encode(["status" => "error", "message" => "Vui lòng đăng nhập!"]));
    }

    try {
        $conn->beginTransaction(); // Bắt đầu giao dịch để đảm bảo an toàn dữ liệu

        // 1. Tạo hóa đơn mới
        $sql_hd = "INSERT INTO hoa_don (nguoi_dung_id, tong_tien, ngay_dat) VALUES (?, ?, NOW())";
        $stmt_hd = $conn->prepare($sql_hd);
        $stmt_hd->execute([$user_id, $tong_tien]);
        $hoa_don_id = $conn->lastInsertId();

        // 2. Tạo các vé tương ứng với ghế đã chọn
        $sql_ve = "INSERT INTO ve (hoa_don_id, suat_chieu_id, ghe_id, trang_thai) VALUES (?, ?, ?, 'booked')";
        $stmt_ve = $conn->prepare($sql_ve);
        foreach ($ghe_ids as $ghe_id) {
            $stmt_ve->execute([$hoa_don_id, $suat_chieu_id, $ghe_id]);
        }

        $conn->commit(); // Hoàn tất lưu dữ liệu
        echo json_encode(["status" => "success", "message" => "Đặt vé thành công! Mã HD: " . $hoa_don_id]);
    } catch (Exception $e) {
        $conn->rollBack(); // Nếu lỗi thì hủy bỏ hết các lệnh trên
        echo json_encode(["status" => "error", "message" => "Lỗi đặt vé: " . $e->getMessage()]);
    }
}
?>