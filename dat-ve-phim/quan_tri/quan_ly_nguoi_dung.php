<?php
require_once '../cau_hinh/ket_noi_db.php';
$sql = "SELECT id, ho_ten, email, so_dien_thoai, vai_tro FROM nguoi_dung";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Danh sách khách hàng của rạp</h2>
<table border="1">
    <tr>
        <th>Họ tên</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Vai trò</th>
    </tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u['ho_ten'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= $u['so_dien_thoai'] ?></td>
        <td><?= $u['vai_tro'] == 1 ? 'Admin' : 'Khách' ?></td>
    </tr>
    <?php endforeach; ?>
</table>