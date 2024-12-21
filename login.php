<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Nhập</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: rgb(250, 248, 250); /* Màu nền tổng thể */
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; /* Chiều cao đầy đủ màn hình */
    }

    .login-container {
      background-color: #ffffff; /* Màu nền của ô đăng nhập */
      border-radius: 10px; /* Góc bo cho ô đăng nhập */
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Hiệu ứng bóng */
      padding: 40px; /* Khoảng trắng bên trong ô đăng nhập */
      width: 300px; /* Chiều rộng cố định */
    }

    h2 {
      text-align: center; /* Căn giữa tiêu đề */
      color: #3498db; /* Màu chữ tiêu đề */
      margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
    }

    .form-group {
      margin-bottom: 15px; /* Khoảng cách giữa các ô nhập */
    }

    label {
      display: block; /* Căn chỉnh label */
      margin-bottom: 5px; /* Khoảng cách dưới label */
      color: #333; /* Màu chữ label */
    }

    input[type="text"],
    input[type="password"] {
      width: 100%; /* Độ rộng 100% */
      padding: 10px; /* Khoảng cách trong ô nhập */
      border: 1px solid #ccc; /* Màu viền ô nhập */
      border-radius: 5px; /* Góc bo cho ô nhập */
      box-sizing: border-box; /* Đảm bảo padding không làm tăng chiều rộng */
    }

    button {
      background-color: #3498db; /* Màu nền nút ĐĂNG NHẬP */
      color: #ffffff; /* Màu chữ nút */
      border: none; /* Không có viền */
      padding: 10px; /* Khoảng cách trong nút */
      border-radius: 5px; /* Góc bo cho nút */
      cursor: pointer; /* Con trỏ khi hover */
      width: 100%; /* Độ rộng 100% */
      font-size: 16px; /* Kích thước chữ */
    }

    button:hover {
      background-color: #2980b9; /* Màu nền khi di chuột */
    }

    .register-link {
      text-align: center; /* Căn giữa liên kết đăng ký */
      margin-top: 15px; /* Khoảng cách trên liên kết */
      color: #555; /* Màu chữ liên kết */
    }

    .register-link a {
      color: #3498db; /* Màu chữ liên kết đăng ký */
      text-decoration: none; /* Không gạch chân liên kết */
    }

    .register-link a:hover {
      text-decoration: underline; /* Gạch chân khi hover */
    }
  </style>
</head>

<body>
  <?php
    include("./connection.php");
  ?>

  <div class="login-container">
    <h2>Đăng Nhập</h2>
    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Số điện thoại:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <?php
    if(isset($_POST["login"])) {
        $b = 1;
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username == "admin" || $password == "12345") {
            header("Location: admin/index.php");
            $b = 2;
        }
        $sql = "SELECT * FROM KhachHang WHERE SoDienThoai='$username' AND MatKhau='$password'"; 
        $result = $mysqli->query($sql);
        if($result->num_rows == 1) {
            header("Location: index.php");
            $b = 2;
        }
        if($b == 1) {
            echo "<p style='color: red; text-align: center;'>Tài khoản không chính xác</p>";
        }
    }
    $mysqli->close();
  ?>
      <button name="login" type="submit">Đăng Nhập</button>
    </form>
    <p class="register-link">Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
  </div>
</body>

</html>