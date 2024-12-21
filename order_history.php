<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maKhachHang = $_SESSION['user_id'];

// Lấy danh sách đơn hàng thành công của khách hàng
$sql = "SELECT * FROM donhang WHERE MaKH = ? AND TrangThai = '1' ORDER BY NgayDat DESC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maKhachHang);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đơn Hàng Thành Công</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .order-history {
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-back {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include("page/header.php"); ?>
    <div class="order-history">
        <h2>Lịch Sử Đơn Hàng Thành Công</h2>
        <a href="quanlydonhang.php" class="btn-back">Quay lại</a>
        <table>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tên Người Nhận</th>
                <th>Địa Chỉ</th>
                <th>Tổng Tiền</th>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $maDH = $row['MaDH'];
                    $ngayDat = $row['NgayDat'];
                    $tenNguoiNhan = htmlspecialchars($row['TenNguoiNhan']);
                    $diaChi = htmlspecialchars($row['DiaCHiGiaoHang']);
                    $tongTien = number_format($row['TongTien'], 0, ',', '.');
            ?>
                    <tr>
                        <td><?php echo $maDH; ?></td>
                        <td><?php echo $ngayDat; ?></td>
                        <td><?php echo $tenNguoiNhan; ?></td>
                        <td><?php echo $diaChi; ?></td>
                        <td><?php echo $tongTien; ?> VNĐ</td>
                    </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5'>Không có đơn hàng nào!</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php include("page/footer.php"); ?>
</body>
</html>