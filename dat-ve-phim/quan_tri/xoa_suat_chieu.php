<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->prepare("DELETE FROM suat_chieu WHERE id = ?")->execute([$id]);
}
header("Location: quan_ly_suat_chieu.php");
exit();
?>