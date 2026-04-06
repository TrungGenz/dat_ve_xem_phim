<?php
require_once '../cau_hinh/ket_noi_db.php';
header('Content-Type: application/json');

$suat_chieu_id = $_GET['suat_chieu_id'] ?? '';

try {
    // Lấy danh sách ghế và trạng thái (đã đặt hay chưa) của suất chiếu đó
    $sql = "SELECT g.id, g.ten_ghe, g.loai_ghe, v.trang_thai 
            FROM ghe g 
            LEFT JOIN ve v ON g.id = v.ghe_id AND v.suat_chieu_id = ?
            ORDER BY g.ten_ghe ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$suat_chieu_id]);
    $danh_sach_ghe = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["status" => "success", "data" => $danh_sach_ghe]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>