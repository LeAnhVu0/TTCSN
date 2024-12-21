-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 21, 2024 lúc 10:13 PM
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
-- Cơ sở dữ liệu: `quanlybanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDH`, `MaSP`, `SoLuong`) VALUES
(3, 5, 3),
(3, 6, 1),
(4, 5, 3),
(4, 6, 4),
(5, 7, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuongtrinhkhuyenmai`
--

CREATE TABLE `chuongtrinhkhuyenmai` (
  `MaCTKM` int(11) NOT NULL,
  `TenCTKM` varchar(100) DEFAULT NULL,
  `ThoiGianBatDau` date DEFAULT NULL,
  `ThoiGianKetThuc` date DEFAULT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuongtrinhkhuyenmai_sanpham`
--

CREATE TABLE `chuongtrinhkhuyenmai_sanpham` (
  `MaCTKM` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucsp`
--

CREATE TABLE `danhmucsp` (
  `MaDM` int(11) NOT NULL,
  `TenDM` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucsp`
--

INSERT INTO `danhmucsp` (`MaDM`, `TenDM`, `MoTa`) VALUES
(61, 'Tivi', '123'),
(62, 'Điện thoại', 'không');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NgayDat` date DEFAULT NULL,
  `TenNguoiNhan` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaCHiGiaoHang` varchar(255) DEFAULT NULL,
  `NgayGiaoHang` date DEFAULT NULL,
  `GiaTriDH` double DEFAULT NULL,
  `PhiVanChuyen` double DEFAULT NULL,
  `KhuyenMai` double DEFAULT NULL,
  `TongTien` double DEFAULT NULL,
  `TrangThai` enum('0','1','2') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDH`, `MaKH`, `NgayDat`, `TenNguoiNhan`, `SDT`, `DiaCHiGiaoHang`, `NgayGiaoHang`, `GiaTriDH`, `PhiVanChuyen`, `KhuyenMai`, `TongTien`, `TrangThai`) VALUES
(1, 1, '2024-12-03', 'Vũ', '0931674365', 'Hà nội', '2024-12-20', 500000000, 12000, 20000, 122344444, '1'),
(2, 1, '2024-12-03', 'Tuấn', '091674365', 'Đống đa', '2024-12-06', 500000000, 12000, 20000, 433333333, '2'),
(3, 1, '2024-12-21', 'Nam', '0931674355', 'Việt Nam', NULL, 64000000, 15000, 0, 64015000, '2'),
(4, 8, '2024-12-21', 'Dương', '0931684166', 'Hà Nội', NULL, 94000000, 15000, 0, 94015000, '1'),
(5, 8, '2024-12-21', 'Anh Vũ', '0931674365', 'Đức Bác', NULL, 15000000, 15000, 0, 15015000, '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGioHang`) VALUES
(1),
(8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `TenKH` varchar(100) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `GioiTinh` char(1) DEFAULT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `MaGioHang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `DiaChi`, `SoDienThoai`, `GioiTinh`, `MatKhau`, `MaGioHang`) VALUES
(1, 'Vũ', 'Vinh Phúc', '0931674365', 'M', '123456', 1),
(8, 'Dương Triệu', 'Vinh Phúc ', '0392518010', NULL, '123', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieugiamgia`
--

CREATE TABLE `phieugiamgia` (
  `MaPGG` int(11) NOT NULL,
  `TenPGG` varchar(100) DEFAULT NULL,
  `GiaTriGiam` double NOT NULL,
  `NgayBatDau` date DEFAULT NULL,
  `NgayKetThuc` date DEFAULT NULL,
  `MaDH` int(11) DEFAULT NULL,
  `MaKH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `MaDM` int(11) DEFAULT NULL,
  `Gia` double NOT NULL,
  `GiaBan` double NOT NULL,
  `TinhTrang` varchar(50) NOT NULL,
  `HinhAnh` varchar(255) NOT NULL,
  `ThuongHieu` varchar(100) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MaDM`, `Gia`, `GiaBan`, `TinhTrang`, `HinhAnh`, `ThuongHieu`, `SoLuong`, `MoTa`) VALUES
(5, 'SamSung a16', 62, 20000000, 18000000, 'Mới', '../images/sanpham/samsung-a16.png', 'SamSung', 3, 'không'),
(6, 'xiaomi16', 62, 13000000, 10000000, 'mới', '../images/sanpham/xixaomi.png', 'androi', 2, 'không'),
(7, 'Smart Tivi Samsung UHD 4K 43 inch 2024 (43DU7700)', 61, 15000000, 15000000, 'Mới', '../images/sanpham/tivi.png', 'SamSung', 2, 'không'),
(8, 'Iphone16', 62, 15000000, 14000000, 'Mới', '../images/sanpham/samsung-a16.png', 'Iphone', 2, 'không');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham_giohang`
--

CREATE TABLE `sanpham_giohang` (
  `MaSP` int(11) NOT NULL,
  `MaGioHang` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtinsp`
--

CREATE TABLE `thongtinsp` (
  `MaSP` int(11) DEFAULT NULL,
  `MaThongTinSP` int(11) NOT NULL,
  `XuatXu` varchar(100) DEFAULT NULL,
  `ThongSoKT` varchar(100) DEFAULT NULL,
  `HuongDanSuDung` varchar(255) DEFAULT NULL,
  `ThongTinBaoHanh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDH`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `chuongtrinhkhuyenmai`
--
ALTER TABLE `chuongtrinhkhuyenmai`
  ADD PRIMARY KEY (`MaCTKM`);

--
-- Chỉ mục cho bảng `chuongtrinhkhuyenmai_sanpham`
--
ALTER TABLE `chuongtrinhkhuyenmai_sanpham`
  ADD PRIMARY KEY (`MaCTKM`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `danhmucsp`
--
ALTER TABLE `danhmucsp`
  ADD PRIMARY KEY (`MaDM`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD KEY `MaGioHang` (`MaGioHang`);

--
-- Chỉ mục cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  ADD PRIMARY KEY (`MaPGG`),
  ADD KEY `MaDH` (`MaDH`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDM` (`MaDM`);

--
-- Chỉ mục cho bảng `sanpham_giohang`
--
ALTER TABLE `sanpham_giohang`
  ADD PRIMARY KEY (`MaGioHang`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `thongtinsp`
--
ALTER TABLE `thongtinsp`
  ADD PRIMARY KEY (`MaThongTinSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chuongtrinhkhuyenmai`
--
ALTER TABLE `chuongtrinhkhuyenmai`
  MODIFY `MaCTKM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhmucsp`
--
ALTER TABLE `danhmucsp`
  MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  MODIFY `MaPGG` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `thongtinsp`
--
ALTER TABLE `thongtinsp`
  MODIFY `MaThongTinSP` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chuongtrinhkhuyenmai_sanpham`
--
ALTER TABLE `chuongtrinhkhuyenmai_sanpham`
  ADD CONSTRAINT `chuongtrinhkhuyenmai_sanpham_ibfk_1` FOREIGN KEY (`MaCTKM`) REFERENCES `chuongtrinhkhuyenmai` (`MaCTKM`),
  ADD CONSTRAINT `chuongtrinhkhuyenmai_sanpham_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaGioHang`) REFERENCES `giohang` (`MaGioHang`);

--
-- Các ràng buộc cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  ADD CONSTRAINT `phieugiamgia_ibfk_1` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`),
  ADD CONSTRAINT `phieugiamgia_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDM`) REFERENCES `danhmucsp` (`MaDM`);

--
-- Các ràng buộc cho bảng `sanpham_giohang`
--
ALTER TABLE `sanpham_giohang`
  ADD CONSTRAINT `sanpham_giohang_ibfk_1` FOREIGN KEY (`MaGioHang`) REFERENCES `giohang` (`MaGioHang`),
  ADD CONSTRAINT `sanpham_giohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `thongtinsp`
--
ALTER TABLE `thongtinsp`
  ADD CONSTRAINT `thongtinsp_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
