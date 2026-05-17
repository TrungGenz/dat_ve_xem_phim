<?php
require_once '../cau_hinh/ket_noi_db.php';

try {
    $sql = "SELECT * FROM phim";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo "Lỗi lấy phim: " . $e->getMessage();
}
?>