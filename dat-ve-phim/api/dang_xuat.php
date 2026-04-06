<?php
session_start();
session_unset(); // Xóa dữ liệu trong phiên
session_destroy(); // Hủy phiên làm việc
header("Location: ../index.php"); // Chuyển về trang chủ
exit();
?>