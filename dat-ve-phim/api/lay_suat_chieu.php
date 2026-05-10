<?php
header('Content-Type: application/json');
require_once '../cau_hinh/ket_noi_db.php';

// Lấy id_phim từ link (ví dụ: lay_suat_chieu.php?id_phim=1)
$id_phim = $_GET['id_phim'] ?? 0;

if ($id_phim > 0) {
    try {
        // JOIN bảng suất chiếu với phim để lấy đủ thông tin
        $sql = "SELECT s.id, s.ngay_chieu, s.gio_chieu, p.ten_phim 
                FROM suat_chieu s 
                JOIN phim p ON s.id_phim = p.id 
                WHERE s.id_phim = ? 
                ORDER BY s.ngay_chieu, s.gio_chieu ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_phim]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>