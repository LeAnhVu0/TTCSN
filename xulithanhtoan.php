<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maKhachHang = $_SESSION['user_id'];
$tenNguoiNhan = $_POST['full_name'];
$sdt = $_POST['phone'];
$diaChi = $_POST['address'];
$ngayDat = date('Y-m-d H:i:s'); // Lấy ngày giờ hiện tại
$phiVanChuyen = 15000;
$khuyenMai = 0;
$total = 0;

// Lấy thông tin giỏ hàng
$sql = "SELECT MaGioHang FROM khachhang WHERE MaKH = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maKhachHang);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$maGioHang = $row['MaGioHang'] ?? null;

if (!$maGioHang) {
    echo "Giỏ hàng không tồn tại!";
    exit();
}

// Lấy thông tin sản phẩm trong giỏ hàng
$sql = "SELECT sp.MaSP, sp.GiaBan, gh.SoLuong 
        FROM sanpham_giohang gh 
        JOIN sanpham sp ON gh.MaSP = sp.MaSP 
        WHERE gh.MaGioHang = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maGioHang);
$stmt->execute();
$result = $stmt->get_result();

$orderDetails = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $giaBan = $row['GiaBan'];
        $soLuong = $row['SoLuong'];
        $tongGia = $giaBan * $soLuong;
        $total += $tongGia;
        $orderDetails[] = [
            'MaSP' => $row['MaSP'],
            'SoLuong' => $soLuong
        ];
    }
} else {
    echo "Giỏ hàng trống!";
    exit();
}

$tongTien = $total + $phiVanChuyen - $khuyenMai;

// Thêm đơn hàng vào bảng donhang
$sql = "INSERT INTO donhang (MaKH, NgayDat, TenNguoiNhan, SDT, DiaCHiGiaoHang, GiaTriDH, PhiVanChuyen, KhuyenMai, TongTien, TrangThai) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '0')";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("issssddds", $maKhachHang, $ngayDat, $tenNguoiNhan, $sdt, $diaChi, $total, $phiVanChuyen, $khuyenMai, $tongTien);
$stmt->execute();
$maDH = $stmt->insert_id; // Lấy mã đơn hàng vừa thêm

// Thêm chi tiết đơn hàng vào bảng chitietdonhang
foreach ($orderDetails as $detail) {
    $sql = "INSERT INTO chitietdonhang (MaDH, MaSP, SoLuong) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $maDH, $detail['MaSP'], $detail['SoLuong']);
    $stmt->execute();
}

// Xóa giỏ hàng sau khi đặt hàng thành công
$sql = "DELETE FROM sanpham_giohang WHERE MaGioHang = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maGioHang);
$stmt->execute();

// Chuyển hướng đến trang quản lý đơn hàng
header('Location: quanlydonhang.php'); // Thay đổi đến trang quản lý đơn hàng
exit();
?>