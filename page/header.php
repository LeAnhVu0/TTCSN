<div class="header">
    <a href="index.php">
        <img class="logo" src="./images/logo.png" alt="logo" />
    </a>
    <div class="menu">
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li>
                <input type="text" placeholder="Bạn cần tìm gì?" />
                <button>Tìm kiếm</button>
            </li>
            <li><a href="giohang.php">Giỏ hàng</a></li>
            <?php
           if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

            if (isset($_SESSION['user_id'])) {
                $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Khách hàng';
            ?>
                <li>
                    <div class="dropdown">
                        <span><?php echo htmlspecialchars($username); ?></span>
                        <div class="dropdown-content">
                            <a href="quanlitaikhoan.php">Quản lý tài khoản</a>
                            <a href="quanlydonhang.php">Quản lý đơn hàng</a>
                            <a href="logout.php">Đăng xuất</a> <!-- Cập nhật liên kết ở đây -->
                        </div>
                    </div>
                </li>
            <?php
            } else {
            ?>
                <li><a href="login.php">Đăng nhập</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>

<style>
  .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none; /* Ẩn menu dropdown mặc định */
    position: absolute;
    background-color: pink;
    color: black;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    left: -80px;
}

.dropdown:hover .dropdown-content {
    display: block; /* Hiển thị menu khi hover vào dropdown */
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1; /* Thêm hiệu ứng hover cho các liên kết */
}
</style>