<?php include '../thanh_phan/header.php'; ?>

<style>
    /* Duy có thể tạo một file .css riêng rồi link vào, nhưng dán trực tiếp thế này cho nhanh cũng được */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        background-color: #f4f4f4;
    }

    .login-container {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 380px;
    }

    .login-container h2 {
        text-align: center;
        color: #222;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-sizing: border-box;
        transition: 0.3s;
    }

    .form-group input:focus {
        border-color: #ff0000;
        outline: none;
        box-shadow: 0 0 5px rgba(255,0,0,0.2);
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background-color: #e60000;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #b30000;
        transform: translateY(-1px);
    }

    .extra-links {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }

    .extra-links a {
        color: #e60000;
        text-decoration: none;
        font-weight: bold;
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <h2>ĐĂNG NHẬP</h2>
        
        <form action="../api/xu_ly_dang_nhap.php" method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" placeholder="Nhập email của bạn" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="mat_khau" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" class="btn-login">Vào xem phim</button>
        </form>

        <div class="extra-links">
            Chưa có tài khoản? <a href="dang_ky.php">Đăng ký ngay</a>
        </div>
    </div>
</div>

<?php include '../thanh_phan/footer.php'; ?>