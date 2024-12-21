<div id="main">

<div class="product-list">

<?php


        // Xử lý khi nhấn nút "Thêm giỏ hàng"
        if (isset($_POST['themgiohang'])) {
            // Kiểm tra xem người dùng có đăng nhập không
            if (!isset($_SESSION['user_id'])) { 
                header('Location: login.php');
                exit();
            }

            // Lấy ID sản phẩm từ request
            $idSanPham = $_POST['idSanPham'];
            $maKhachHang = $_SESSION['user_id']; // Lấy mã khách hàng từ session

            // Lấy mã giỏ hàng của khách hàng
            $sql = "SELECT MaGioHang FROM khachhang WHERE MaKH = $maKhachHang";
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();

            if ($row) {
                $maGioHang = $row['MaGioHang']; // Nếu đã có giỏ hàng
            } else {
                // Nếu chưa có giỏ hàng, tạo giỏ hàng mới
                $mysqli->query("INSERT INTO giohang () VALUES ()");
                $maGioHang = $mysqli->insert_id; // Lấy mã giỏ hàng mới
                // Cập nhật mã giỏ hàng vào bảng khách hàng
                $mysqli->query("UPDATE khachhang SET MaGioHang = $maGioHang WHERE MaKH = $maKhachHang");
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $checkProduct = $mysqli->query("SELECT * FROM sanpham_giohang WHERE MaSP = $idSanPham AND MaGioHang = $maGioHang");
            if ($checkProduct->num_rows > 0) {
                // Nếu sản phẩm đã có, cập nhật số lượng
                $mysqli->query("UPDATE sanpham_giohang SET SoLuong = SoLuong + 1 WHERE MaSP = $idSanPham AND MaGioHang = $maGioHang");
            } else {
                // Nếu chưa có sản phẩm, thêm mới vào giỏ hàng với số lượng là 1
                $mysqli->query("INSERT INTO sanpham_giohang (MaSP, MaGioHang, SoLuong) VALUES ($idSanPham, $maGioHang, 1)");
            }
        }


if(isset($_GET['quanly'])) {

$tam = $_GET['quanly'];

} else {

$tam = '';

}

if(isset($_GET['id'])) {
    $idDanhMuc = $_GET['id'];
} else {
    $idDanhMuc = '';
}

if($tam && $idDanhMuc) {
    // Truy vấn sản phẩm theo danh mục
    $sql = "SELECT * FROM sanpham WHERE MaDM = $idDanhMuc";
    $result = mysqli_query($mysqli, $sql);
    
    if($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $imagePath = str_replace('../', '', $row['HinhAnh']);
          ?>
          <div class="product-item">
          <div class="product-badge">Giảm 3%</div>
          <img src="<?php echo $imagePath; ?>" alt="<?php echo $row['TenSP']; ?>" class="product-image">
          <h3 class="product-title"><?php echo $row['TenSP']; ?></h3>
          <p class="product-price">
              <span class="discount-price"><?php echo number_format($row['GiaBan'], 0, ',', '.'); ?> VNĐ</span>
              <span class="original-price"><?php echo number_format($row['Gia'], 0, ',', '.'); ?> VNĐ</span>
          </p>
          <form method="POST" action="">
                        <input type="hidden" name="idSanPham" value="<?php echo $row['MaSP']; ?>">
                        <button class="product-rating" name="themgiohang">Thêm giỏ hàng</button>
                    </form>
      </div>
        <?php }
    } else {
        echo "<p>Không có sản phẩm nào trong danh mục này.</p>";
    } ?>
</div>

<?php

} else {

include("main/top.php");

include("main/index.php");

}

?>

</div>