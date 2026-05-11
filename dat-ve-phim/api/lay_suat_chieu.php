<?php
header('Content-Type: application/json');
require_once '../cau_hinh/ket_noi_db.php';

// Lấy id_phim từ yêu cầu GET (ví dụ: ?id_phim=1)
$id_phim = $_GET['id_phim'] ?? 0;

if ($id_phim > 0) {
    try {
        // Đã sửa tất cả thành phim_id cho khớp với Database của Duy
        $sql = "SELECT s.id, s.ngay_chieu, s.gio_chieu, p.ten_phim 
                FROM suat_chieu s 
                JOIN phim p ON s.phim_id = p.id 
                WHERE s.phim_id = ? 
                ORDER BY s.ngay_chieu, s.gio_chieu ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_phim]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trả về JSON cho bạn Lập render
        echo json_encode($data);
    } catch (PDOException $e) {
        // Trả về lỗi rõ ràng nếu có
        echo json_encode(["error" => "Lỗi SQL: " . $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>