<?php
session_start();

// Xử lý xóa tài khoản
if (isset($_GET['delete'])) {
    $maKH = (int)$_GET['delete'];
    $sql = "DELETE FROM khachhang WHERE MaKH = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $maKH);
    if ($stmt->execute()) {
        $message = "Xóa tài khoản thành công.";
    } else {
        $message = "Có lỗi xảy ra khi xóa tài khoản.";
    }
}

// Lấy danh sách khách hàng
$sql = "SELECT * FROM khachhang";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản - Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        a {
            color: rgb(0, 0, 0);
            text-decoration: none;
        }
        .btn {
            padding: 10px 15px;
            background-color: rgb(167, 185, 174);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Quản Lý Tài Khoản</h2>
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Mã Khách Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Địa Chỉ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['MaKH']; ?></td>
                    <td><?php echo $row['TenKH']; ?></td>
                    <td><?php echo $row['SoDienThoai']; ?></td>
                    <td><?php echo $row['DiaChi']; ?></td>
                    <td>
                        <a href="edit_account.php?id=<?php echo $row['MaKH']; ?>" class="btn sua">Sửa</a>
                        <a href="?delete=<?php echo $row['MaKH']; ?>" class="btn xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="admin_dashboard.php" class="btn">Quay lại Dashboard</a>
</body>
</html>