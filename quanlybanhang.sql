CREATE DATABASE IF NOT EXISTS ShopDB;
USE ShopDB;

-- Bảng DanhMucSP
CREATE TABLE DanhMucSP (
    MaDM INT PRIMARY KEY AUTO_INCREMENT,
    TenDM VARCHAR(100) NOT NULL,
    MoTa TEXT
);

-- Bảng GioHang
CREATE TABLE GioHang (
    MaGioHang INT PRIMARY KEY AUTO_INCREMENT
);

-- Bảng SanPham
CREATE TABLE SanPham (
    MaSP INT PRIMARY KEY AUTO_INCREMENT,
    TenSP VARCHAR(100) NOT NULL,
    MaDM INT,
    Gia DOUBLE NOT NULL,
    GiaBan DOUBLE NOT NULL,
    TinhTrang VARCHAR(50) NOT NULL,
    HinhAnh VARCHAR(255) NOT NULL,
    ThuongHieu VARCHAR(100) NOT NULL,
    SoLuong INT NOT NULL,
    MoTa TEXT,
    FOREIGN KEY (MaDM) REFERENCES DanhMucSP(MaDM)
);

-- Bảng SanPham_GioHang
CREATE TABLE SanPham_GioHang (
    MaSP INT,
    MaGioHang INT,
    PRIMARY KEY (MaGioHang, MaSP),
    FOREIGN KEY (MaGioHang) REFERENCES GioHang(MaGioHang),
    FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP)
);

-- Bảng ThongTinSP
CREATE TABLE ThongTinSP (
    MaSP INT,
    MaThongTinSP INT PRIMARY KEY AUTO_INCREMENT,
    XuatXu VARCHAR(100),
    ThongSoKT VARCHAR(100),
    HuongDanSuDung VARCHAR(255),
    ThongTinBaoHanh VARCHAR(255),
    FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP)
);

-- Bảng ChuongTrinhKhuyenMai
CREATE TABLE ChuongTrinhKhuyenMai (
    MaCTKM INT PRIMARY KEY AUTO_INCREMENT,
    TenCTKM VARCHAR(100),
    ThoiGianBatDau DATE,
    ThoiGianKetThuc DATE,
    MoTa TEXT
);

-- Bảng ChuongTrinhKhuyenMai_SanPham
CREATE TABLE ChuongTrinhKhuyenMai_SanPham (
    MaCTKM INT,
    MaSP INT,
    PRIMARY KEY (MaCTKM, MaSP),
    FOREIGN KEY (MaCTKM) REFERENCES ChuongTrinhKhuyenMai(MaCTKM),
    FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP)
);

-- Bảng KhachHang
CREATE TABLE KhachHang (
    MaKH INT PRIMARY KEY AUTO_INCREMENT,
    TenKH VARCHAR(100) NOT NULL,
    DiaChi VARCHAR(255),
    SoDienThoai VARCHAR(15),
    GioiTinh CHAR(1),
    MatKhau VARCHAR(255),
    MaGioHang INT,
    FOREIGN KEY (MaGioHang) REFERENCES GioHang(MaGioHang)
);

-- Bảng DonHang
CREATE TABLE DonHang (
    MaDH INT PRIMARY KEY AUTO_INCREMENT,
    MaKH INT,
    NgayDat DATE,
    TenNguoiNhan VARCHAR(100),
    SDT VARCHAR(15),
    DiaCHiGiaoHang VARCHAR(255),
    NgayGiaoHang DATE,
    GiaTriDH DOUBLE,
    PhiVanChuyen DOUBLE,
    KhuyenMai DOUBLE,
    TongTien DOUBLE,
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH)
);

-- Bảng ChiTietDonHang
CREATE TABLE ChiTietDonHang (
    MaDH INT,
    MaSP INT,
    SoLuong INT NOT NULL,
    PRIMARY KEY (MaDH, MaSP),
    FOREIGN KEY (MaDH) REFERENCES DonHang(MaDH),
    FOREIGN KEY (MaSP) REFERENCES SanPham(MaSP)
);

-- Bảng PhieuGiamGia
CREATE TABLE PhieuGiamGia (
    MaPGG INT PRIMARY KEY AUTO_INCREMENT,
    TenPGG VARCHAR(100),
    GiaTriGiam DOUBLE NOT NULL,
    NgayBatDau DATE,
    NgayKetThuc DATE,
    MaDH INT,
    MaKH INT,
    FOREIGN KEY (MaDH) REFERENCES DonHang(MaDH),
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH)
);