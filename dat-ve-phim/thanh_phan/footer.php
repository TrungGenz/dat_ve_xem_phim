<footer style="background: #222; color: white; text-align: center; padding: 20px; margin-top: 50px;">
    <p>&copy; 2026 Rạp Phim Duy Noob - Đồ án Công nghệ Thông tin QNU</p>
    <p>Địa chỉ: 170 An Dương Vương, Quy Nhơn, Bình Định</p>
</footer>
<footer style="text-align: center; padding: 30px; background: #1a1a1a; color: #888; border-top: 1px solid #333;">
        <p>&copy; 2026 <strong>QNU Cinema</strong> - Thiết kế bởi Nhóm 5 (Lập - Duy - Trung - Đài)</p>
        <p style="font-size: 12px;">Đồ án môn học Phát triển ứng dụng Web</p>
    </footer>

    <script>
        // Hàm này để mở cái khung Đăng nhập/Đăng ký khi bấm nút
        function openModal(id) {
            document.getElementById(id).style.display = "block";
        }

        // Hàm này để đóng khung khi bấm dấu X
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Nếu người dùng bấm ra ngoài cái khung thì cũng tự đóng luôn
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>