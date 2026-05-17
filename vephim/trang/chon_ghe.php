<?php
session_start();
// Kết nối database
require_once '../cau_hinh/ket_noi_db.php'; 

// Kiểm tra xem có nhận được ID suất chiếu không
if (!isset($_GET['id_suat'])) {
    header("Location: ../index.php");
    exit();
}

$id_suat = $_GET['id_suat'];

// 1. Lấy thông tin chi tiết của suất chiếu này
$query = "SELECT suat_chieu.*, phim.ten_phim, phong.ten_phong 
          FROM suat_chieu 
          JOIN phim ON suat_chieu.phim_id = phim.id 
          JOIN phong ON suat_chieu.phong_id = phong.id 
          WHERE suat_chieu.id = $id_suat";
$result = mysqli_query($conn, $query);
$suat = mysqli_fetch_assoc($result);

if (!$suat) {
    echo "<script>alert('Suất chiếu không tồn tại!'); window.location.href='../index.php';</script>";
    exit();
}

// 2. Lấy danh sách các ghế đã được đặt trong suất chiếu này
$query_ve = "SELECT so_ghe FROM ve WHERE suat_chieu_id = $id_suat";
$result_ve = mysqli_query($conn, $query_ve);
$ghe_da_dat = [];
while ($row = mysqli_fetch_assoc($result_ve)) {
    // Tách các ghế ra nếu 1 người đặt nhiều ghế (VD: "A1, A2")
    $ghe_arr = explode(',', $row['so_ghe']);
    foreach($ghe_arr as $g) {
        $ghe_da_dat[] = trim($g);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Ghế - <?= htmlspecialchars($suat['ten_phim']) ?></title>
    <link rel="stylesheet" href="../tai_nguyen/css/style.css">
    <style>
        body { background-color: #141414; color: white; padding-top: 80px; }
        .booking-container { display: flex; max-width: 1100px; margin: 40px auto; gap: 30px; }
        
        /* Cột bên trái: Sơ đồ ghế */
        .seat-selection { flex: 2; background: #222; padding: 30px; border-radius: 10px; }
        .screen { background: linear-gradient(to bottom, #555, #222); height: 50px; width: 100%; text-align: center; line-height: 50px; font-weight: bold; letter-spacing: 5px; color: #aaa; margin-bottom: 40px; border-radius: 5px; box-shadow: 0 10px 20px rgba(255,255,255,0.1); }
        
        .seat-map { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .seat-row { display: flex; gap: 10px; }
        .seat { width: 40px; height: 40px; background-color: #fff; border-radius: 5px; cursor: pointer; color: black; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; transition: 0.2s; }
        
        /* Trạng thái các loại ghế */
        .seat:hover:not(.booked) { transform: scale(1.1); background-color: #ffcc00; }
        .seat.selected { background-color: #e50914; color: white; border: 2px solid #fff; }
        .seat.booked { background-color: #555; color: #888; cursor: not-allowed; }
        
        .legend { display: flex; justify-content: center; gap: 20px; margin-top: 30px; }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .box { width: 20px; height: 20px; border-radius: 3px; }
        .box.available { background: #fff; }
        .box.selected { background: #e50914; }
        .box.booked { background: #555; }

        /* Cột bên phải: Thông tin thanh toán */
        .booking-summary { flex: 1; background: #1a1a1a; padding: 30px; border-radius: 10px; border: 1px solid #333; height: fit-content; }
        .booking-summary h3 { color: #e50914; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; }
        .info-line { margin-bottom: 15px; font-size: 15px; display: flex; justify-content: space-between;}
        .info-line span { color: #aaa; }
        .info-line b { color: #fff; }
        .total-price { font-size: 24px; color: #ffcc00; font-weight: bold; text-align: right; margin: 20px 0; }
        
        .btn-checkout { width: 100%; padding: 15px; background: #e50914; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        .btn-checkout:hover { background: #b20710; }
        .btn-checkout:disabled { background: #555; cursor: not-allowed; }
    </style>
</head>
<body>

    <header>
        <nav class="navbar" style="background: #000;">
            <div class="logo">5AE<span>SIUNHAN</span></div>
            <ul class="nav-links">
                <li><a href="chi_tiet_phim.php?id_phim=<?= $suat['phim_id'] ?>">← Trở lại</a></li>
            </ul>
        </nav>
    </header>

    <div class="booking-container">
        <div class="seat-selection">
            <h2 style="text-align: center; margin-bottom: 20px;">SƠ ĐỒ PHÒNG CHIẾU</h2>
            <div class="screen">MÀN HÌNH</div>
            
            <div class="seat-map">
                <?php
                // Tạo 5 hàng (A, B, C, D, E) và 8 cột
                $rows = ['A', 'B', 'C', 'D', 'E'];
                foreach ($rows as $row) {
                    echo "<div class='seat-row'>";
                    for ($col = 1; $col <= 8; $col++) {
                        $seat_id = $row . $col;
                        // Kiểm tra xem ghế này đã có trong mảng $ghe_da_dat chưa
                        $class = in_array($seat_id, $ghe_da_dat) ? 'seat booked' : 'seat available';
                        echo "<div class='$class' data-seat='$seat_id'>$seat_id</div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>

            <div class="legend">
                <div class="legend-item"><div class="box available"></div> Ghế trống</div>
                <div class="legend-item"><div class="box selected"></div> Đang chọn</div>
                <div class="legend-item"><div class="box booked"></div> Đã bán</div>
            </div>
        </div>

        <div class="booking-summary">
            <h3>THÔNG TIN ĐẶT VÉ</h3>
            <div class="info-line"><span>Phim:</span> <b><?= htmlspecialchars($suat['ten_phim']) ?></b></div>
            <div class="info-line"><span>Phòng chiếu:</span> <b><?= htmlspecialchars($suat['ten_phong']) ?></b></div>
            <div class="info-line"><span>Thời gian:</span> <b><?= date('H:i', strtotime($suat['gio_chieu'])) ?> | <?= date('d/m/Y', strtotime($suat['ngay_chieu'])) ?></b></div>
            <hr style="border: 0; border-top: 1px dashed #444; margin: 15px 0;">
            <div class="info-line"><span>Ghế đang chọn:</span> <b id="selected-seats-display" style="color: #ffcc00;">Chưa chọn</b></div>
            
            <div class="total-price" id="total-price-display">0 VNĐ</div>

            <form action="xu_ly_dat_ve.php" method="POST" id="booking-form">
                <input type="hidden" name="id_suat" value="<?= $id_suat ?>">
                <input type="hidden" name="danh_sach_ghe" id="hidden-seats-input" value="">
                <button type="submit" class="btn-checkout" id="btn-submit" disabled>THANH TOÁN NGAY</button>
            </form>
        </div>
    </div>

    <script>
        const seats = document.querySelectorAll('.seat.available');
        const displaySeats = document.getElementById('selected-seats-display');
        const displayPrice = document.getElementById('total-price-display');
        const hiddenInput = document.getElementById('hidden-seats-input');
        const btnSubmit = document.getElementById('btn-submit');
        
        const ticketPrice = <?= $suat['gia_ve'] ?>; // Lấy giá vé từ database
        let selectedSeatsArr = [];

        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                // Đổi hiệu ứng màu đỏ khi click
                seat.classList.toggle('selected');
                const seatId = seat.getAttribute('data-seat');
                
                // Thêm hoặc xóa ghế khỏi mảng
                if (seat.classList.contains('selected')) {
                    selectedSeatsArr.push(seatId);
                } else {
                    selectedSeatsArr = selectedSeatsArr.filter(id => id !== seatId);
                }
                
                // Cập nhật lên màn hình
                if (selectedSeatsArr.length > 0) {
                    displaySeats.innerText = selectedSeatsArr.join(', ');
                    hiddenInput.value = selectedSeatsArr.join(',');
                    btnSubmit.disabled = false; // Bật nút thanh toán
                } else {
                    displaySeats.innerText = 'Chưa chọn';
                    hiddenInput.value = '';
                    btnSubmit.disabled = true; // Tắt nút thanh toán
                }

                // Tính tổng tiền
                const totalPrice = selectedSeatsArr.length * ticketPrice;
                displayPrice.innerText = new Intl.NumberFormat('vi-VN').format(totalPrice) + ' VNĐ';
            });
        });
    </script>
</body>
</html>