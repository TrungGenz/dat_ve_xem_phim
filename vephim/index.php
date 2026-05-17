<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5AESIUNHAN - Đặt Vé Xem Phim</title>
    <!-- Đảm bảo đường dẫn CSS này chính xác -->
    <link rel="stylesheet" href="tai_nguyen/css/style.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">5AE<span>SIUNHAN</span></div>
            <ul class="nav-links">
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="#">Lịch Chiếu</a></li>
                <li><a href="#">Phim Hot</a></li>
            </ul>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_name'])): ?>
                    <span style="color: white; margin-right: 10px;">Chào, <b><?= htmlspecialchars($_SESSION['user_name']) ?></b></span>
                    <a href="api/dang_xuat.php" style="color: #e50914; text-decoration: none; font-weight: bold;">Thoát</a>
                <?php else: ?>
                    <button class="btn-login" onclick="openModal('loginModal')">Đăng Nhập</button>
                    <button class="btn-signup" onclick="openModal('signupModal')">Đăng Ký</button>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Trải nghiệm điện ảnh đỉnh cao</h1>
            <p>Đặt vé ngay hôm nay để nhận ưu đãi hấp dẫn!</p>
            <a href="#movies" class="btn-primary" style="text-decoration: none; display: inline-block; background: #e50914; color: white; padding: 12px 25px; border-radius: 5px; font-weight: bold;">Xem Phim Ngay</a>
        </div>
    </section>

    <section id="movies" class="movie-section" style="padding: 50px 5%; background: #121212;">
        <h2 style="color: white; border-left: 4px solid #e50914; padding-left: 15px; margin-bottom: 30px;">Phim Đang Chiếu</h2>
        
        <div class="movie-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 30px;">
            <?php
            require_once 'cau_hinh/ket_noi_db.php';
            
            // Lấy danh sách phim, phim mới thêm sẽ hiện lên đầu
            $result = mysqli_query($conn, "SELECT * FROM phim ORDER BY id DESC");
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Kiểm tra ảnh: Ưu tiên lấy từ thư mục uploads (admin thêm), nếu ko có thì dùng ảnh mặc định
                    $path_hinh = !empty($row['hinh_anh']) ? "admin_ve_phim/uploads/" . $row['hinh_anh'] : "tai_nguyen/img/default.jpg";
            ?>
                <div class="movie-card" style="background: #1e1e1e; padding: 15px; border-radius: 10px; text-align: center; transition: 0.3s;">
                    <img src="<?= $path_hinh ?>" 
                         alt="<?= htmlspecialchars($row['ten_phim']) ?>" 
                         style="width: 100%; height: 300px; object-fit: cover; border-radius: 5px;"
                         onerror="this.src='https://via.placeholder.com/200x300?text=No+Poster'">
                    
                    <h3 style="color: white; margin: 15px 0 10px; font-size: 18px;"><?= htmlspecialchars($row['ten_phim']) ?></h3>
                    <p style="color: #bbb; font-size: 14px; margin-bottom: 20px;">
                        Thời lượng: <?= $row['thoi_luong'] ?> phút
                    </p>
                    
                    <a href="trang/chi_tiet_phim.php?id_phim=<?= $row['id'] ?>" class="btn-ticket" style="text-decoration: none; display: block; background: #e50914; color: white; padding: 10px; border-radius: 5px; font-weight: bold; text-transform: uppercase;">
                        ĐẶT VÉ
                    </a>
                </div>
            <?php 
                }
            } else {
                echo "<p style='color: #888; grid-column: 1/-1; text-align: center;'>Hiện chưa có phim nào trong danh sách.</p>";
            } 
            ?>
        </div>
    </section>

    <!-- Modal Đăng Nhập & Đăng Ký (Giữ nguyên phần Script và Modal của bạn) -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('loginModal')">&times;</span>
            <h2>Đăng Nhập</h2>
            <p id="login-message" style="color: #e50914; font-size: 14px; text-align: center; display: none; margin-bottom: 10px;"></p>
            <form id="loginForm">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="mat_khau" placeholder="Mật khẩu" required>
                <button type="submit" class="btn-submit">Đăng nhập</button>
            </form>
        </div>
    </div>

    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('signupModal')">&times;</span>
            <h2>Đăng Ký Tài Khoản</h2>
            <p id="signup-message" style="font-size: 14px; text-align: center; display: none; margin-bottom: 10px;"></p>
            <form id="signupForm">
                <input type="text" name="ho_ten" placeholder="Họ và tên" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="so_dien_thoai" placeholder="Số điện thoại" required>
                <input type="password" name="mat_khau" placeholder="Mật khẩu" required>
                <button type="submit" class="btn-submit">Tạo tài khoản</button>
            </form>
        </div>
    </div>

    <script src="tai_nguyen/js/script.js"></script>
</body>
</html>