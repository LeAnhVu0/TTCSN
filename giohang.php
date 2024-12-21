<?php
include("connection.php");
session_start(); // Bắt đầu phiên

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php');
    exit();
}

// Lấy mã giỏ hàng của khách hàng
$maKhachHang = $_SESSION['user_id']; 
$sql = "SELECT MaGioHang FROM khachhang WHERE MaKH = $maKhachHang";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$maGioHang = $row['MaGioHang'];

// Xử lý cập nhật số lượng sản phẩm trong giỏ hàng
if (isset($_POST['update_quantity']) && isset($_POST['quantities'])) {
    $newQuantities = $_POST['quantities']; // Mảng chứa số lượng mới
    foreach ($newQuantities as $maSP => $soLuong) {
        $soLuong = (int)$soLuong; // Chuyển đổi về kiểu số nguyên
        if ($soLuong > 0) {
            // Cập nhật số lượng sản phẩm
            $mysqli->query("UPDATE sanpham_giohang SET SoLuong = $soLuong WHERE MaSP = $maSP AND MaGioHang = $maGioHang");
        } else {
            // Nếu số lượng <= 0, có thể xóa sản phẩm khỏi giỏ hàng (tùy chọn)
            $mysqli->query("DELETE FROM sanpham_giohang WHERE MaSP = $maSP AND MaGioHang = $maGioHang");
        }
    }
}

// Lấy thông tin sản phẩm trong giỏ hàng
$sql = "SELECT sp.MaSP, sp.TenSP, sp.HinhAnh, sp.GiaBan, gh.SoLuong 
        FROM sanpham_giohang gh 
        JOIN sanpham sp ON gh.MaSP = sp.MaSP 
        WHERE gh.MaGioHang = $maGioHang";

$result = $mysqli->query($sql);

$total = 0; // Biến lưu tổng tiền
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .giohang {
            min-height: 500px;
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .continue-shopping {
            text-align: center;
            margin-top: 20px;
        }
        .continue-shopping a {
            text-decoration: none;
            color: #3498db;
        }
        .total-price {
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <?php include("page/header.php"); ?>
    <div class="giohang">
        <h2>Giỏ Hàng</h2>
        <form method="POST" action="">
            <table>
                <tr>
                    <th>Mã Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Hình Ảnh</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Tổng Giá</th>
                </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $maSP = $row['MaSP'];
                        $tenSP = $row['TenSP'];
                        $hinhAnh = str_replace('../', './', $row['HinhAnh']);
                        $giaBan = $row['GiaBan'];
                        $soLuong = $row['SoLuong'];
                        $tongGia = $giaBan * $soLuong;
                        $total += $tongGia; // Cộng dồn vào tổng tiền
                ?>
                        <tr>
                            <td><?php echo $maSP; ?></td>
                            <td><?php echo $tenSP; ?></td>
                            <td><img src="<?php echo $hinhAnh; ?>" alt="<?php echo $tenSP; ?>" style="width: 100px;"></td>
                            <td><?php echo number_format($giaBan, 0, ',', '.'); ?> VNĐ</td>
                            <td>
                                <input type="number" name="quantities[<?php echo $maSP; ?>]" value="<?php echo $soLuong; ?>" min="0">
                            </td>
                            <td><?php echo number_format($tongGia, 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6'>Giỏ hàng trống!</td></tr>";
                }
                ?>
            </table>
            <div class="total-price">
                <p>Tổng Tiền: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</p>
            </div>
            <div class="continue-shopping">
                <button type="submit" name="update_quantity">Cập Nhật Số Lượng</button>
                <a href="index.php" style="margin-left: 20px;">Tiếp tục mua sắm</a>
                <a href="thanhtoan.php" style="margin-left: 20px;">Thanh Toán</a>
            </div>
        </form>
    </div>
    <?php include("page/footer.php"); ?>
</body>
</html>