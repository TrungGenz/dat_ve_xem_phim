<?php
session_start();
header('Content-Type: application/json');
require_once '../cau_hinh/ket_noi_db.php';

// Kiểm tra xem khách đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Vui lòng đăng nhập để đặt vé!"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $id_suat = $_POST['id_suat_chieu'];
    $so_ghe = $_POST['so_ghe']; // Ví dụ: "C1" hoặc "C1, C2"

    try {
        // Lưu vé mới vào Database
        $sql = "INSERT INTO ve (id_nguoi_dung, id_suat_chieu, so_ghe, ngay_dat) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id, $id_suat, $so_ghe]);

        echo json_encode(["status" => "success", "message" => "Đặt vé thành công rực rỡ!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Lỗi lưu vé: " . $e->getMessage()]);
    }
}
?>