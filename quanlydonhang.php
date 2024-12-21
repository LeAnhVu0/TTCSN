<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maKhachHang = $_SESSION['user_id'];

// Lấy danh sách đơn hàng của khách hàng
$sql = "SELECT * FROM donhang WHERE MaKH = ? ORDER BY NgayDat DESC";
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
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .order-management {
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin:20px 0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            text-align: center;
        }
        .btn {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn.cancel {
            background-color: red;
        }
    </style>
</head>
<body>
    <?php include("page/header.php"); ?>
    <div class="order-management">
        <h2>Danh Sách Đơn Hàng</h2>
        <a href="order_history.php" class="btn">Lịch Sử Đơn Hàng </a>
        <table>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tên Người Nhận</th>
                <th>Địa Chỉ</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $maDH = $row['MaDH'];
                    $ngayDat = $row['NgayDat'];
                    $tenNguoiNhan = htmlspecialchars($row['TenNguoiNhan']);
                    $diaChi = htmlspecialchars($row['DiaCHiGiaoHang']);
                    $tongTien = number_format($row['TongTien'], 0, ',', '.');
                    $trangThai = '';
                    $huyDon = '';

                    switch ($row['TrangThai']) {
                        case 0:
                            $trangThai = 'Đang chờ duyệt';
                            $huyDon = '<a href="cancel_order.php?id=' . $maDH . '" class="btn cancel" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này?\');">Hủy Đơn</a>';
                            break;
                        case 1:
                            $trangThai = 'Thành công';
                            break;
                        case 2:
                            $trangThai = 'Đã hủy';
                            break;
                    }
            ?>
                    <tr>
                        <td><?php echo $maDH; ?></td>
                        <td><?php echo $ngayDat; ?></td>
                        <td><?php echo $tenNguoiNhan; ?></td>
                        <td><?php echo $diaChi; ?></td>
                        <td><?php echo $tongTien; ?> VNĐ</td>
                        <td><?php echo $trangThai; ?></td>
                        <td class="actions">
                            <a href="order_details.php?id=<?php echo $maDH; ?>" class="btn">Xem Chi Tiết</a>
                            <?php echo $huyDon; ?>
                        </td>
                    </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='7'>Không có đơn hàng nào!</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php include("page/footer.php"); ?>
</body>
</html>