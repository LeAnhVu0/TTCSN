<?php
session_start(); // Bắt đầu phiên

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maKhachHang = $_SESSION['user_id'];
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

$sql = "SELECT sp.TenSP, sp.GiaBan, gh.SoLuong 
        FROM sanpham_giohang gh 
        JOIN sanpham sp ON gh.MaSP = sp.MaSP 
        WHERE gh.MaGioHang = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maGioHang);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$phiVanChuyen = 15000;
$khuyenMai = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $giaBan = $row['GiaBan'];
        $soLuong = $row['SoLuong'];
        $tongGia = $giaBan * $soLuong;
        $total += $tongGia;
    }
} else {
    echo "<tr><td colspan='4'>Giỏ hàng trống!</td></tr>";
}

$tongTien = $total + $phiVanChuyen - $khuyenMai;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .payment {
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
        .form-group {
            margin-bottom: 20px;
        }
        .card-info {
            display: none; /* Ẩn thông tin thẻ mặc định */
        }
    </style>
</head>
<body>
    <?php include("page/header.php"); ?>
    <div class="payment">
        <h2>Thanh Toán</h2>
        <h3>Thông tin giỏ hàng</h3>
        <table>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Tổng Giá</th>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                mysqli_data_seek($result, 0); // Đặt con trỏ về đầu
                while ($row = mysqli_fetch_assoc($result)) {
                    $tenSP = $row['TenSP'];
                    $giaBan = $row['GiaBan'];
                    $soLuong = $row['SoLuong'];
                    $tongGia = $giaBan * $soLuong;
            ?>
                    <tr>
                        <td><?php echo $tenSP; ?></td>
                        <td><?php echo number_format($giaBan, 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo $soLuong; ?></td>
                        <td><?php echo number_format($tongGia, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='4'>Giỏ hàng trống!</td></tr>";
            }
            ?>
        </table>
        <div class="total-price">
            <p>Tổng Tiền: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</p>
            <p>Phí Vận Chuyển: <?php echo number_format($phiVanChuyen, 0, ',', '.'); ?> VNĐ</p>
            <p>Khuyến Mại: <?php echo number_format($khuyenMai, 0, ',', '.'); ?> VNĐ</p>
            <p>Tổng Cộng: <?php echo number_format($tongTien, 0, ',', '.'); ?> VNĐ</p>
        </div>

        <h3>Thông tin giao hàng</h3>
        <form method="POST" action="xulithanhtoan.php">
            <div class="form-group">
                <label for="full_name">Họ Tên:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="address">Địa Chỉ:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="text" id="phone" name="phone" required pattern="[0-9]{10,15}">
            </div>
            <div class="form-group">
                <label for="payment_method">Phương Thức Thanh Toán:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="credit_card">Thẻ tín dụng</option>
                </select>
            </div>
            <div class="form-group card-info" id="card_info">
                <label for="card_number">Số Thẻ:</label>
                <input type="text" id="card_number" name="card_number" placeholder="Nhập số thẻ tín dụng">
            </div>
            <button type="submit" name="xulithanhtoan">Xác Nhận Đơn Hàng</button>
        </form>
        <div class="continue-shopping">
            <a href="index.php">Tiếp tục mua sắm</a>
        </div>
    </div>
    <?php include("page/footer.php"); ?>

    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            var cardInfo = document.getElementById('card_info');
            if (this.value === 'credit_card') {
                cardInfo.style.display = 'block';
            } else {
                cardInfo.style.display = 'none';
            }
        });
    </script>
</body>
</html>