<?php session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maKhachHang = $_SESSION['user_id'];

// Lấy thông tin tài khoản
$sql = "SELECT * FROM khachhang WHERE MaKH = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maKhachHang);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Khởi tạo biến để tránh lỗi "Undefined array key"
$hoTen = '';
$soDienThoai = '';
$diachi = '';
$message = '';

if ($user) {
    $hoTen = htmlspecialchars($user['TenKH']);
    $soDienThoai = htmlspecialchars($user['SoDienThoai']);
    $diachi = htmlspecialchars($user['DiaChi']);
} else {
    $message = "Không tìm thấy thông tin tài khoản.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cập nhật thông tin tài khoản
    if (isset($_POST['update_account'])) {
        $hoTen = $_POST['ho_ten'];
        $soDienThoai = $_POST['so_dien_thoai'];
        $diachi = $_POST['diachi'];

        // Thực hiện cập nhật thông tin tài khoản
        $sql = "UPDATE khachhang SET TenKH = ?, SoDienThoai = ?, DiaChi = ? WHERE MaKH = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssi", $hoTen, $soDienThoai, $diachi, $maKhachHang);
        $stmt->execute();
        $message = "Cập nhật tài khoản thành công!";
        echo "<script>setTimeout(() => { window.location.href = 'quanlitaikhoan.php'; }, 500);</script>";
    }

    if (isset($_POST['change_password'])) {
        $matKhauCu = $_POST['mat_khau_cu'];
        $matKhauMoi = $_POST['mat_khau_moi'];

        // Kiểm tra mật khẩu cũ
        $sql = "SELECT MatKhau FROM khachhang WHERE MaKH = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $maKhachHang);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Kiểm tra nếu có người dùng và so sánh mật khẩu cũ
        if ($user && $user['MatKhau'] === $matKhauCu) {
            // Cập nhật mật khẩu mới
            $sql = "UPDATE khachhang SET MatKhau = ? WHERE MaKH = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $matKhauMoi, $maKhachHang);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $message = "Đổi mật khẩu thành công!";
                echo "<script>setTimeout(() => { window.location.href = 'quanlitaikhoan.php'; }, 500);</script>";
            } else {
                $message = "Có lỗi xảy ra trong quá trình đổi mật khẩu.";
            }
        } else {
            $message = "Mật khẩu cũ không đúng!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(250, 248, 250);
            margin: 0;
        }
        .account-management {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .message {
            color: green;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?php include("page/header.php"); ?>
    <div class="account-management">
        <h2>Cập Nhật Tài Khoản</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="ho_ten">Họ và Tên:</label>
                <input type="text" id="ho_ten" name="ho_ten" value="<?php echo $hoTen; ?>" required>
            </div>
            <div class="form-group">
                <label for="so_dien_thoai">Số Điện Thoại:</label>
                <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo $soDienThoai; ?>" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa Chỉ:</label>
                <input type="text" id="diachi" name="diachi" value="<?php echo $diachi; ?>" required>
            </div>
            <button type="submit" name="update_account" class="btn">Cập Nhật Tài Khoản</button>
        </form>

        <h2>Đổi Mật Khẩu</h2>
        <form method="POST">
            <div class="form-group">
                <label for="mat_khau_cu">Mật Khẩu Cũ:</label>
                <input type="password" id="mat_khau_cu" name="mat_khau_cu" required>
            </div>
            <div class="form-group">
                <label for="mat_khau_moi">Mật Khẩu Mới:</label>
                <input type="password" id="mat_khau_moi" name="mat_khau_moi" required>
            </div>
            <button type="submit" name="change_password" class="btn">Đổi Mật Khẩu</button>
        </form>
    </div>
    <?php include("page/footer.php"); ?>
</body>
</html>