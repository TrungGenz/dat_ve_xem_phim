<?php
header('Content-Type: application/json');
require_once '../cau_hinh/ket_noi_db.php';

// Nhận id suất chiếu để kiểm tra ghế của riêng suất đó
$id_suat = $_GET['id_suat_chieu'] ?? 0;

if ($id_suat > 0) {
    try {
        // Lấy tất cả số ghế đã nằm trong bảng 've' của suất chiếu này
        $sql = "SELECT so_ghe FROM ve WHERE id_suat_chieu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_suat]);
        
        // Trả về mảng đơn giản: ["A1", "A2", "B5"]
        $ghe_da_dat = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo json_encode($ghe_da_dat);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>