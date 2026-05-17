<?php
require_once '../cau_hinh/ket_noi_db.php';
$stmt = $conn->query("SELECT * FROM rap");
$ds_rap = $stmt->fetchAll();
?>
<h2>Quản lý Rạp Chiếu</h2>
<table border="1">
    <tr><th>ID</th><th>Tên Rạp</th><th>Địa chỉ</th></tr>
    <?php foreach($ds_rap as $r): ?>
    <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['ten_rap'] ?></td>
        <td><?= $r['dia_chi'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="dashboard.php">Quay lại</a>