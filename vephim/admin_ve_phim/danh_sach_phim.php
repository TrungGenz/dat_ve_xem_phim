<?php 
include '../cau_hinh/ket_noi_db.php';

$sql = "SELECT * FROM phim ORDER BY id DESC"; 
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
                <img src="uploads/<?php echo $row['hinh_anh']; ?>" width="50" style="border-radius: 4px;">
            </td>
            <td><?php echo $row['ten_phim']; ?></td>
            <td><?php echo $row['the_loai']; ?></td>
            <td><?php echo $row['thoi_luong']; ?> phút</td>
            <td>
                <a href="sua_phim.php?id=<?php echo $row['id']; ?>" class="btn-edit">Sửa</a>
                <a href="xoa_phim.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='6' style='text-align:center;'>Chưa có phim nào.</td></tr>";
}
?>