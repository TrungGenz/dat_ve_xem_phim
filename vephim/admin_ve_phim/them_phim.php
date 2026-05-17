<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phim mới - 5AESIUNHAN</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <!-- Sidebar giữ nguyên để hợp tông -->
    <aside class="sidebar">
        <div class="brand">5AESIUNHAN</div>
        <nav class="menu">
            <a href="admin.php" class="menu-item">Quản lý phim</a>
            <a href="them_phim.php" class="menu-item active">Thêm phim mới</a>
            <a href="#" class="menu-item">Quản lý suất chiếu</a>
            <a href="#" class="menu-item">Quản lý vé</a>
            <hr class="nav-divider">
            <a href="api/dang_xuat.php" class="menu-item logout">Đăng xuất</a>
        </nav>
    </aside>

    <main class="content">
    <div class="form-wrapper">
        <div class="form-card">
            <h1 class="form-title">THÊM PHIM MỚI</h1>

            <form action="xu_ly_them.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tên phim</label>
                    <input type="text" name="ten_phim" placeholder="Ví dụ: Avengers..." required>
                </div>

                <div class="form-group">
                    <label>Thời lượng (phút)</label>
                    <input type="number" name="thoi_luong" placeholder="Ví dụ: 120" required>
                </div>

                <div class="form-group">
                     <label>Thể loại</label>
                     <input type="text" name="the_loai" placeholder="Ví dụ: Hành động, Viễn tưởng..." required>
                </div>

                <div class="form-group">
                    <label>Chọn poster phim</label>
                    <input type="file" name="hinh_anh" accept="image/*" class="file-input" required>
                </div>

                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <textarea name="mo_ta" rows="4" placeholder="Nhập nội dung phim..."></textarea>
                </div>

                <button type="submit" name="btn_them" class="btn-submit-large">LƯU PHIM NGAY</button>
            </form>
            
            <div class="form-footer">
                <a href="admin.php">← Quay lại danh sách phim</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>