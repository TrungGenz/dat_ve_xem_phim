<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM phim WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: quan_ly_phim.php");
exit();
?>