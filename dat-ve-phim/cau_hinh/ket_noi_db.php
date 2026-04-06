<?php
$host = "localhost";
$db_name = "web_dat_ve_phim";
$username = "root";
$password = ""; 

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // Thiết lập báo lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Nếu muốn test thử xem kết nối được chưa thì bỏ dấu // ở dòng dưới
    // echo "Kết nối thành công!"; 
} catch(PDOException $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}
?>