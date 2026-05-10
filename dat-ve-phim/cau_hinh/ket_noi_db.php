<?php
$host = "localhost";
$db_name = "web_dat_ve_phim";
$username = "root";
$password = "";

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    // Thiết lập báo lỗi để Duy dễ sửa khi code sai
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối rồi Duy ơi: " . $e->getMessage());
}
?>