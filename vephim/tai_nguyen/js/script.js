// tai_nguyen/js/script.js

// 1. Quản lý đóng/mở Modal
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = "block";
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = "none";
}

// Đóng modal khi click ra vùng ngoài (vùng xám)
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}

// 2. Xử lý Đăng Nhập (Login) - Đã cập nhật điều hướng Admin bằng chữ
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageBox = document.getElementById('login-message');

        fetch('api/xu_ly_dang_nhap.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageBox.style.color = "#28a745";
                    messageBox.innerText = "Đăng nhập thành công!";
                    messageBox.style.display = "block";

                    setTimeout(() => {
                        // Kiểm tra vai trò bằng chữ 'admin' để điều hướng
                        if (data.vai_tro === 'admin') {
                            window.location.href = 'admin_ve_phim/admin.php';
                        } else {
                            window.location.href = 'index.php';
                        }
                    }, 800);
                } else {
                    messageBox.style.color = "#e50914";
                    messageBox.innerText = data.message;
                    messageBox.style.display = "block";
                }
            })
            .catch(error => console.error('Lỗi Login:', error));
    });
}

// 3. Xử lý Đăng Ký (Signup)
const signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageBox = document.getElementById('signup-message');

        fetch('api/xu_ly_dang_ky.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                messageBox.style.display = "block";
                if (data.status === 'success') {
                    messageBox.style.color = "#28a745";
                    messageBox.innerText = data.message;
                    setTimeout(() => {
                        closeModal('signupModal');
                        openModal('loginModal');
                        this.reset();
                    }, 2000);
                } else {
                    messageBox.style.color = "#e50914";
                    messageBox.innerText = "⚠ " + data.message;
                }
            })
            .catch(error => {
                messageBox.style.display = "block";
                messageBox.style.color = "#e50914";
                messageBox.innerText = "Lỗi kết nối Server!";
            });
    });
}

// 4. Fetch phim (Dùng để test dữ liệu)
const API_URL = "https://jsonplaceholder.typicode.com/posts";
async function fetchMovies() {
    try {
        console.log("Đang bắt đầu Fetch dữ liệu...");
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Lỗi mạng!");
        const data = await response.json();
        console.log("Dữ liệu nhận về thành công:", data);
    } catch (error) {
        console.error("Lỗi Fetch API:", error);
    }
}

// Khởi chạy hàm lấy dữ liệu khi trang tải xong
document.addEventListener("DOMContentLoaded", fetchMovies);