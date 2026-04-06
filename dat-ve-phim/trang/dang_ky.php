<?php include '../thanh_phan/header.php'; ?>

<style>
    /* 1. Thiết lập toàn màn hình để căn giữa */
    .register-wrapper {
        display: flex;
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center;    /* Căn giữa theo chiều dọc */
        min-height: 80vh;       /* Chiều cao vùng chứa */
        background-color: #f4f4f4; /* Màu nền nhẹ cho dễ nhìn */
    }

    /* 2. Thiết kế cái hộp Form */
    .register-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px; /* Độ rộng tối đa của form */
    }

    .register-container h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    /* 3. Làm đẹp các ô nhập liệu */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; /* Giúp input không bị tràn */
    }

    /* 4. Làm đẹp nút bấm */
    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #ff0000; /* Màu đỏ cho ton-sur-ton với rạp phim */
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background-color: #cc0000;
    }
</style>

<div class="register-wrapper">
    <div class="register-container">
        <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
        
        <form action="../api/xu_ly_dang_ky.php" method="POST">
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="ho_ten" placeholder="Nhập họ tên của bạn" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" placeholder="Ví dụ: duy@gmail.com" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="mat_khau" placeholder="********" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="sdt" placeholder="Nhập số điện thoại">
            </div>

            <button type="submit" class="btn-submit">Đăng ký ngay</button>
        </form>

        <p style="text-align: center; margin-top: 15px; font-size: 14px;">
            Đã có tài khoản? <a href="dang_nhap.php" style="color: red; text-decoration: none;">Đăng nhập tại đây</a>
        </p>
    </div>
</div>

<?php include '../thanh_phan/footer.php'; ?>