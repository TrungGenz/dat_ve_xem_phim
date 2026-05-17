<?php
require_once '../cau_hinh/ket_noi_db.php';
$stmt = $conn->query("SELECT g.*, p.ten_phong FROM ghe g JOIN phong p ON g.phong_id = p.id");
$ds_ghe = $stmt->fetchAll();
?>
<h2>Danh sách Ghế trong các Phòng</h2>
<table border="1">
    <tr><th>Phòng</th><th>Tên Ghế</th><th>Loại Ghế</th></tr>
    <?php foreach($ds_ghe as $g): ?>
    <tr>
        <td><?= $g['ten_phong'] ?></td>
        <td><?= $g['ten_ghe'] ?></td>
        <td><?= $g['loai_ghe'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>