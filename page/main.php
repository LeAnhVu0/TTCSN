<div id="main">
<div class="product-list">
    <?php
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
              <button class="product-rating">Thêm giỏ hàng</button>
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
