<?php
session_start();
include("connection.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoTen = $_POST['ho_ten'];
    $soDienThoai = $_POST['so_dien_thoai'];
    $diachi = $_POST['diachi'];
    $matKhau = $_POST['mat_khau'];

    // Kiểm tra xem số điện thoại đã tồn tại chưa
    $sql = "SELECT * FROM khachhang WHERE SoDienThoai = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $soDienThoai);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Số điện thoại đã tồn tại. Vui lòng chọn số khác.";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO khachhang (TenKH, SoDienThoai, DiaChi, MatKhau) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $hoTen, $soDienThoai, $diachi, $matKhau);
        
        if ($stmt->execute()) {
            // Lấy ID của khách hàng mới
            $maKH = $mysqli->insert_id;

            // Tạo giỏ hàng mới cho khách hàng
            $sql = "INSERT INTO giohang (MaGioHang) VALUES (?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $maKH);
            if ($stmt->execute()) {
                // Lấy mã giỏ hàng vừa tạo
                $maGioHang = $mysqli->insert_id;

                // Gán mã giỏ hàng cho khách hàng (nếu cần thêm cột MaGioHang trong bảng khachhang)
                $sql = "UPDATE khachhang SET MaGioHang = ? WHERE MaKH = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ii", $maGioHang, $maKH);
                $stmt->execute();
                
                $message = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
            } else {
                $message = "Có lỗi xảy ra khi tạo giỏ hàng. Vui lòng thử lại.";
            }
            // Chuyển hướng đến trang đăng nhập
            header("Location: login.php");
            exit();
        } else {
            $message = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .registration-form {
            padding: 40px;
            max-width: 400px;
            margin: auto;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="registration-form">
        <h2>Đăng Ký Tài Khoản</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="ho_ten">Họ và Tên:</label>
                <input type="text" id="ho_ten" name="ho_ten" required>
            </div>
            <div class="form-group">
                <label for="so_dien_thoai">Số Điện Thoại:</label>
                <input type="text" id="so_dien_thoai" name="so_dien_thoai" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa Chỉ:</label>
                <input type="text" id="diachi" name="diachi" required>
            </div>
            <div class="form-group">
                <label for="mat_khau">Mật Khẩu:</label>
                <input type="password" id="mat_khau" name="mat_khau" required>
            </div>
            <button type="submit" class="btn">Đăng Ký</button>
        </form>
    </div>
</body>
</html>