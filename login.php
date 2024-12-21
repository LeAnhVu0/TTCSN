<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Nhập</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: rgb(250, 248, 250);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 300px;
    }

    h2 {
      text-align: center;
      color: #3498db;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      background-color: #3498db;
      color: #ffffff;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }

    button:hover {
      background-color: #2980b9;
    }

    .register-link {
      text-align: center;
      margin-top: 15px;
      color: #555;
    }

    .register-link a {
      color: #3498db;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <?php
  session_start(); // Bắt đầu phiên
  include("./connection.php");

  if (isset($_POST["login"])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Truy vấn cơ sở dữ liệu
      $sql = "SELECT * FROM khachhang WHERE SoDienThoai='$username' AND MatKhau='$password'"; 
      $result = $mysqli->query($sql);
      
      if ($result && $result->num_rows == 1) {
          // Lưu thông tin người dùng vào session
          $user = $result->fetch_assoc();
          $_SESSION['user_id'] = $user['MaKH']; 
          $_SESSION['username'] = $user['TenKH'];
          header("Location: index.php");
          exit();
      }
      elseif($username == "admin" || $password == "12345") {

        header("Location: admin/index.php");
      }
      else {
          $error_message = "Tài khoản hoặc mật khẩu không chính xác.";
      }
  }

  $mysqli->close();
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
      <?php if (isset($error_message)): ?>
          <p class="error-message"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <button name="login" type="submit">Đăng Nhập</button>
    </form>
    <p class="register-link">Bạn chưa có tài khoản? <a href="dangkitaikhoan.php">Đăng ký</a></p>
  </div>
</body>

</html>