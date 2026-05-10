<?php
require_once '../cau_hinh/ket_noi_db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);

    try {
        // Bước 1: Kiểm tra email đã tồn tại chưa
        $check_sql = "SELECT id FROM nguoi_dung WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$email]);
        
        if ($check_stmt->rowCount() > 0) {
            // Nếu tìm thấy email trong DB
            echo "<script>
                alert('Tài khoản này đã tồn tại! Vui lòng dùng email khác.');
                window.history.back();
            </script>";
            exit();
        }

        // Bước 2: Nếu không trùng thì mới tiến hành Insert
        $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ho_ten, $email, $mat_khau]);

        echo "
        <div style='text-align: center; margin-top: 100px; font-family: sans-serif; background-color: #141414; color: white; height: 100vh; position: fixed; top: 0; left: 0; width: 100%;'>
            <h2 style='color: #e50914;'>Đăng ký thành công!</h2>
            <p style='font-size: 18px;'>Hệ thống sẽ chuyển sang trang đăng nhập sau 3 giây...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '../index.php?act=login'; 
            }, 3000);
        </script>";
        
    } catch (PDOException $e) {
        echo "Lỗi hệ thống: " . $e->getMessage();
    }
}
?>