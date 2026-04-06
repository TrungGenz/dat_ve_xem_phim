<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoa_don_id = $_POST['hoa_don_id'] ?? '';
    $phuong_thuc = $_POST['phuong_thuc'] ?? 'Tiền mặt'; // Ví dụ: MOMO, Thẻ ngân hàng...

    if (empty($hoa_don_id)) {
        die(json_encode(["status" => "error", "message" => "Thiếu mã hóa đơn!"]));
    }

    try {
        $conn->beginTransaction();

        // 1. Cập nhật trạng thái trong bảng hoa_don
        $sql_hd = "UPDATE hoa_don SET trang_thai = 'da_thanh_toan', phuong_thuc_tt = ? WHERE id = ?";
        $stmt_hd = $conn->prepare($sql_hd);
        $stmt_hd->execute([$phuong_thuc, $hoa_don_id]);

        // 2. Cập nhật tất cả các vé thuộc hóa đơn này thành 'confirmed' (đã xác nhận)
        $sql_ve = "UPDATE ve SET trang_thai = 'confirmed' WHERE hoa_don_id = ?";
        $stmt_ve = $conn->prepare($sql_ve);
        $stmt_ve->execute([$hoa_don_id]);

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Thanh toán thành công cho hóa đơn số: " . $hoa_don_id]);

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["status" => "error", "message" => "Lỗi thanh toán: " . $e->getMessage()]);
    }
}
?>