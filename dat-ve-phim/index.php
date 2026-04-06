<?php include 'thanh_phan/header.php'; ?>
<style>
    /* CSS để trang web chuyên nghiệp hơn */
    body { font-family: 'Arial', sans-serif; background-color: #1a1a1a; color: white; }
    .movie-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 40px; }
    .movie-card { background: #333; border-radius: 10px; overflow: hidden; transition: 0.3s; }
    .movie-card:hover { transform: scale(1.05); border: 2px solid red; }
    .movie-card img { width: 100%; height: 300px; object-fit: cover; }
    .movie-info { padding: 15px; text-align: center; }
    .btn-book { background: red; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; }
</style>

<h1 style="text-align: center; margin-top: 50px;">PHIM ĐANG CHIẾU</h1>

<div class="movie-container">
    <?php
    require_once 'cau_hinh/ket_noi_db.php';
    $ds_phim = $conn->query("SELECT * FROM phim")->fetchAll();
    foreach($ds_phim as $p): 
    ?>
    <div class="movie-card">
       <img src="tai_nguyen/img/<?= $p['hinh_anh'] ?>" style="width: 100%; height: 300px; object-fit: cover;">
        <div class="movie-info">
            <h3><?= $p['ten_phim'] ?></h3>
            <p><?= $p['thoi_luong'] ?> phút</p>
            <a href="trang/phim.php?id=<?= $p['id'] ?>" class="btn-book">ĐẶT VÉ</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php include 'thanh_phan/footer.php'; ?>