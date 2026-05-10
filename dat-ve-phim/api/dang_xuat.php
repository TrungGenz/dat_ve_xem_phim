<?php
session_start();
session_unset(); // Xóa hết biến session
session_destroy(); // Hủy phiên làm việc
header("Location: ../index.php"); // Đá về trang chủ
exit();
?>