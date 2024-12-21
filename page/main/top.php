<!-- Top: Sidebar và Quảng cáo -->
<div class="top">
<div class="sidebar">
    <h2>Danh mục</h2>
    <ul class="list-sidebar">
        <?php
        // Kết nối đến cơ sở dữ liệu
        $sql = "SELECT * FROM danhmucsp"; 
        $result = mysqli_query($mysqli, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Tạo slug từ tên danh mục
                $categorySlug = strtolower(str_replace(' ', '-', $row['TenDM'])); 
                echo '<li><a href="index.php?quanly=' . $categorySlug . '&id=' . $row['MaDM'] . '">' . $row['TenDM'] . '</a></li>';
            }
        } else {
            echo "<li>Không có danh mục nào.</li>";
        }
        ?>
    </ul>
</div>
          <div class="ads">
            <div class="carousel">
              <img src="./images/banner1.png" alt="Quảng cáo 1" />
              <img src="./images/banner2.png" alt="Quảng cáo 2" />
              <img src="./images/banner3.png" alt="Quảng cáo 3" />
            </div>
          </div>
        </div>
