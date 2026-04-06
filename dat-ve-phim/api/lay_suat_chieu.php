<?php
require_once '../cau_hinh/ket_noi_db.php';
header('Content-Type: application/json');

// Duy nhận id_phim từ Frontend gửi lên (ví dụ: lay_suat_chieu.php?id_phim=1)
$id_phim = $_GET['id_phim'] ?? '';

if (empty($id_phim)) {
    echo json_encode(["status" => "error", "message" => "Thiếu ID phim!"]);
    exit;
}

try {
    // SQL: Lấy giờ chiếu và ngày chiếu của bộ phim đó
    // Duy kiểm tra lại tên bảng và cột trong DB của Duy nhé
    $sql = "SELECT id, ngay_chieu, gio_chieu FROM suat_chieu WHERE phim_id = ? ORDER BY ngay_chieu, gio_chieu ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_phim]);
    $suat_chieu = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "data" => $suat_chieu
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $e->getMessage()]);
}
?>