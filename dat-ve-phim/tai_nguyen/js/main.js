// 1. Khai báo URL API (Sau này lấy từ Nhất Duy)
const API_URL = "https://jsonplaceholder.typicode.com/posts"; // Dùng tạm link này để test Fetch

async function fetchMovies() {
  try {
    console.log("Đang bắt đầu Fetch dữ liệu...");
    const response = await fetch(API_URL);

    if (!response.ok) {
      throw new Error("Lỗi mạng, không lấy được dữ liệu!");
    }

    const data = await response.json();
    console.log("Dữ liệu nhận về thành công:", data);

    // Sau khi có dữ liệu, Lập sẽ viết hàm render ra HTML tại đây
    // renderMovies(data);
  } catch (error) {
    console.error("Lỗi Fetch API:", error);
  }
}

// Chạy hàm ngay khi trang load xong
document.addEventListener("DOMContentLoaded", fetchMovies);
