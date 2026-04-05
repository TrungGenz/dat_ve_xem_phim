-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 05, 2026 lúc 11:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_dat_ve_phim`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_ve`
--

CREATE TABLE `chi_tiet_ve` (
  `id_chi_tiet` int(11) NOT NULL,
  `id_dat_ve` int(11) DEFAULT NULL,
  `gia_ap_dung` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dat_ve`
--

CREATE TABLE `dat_ve` (
  `id_dat_ve` int(11) NOT NULL,
  `id_nguoi_dung` int(11) DEFAULT NULL,
  `id_suat_chieu` int(11) DEFAULT NULL,
  `ngay_dat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tong_tien` decimal(10,2) DEFAULT NULL,
  `id_khuyen_mai` int(11) DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ghe`
--

CREATE TABLE `ghe` (
  `id_ghe` int(11) NOT NULL,
  `id_phong` int(11) DEFAULT NULL,
  `so_ghe` varchar(10) DEFAULT NULL,
  `hang_ghe` varchar(10) DEFAULT NULL,
  `loai_ghe` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ghe_suat_chieu`
--

CREATE TABLE `ghe_suat_chieu` (
  `id` int(11) NOT NULL,
  `id_suat_chieu` int(11) DEFAULT NULL,
  `id_ghe` int(11) DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL,
  `hold_expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyen_mai`
--

CREATE TABLE `khuyen_mai` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mat_khau_hash` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `vai_tro` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phim`
--

CREATE TABLE `phim` (
  `id_phim` int(11) NOT NULL,
  `ten_phim` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `ngay_phat_hanh` date DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `poster_url` text DEFAULT NULL,
  `trailer_url` text DEFAULT NULL,
  `do_tuoi` varchar(10) DEFAULT NULL,
  `dao_dien` varchar(255) DEFAULT NULL,
  `dien_vien` text DEFAULT NULL,
  `ngon_ngu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phim_the_loai`
--

CREATE TABLE `phim_the_loai` (
  `id_phim` int(11) NOT NULL,
  `id_the_loai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong`
--

CREATE TABLE `phong` (
  `id_phong` int(11) NOT NULL,
  `id_rap` int(11) DEFAULT NULL,
  `ten_phong` varchar(100) DEFAULT NULL,
  `suc_chua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rap`
--

CREATE TABLE `rap` (
  `id_rap` int(11) NOT NULL,
  `ten_rap` varchar(255) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suat_chieu`
--

CREATE TABLE `suat_chieu` (
  `id_suat_chieu` int(11) NOT NULL,
  `id_phim` int(11) DEFAULT NULL,
  `ngay_chieu` datetime DEFAULT NULL,
  `hold_expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id_thanh_toan` int(11) NOT NULL,
  `id_dat_ve` int(11) DEFAULT NULL,
  `phuong_thuc` varchar(50) DEFAULT NULL,
  `so_tien` decimal(10,2) DEFAULT NULL,
  `ngay_giao_dich` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai`
--

CREATE TABLE `the_loai` (
  `id_the_loai` int(11) NOT NULL,
  `ten_the_loai` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_ve`
--
ALTER TABLE `chi_tiet_ve`
  ADD PRIMARY KEY (`id_chi_tiet`),
  ADD KEY `id_dat_ve` (`id_dat_ve`);

--
-- Chỉ mục cho bảng `dat_ve`
--
ALTER TABLE `dat_ve`
  ADD PRIMARY KEY (`id_dat_ve`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`),
  ADD KEY `id_suat_chieu` (`id_suat_chieu`),
  ADD KEY `id_khuyen_mai` (`id_khuyen_mai`);

--
-- Chỉ mục cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD PRIMARY KEY (`id_ghe`),
  ADD KEY `id_phong` (`id_phong`);

--
-- Chỉ mục cho bảng `ghe_suat_chieu`
--
ALTER TABLE `ghe_suat_chieu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_suat_chieu` (`id_suat_chieu`),
  ADD KEY `id_ghe` (`id_ghe`);

--
-- Chỉ mục cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `phim`
--
ALTER TABLE `phim`
  ADD PRIMARY KEY (`id_phim`);

--
-- Chỉ mục cho bảng `phim_the_loai`
--
ALTER TABLE `phim_the_loai`
  ADD PRIMARY KEY (`id_phim`,`id_the_loai`),
  ADD KEY `id_the_loai` (`id_the_loai`);

--
-- Chỉ mục cho bảng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`id_phong`),
  ADD KEY `id_rap` (`id_rap`);

--
-- Chỉ mục cho bảng `rap`
--
ALTER TABLE `rap`
  ADD PRIMARY KEY (`id_rap`);

--
-- Chỉ mục cho bảng `suat_chieu`
--
ALTER TABLE `suat_chieu`
  ADD PRIMARY KEY (`id_suat_chieu`),
  ADD KEY `id_phim` (`id_phim`);

--
-- Chỉ mục cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id_thanh_toan`),
  ADD KEY `id_dat_ve` (`id_dat_ve`);

--
-- Chỉ mục cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`id_the_loai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_tiet_ve`
--
ALTER TABLE `chi_tiet_ve`
  MODIFY `id_chi_tiet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dat_ve`
--
ALTER TABLE `dat_ve`
  MODIFY `id_dat_ve` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ghe`
--
ALTER TABLE `ghe`
  MODIFY `id_ghe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ghe_suat_chieu`
--
ALTER TABLE `ghe_suat_chieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phim`
--
ALTER TABLE `phim`
  MODIFY `id_phim` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phong`
--
ALTER TABLE `phong`
  MODIFY `id_phong` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rap`
--
ALTER TABLE `rap`
  MODIFY `id_rap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `suat_chieu`
--
ALTER TABLE `suat_chieu`
  MODIFY `id_suat_chieu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id_thanh_toan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  MODIFY `id_the_loai` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_ve`
--
ALTER TABLE `chi_tiet_ve`
  ADD CONSTRAINT `chi_tiet_ve_ibfk_1` FOREIGN KEY (`id_dat_ve`) REFERENCES `dat_ve` (`id_dat_ve`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `dat_ve`
--
ALTER TABLE `dat_ve`
  ADD CONSTRAINT `dat_ve_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `dat_ve_ibfk_2` FOREIGN KEY (`id_suat_chieu`) REFERENCES `suat_chieu` (`id_suat_chieu`),
  ADD CONSTRAINT `dat_ve_ibfk_3` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id`);

--
-- Các ràng buộc cho bảng `ghe`
--
ALTER TABLE `ghe`
  ADD CONSTRAINT `ghe_ibfk_1` FOREIGN KEY (`id_phong`) REFERENCES `phong` (`id_phong`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `ghe_suat_chieu`
--
ALTER TABLE `ghe_suat_chieu`
  ADD CONSTRAINT `ghe_suat_chieu_ibfk_1` FOREIGN KEY (`id_suat_chieu`) REFERENCES `suat_chieu` (`id_suat_chieu`) ON DELETE CASCADE,
  ADD CONSTRAINT `ghe_suat_chieu_ibfk_2` FOREIGN KEY (`id_ghe`) REFERENCES `ghe` (`id_ghe`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `phim_the_loai`
--
ALTER TABLE `phim_the_loai`
  ADD CONSTRAINT `phim_the_loai_ibfk_1` FOREIGN KEY (`id_phim`) REFERENCES `phim` (`id_phim`) ON DELETE CASCADE,
  ADD CONSTRAINT `phim_the_loai_ibfk_2` FOREIGN KEY (`id_the_loai`) REFERENCES `the_loai` (`id_the_loai`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `phong_ibfk_1` FOREIGN KEY (`id_rap`) REFERENCES `rap` (`id_rap`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `suat_chieu`
--
ALTER TABLE `suat_chieu`
  ADD CONSTRAINT `suat_chieu_ibfk_1` FOREIGN KEY (`id_phim`) REFERENCES `phim` (`id_phim`);

--
-- Các ràng buộc cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`id_dat_ve`) REFERENCES `dat_ve` (`id_dat_ve`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
