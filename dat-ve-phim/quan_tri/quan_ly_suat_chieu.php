<?php
session_start();
require_once '../cau_hinh/ket_noi_db.php';

// 1. Bảo mật Admin
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] != 1) {
    header("Location: ../index.php");
    exit();
}

// 2. Xử lý khi Duy nhấn nút "Thêm Suất Chiếu"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phim_id = $_POST['phim_id'];
    $ngay_chieu = $_POST['ngay_chieu'];
    $gio_chieu = $_POST['gio_chieu'];
    $gia_ve = $_POST['gia_ve'];

    try {
        $sql = "INSERT INTO suat_chieu (phim_id, ngay_chieu, gio_chieu, gia_ve) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$phim_id, $ngay_chieu, $gio_chieu, $gia_ve]);
        echo "<script>alert('Xếp lịch thành công!');</script>";
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

// 3. Lấy danh sách phim để đổ vào ô Chọn (Dropdown)
$phim_stmt = $conn->query("SELECT id, ten_phim FROM phim");
$danh_sach_phim = $phim_stmt->fetchAll();

// 4. Lấy danh sách suất chiếu hiện có để Duy quản lý
$show_stmt = $conn->query("SELECT s.*, p.ten_phim FROM suat_chieu s JOIN phim p ON s.phim_id = p.id ORDER BY s.ngay_chieu DESC");
$ds_suat_chieu = $show_stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Suất Chiếu</title>
</head>
<body>
    <h2>Xếp Lịch Chiếu Phim</h2>
    <form method="POST">
        Phim: 
        <select name="phim_id" required>
            <?php foreach($danh_sach_phim as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['ten_phim'] ?></option>
            <?php endforeach; ?>
        </select>
        Ngày chiếu: <input type="date" name="ngay_chieu" required>
        Giờ chiếu: <input type="time" name="gio_chieu" required>
        Giá vé: <input type="number" name="gia_ve" value="75000" required>
        <button type="submit">Thêm Suất Chiếu</button>
    </form>

    <hr>
    <h3>Lịch chiếu hiện tại</h3>
    <table border="1" width="100%">
        <tr>