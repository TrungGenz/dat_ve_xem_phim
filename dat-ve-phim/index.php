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



            $sql = "SELECT * FROM phim ORDER BY id DESC";

            $stmt = $conn->query($sql);

            $ds_phim = $stmt->fetchAll(PDO::FETCH_ASSOC);



            if ($ds_phim):

                foreach ($ds_phim as $p):

            ?>

                <div class="movie-card">

                    <img src="tai_nguyen/img/<?= !empty($p['hinh_anh']) ? $p['hinh_anh'] : 'default.jpg' ?>" alt="<?= htmlspecialchars($p['ten_phim']) ?>">

                    <h3><?= htmlspecialchars($p['ten_phim']) ?></h3>

                    <p><?= htmlspecialchars($p['the_loai'] ?? 'Kinh dị') ?> | <?= $p['thoi_luong'] ?> phút</p>

                    <a href="trang/phim.php?id=<?= $p['id'] ?>" class="btn-ticket">Đặt Vé</a>

                </div>

            <?php

                endforeach;

            else:

                echo "<p style='color: #888; text-align: center; width: 100%;'>Hiện chưa có phim nào.</p>";

            endif;

            ?>

        </div>

    </section>



    <div id="loginModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeModal('loginModal')">&times;</span>

            <h2>Đăng Nhập</h2>

            <p id="login-message" style="font-size: 14px; text-align: center; display: none; margin-bottom: 10px;"></p>

           

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

        function openModal(id) { document.getElementById(id).style.display = "block"; }

        function closeModal(id) {

            document.getElementById(id).style.display = "none";

            document.getElementById('login-message').style.display = "none";

        }



        window.onclick = function(event) {

            if (event.target.className === 'modal') { closeModal(event.target.id); }

        }



        // XỬ LÝ ĐĂNG NHẬP AJAX

        document.getElementById('loginForm').addEventListener('submit', function(e) {

            e.preventDefault();

            const formData = new FormData(this);

            const messageBox = document.getElementById('login-message');



            messageBox.style.display = "block";

            messageBox.style.color = "orange";

            messageBox.innerText = "Đang xử lý...";



            fetch('api/xu_ly_dang_nhap.php', {

                method: 'POST',

                body: formData

            })

            .then(response => response.text()) // Đọc text trước để kiểm tra lỗi PHP nếu có

            .then(text => {

                try {

                    const data = JSON.parse(text);

                    if (data.status === 'success') {

                        messageBox.style.color = "#28a745";

                        messageBox.innerText = "Đăng nhập thành công!";

                       

                        setTimeout(() => {

                            // SỬA: Chuyển hướng đúng admin.php thay vì index.php

                            if (data.vai_tro.trim() === 'admin') {

                               window.location.href = 'admin.php';

                            } else {

                                window.location.href = 'index.php';

                            }

                        }, 1000);

                    } else {

                        messageBox.style.color = "#e50914";

                        messageBox.innerText = "⚠ " + data.message;

                    }

                } catch (err) {

                    console.error("Lỗi phản hồi hệ thống:", text);

                    messageBox.style.color = "red";

                    messageBox.innerText = "Lỗi xử lý hệ thống!";

                }

            })

            .catch(error => {

                messageBox.innerText = "Lỗi kết nối Server!";

            });

        });

    </script>

</body>

</html>