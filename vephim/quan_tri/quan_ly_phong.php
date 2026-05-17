<?php
require_once '../cau_hinh/ket_noi_db.php';
$stmt = $conn->query("SELECT p.*, r.ten_rap FROM phong p JOIN rap r ON p.rap_id = r.id");
$ds_phong = $stmt->fetchAll();
?>
<h2>Quản lý Phòng Chiếu</h2>
<table border="1" width="100%">
    <tr><th>ID</th><th>Tên Phòng</th><th>Thuộc Rạp</th></tr>
    <?php foreach($ds_phong as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['ten_phong'] ?></td>
        <td><?= $p['ten_rap'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br><a href="dashboard.php">Quay lại</a>