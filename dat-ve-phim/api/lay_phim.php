<?php
// Gọi file kết nối (đi ngược ra 1 thư mục rồi vào cau_hinh)
require_once '../cau_hinh/ket_noi_db.php';

try {
    // Truy vấn lấy phim (Duy nhớ dùng đúng tên cột id, ten_phim, hinh_anh...)
    $sql = "SELECT * FROM phim";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $phim = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Trả về JSON cho Frontend
    header('Content-Type: application/json');
    echo json_encode($phim, JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>