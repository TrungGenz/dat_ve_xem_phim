<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Star - Đặt Vé Xem Phim</title>
    <link rel="stylesheet" href="tai_nguyen/css/style.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">7AE<span>SIUNHAN</span></div>
            <ul class="nav-links">
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="#">Lịch Chiếu</a></li>
                <li><a href="#">Phim Hot</a></li>
            </ul>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_name'])): ?>
                    <span style="color: white; margin-right: 10px;">Chào, <b><?= $_SESSION['user_name'] ?></b></span>
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
            <a href="#movies" class="btn-primary">Xem Phim Ngay</a>
        </div>
    </section>

 <section id="movies" class="movie-section">
    <h2>Phim Đang Chiếu</h2>
    <div class="movie-grid">
        <?php
        require_once 'cau_hinh/ket_noi_db.php';
        // Lấy tất cả phim từ bảng 'phim' mà Duy vừa tạo
        $stmt = $conn->query("SELECT * FROM phim");
        while ($row = $stmt->fetch()) {
        ?>
            <div class="movie-card">
                <img src="tai_nguyen/img/<?= $row['hinh_anh'] ?>" alt="<?= $row['ten_phim'] ?>" onerror="this.src='https://via.placeholder.com/200x300'">
                <h3><?= $row['ten_phim'] ?></h3>
                <p>Hành Động | <?= $row['thoi_luong'] ?> phút</p>
                
                <a href="trang/chi_tiet_phim.php?id_phim=<?= $row['id'] ?>" class="btn-ticket" style="text-decoration: none; display: inline-block; background: #e50914; color: white; padding: 10px 20px; border-radius: 5px;">
                    ĐẶT VÉ
                </a>
            </div>
        <?php } ?>
    </div>
</section>

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
            <form action="api/xu_ly_dang_ky.php" method="POST">
                <input type="text" name="ho_ten" placeholder="Họ và tên" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="mat_khau" placeholder="Mật khẩu" required>
                <button type="submit" class="btn-submit">Tạo tài khoản</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { 
            document.getElementById(id).style.display = "block"; 
        }
        function closeModal(id) { 
            document.getElementById(id).style.display = "none";
            if(id === 'loginModal') {
                document.getElementById('login-message').style.display = "none";
            }
        }
        window.onclick = function(event) {
            if (event.target.className === 'modal') { closeModal(event.target.id); }
        }

        // Tự mở đăng nhập nếu đăng ký thành công
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('act') === 'login') {
                openModal('loginModal');
            }
        };

        // AJAX Đăng nhập: hiện lỗi ngay tại Modal
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const messageBox = document.getElementById('login-message');

            fetch('api/xu_ly_dang_nhap.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageBox.style.color = "#28a745";
                    messageBox.innerText = "Đăng nhập thành công! Đang chuyển hướng...";
                    messageBox.style.display = "block";
                    setTimeout(() => { window.location.href = 'index.php'; }, 1500);
                } else {
                    messageBox.style.color = "#e50914";
                    messageBox.innerText = "⚠ " + data.message;
                    messageBox.style.display = "block";
                }
            })
            .catch(error => {
                messageBox.style.display = "block";
                messageBox.innerText = "Lỗi kết nối Server!";
            });
        });
    </script>
</body>
</html>