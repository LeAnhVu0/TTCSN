<?php

// Lấy danh sách danh mục
$sql = "SELECT MaDM, TenDM FROM DanhMucSP";
$result = $mysqli->query($sql);

// Xử lý thêm sản phẩm
if (isset($_POST['add-product-button'])) {
    // Lấy dữ liệu từ form
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];
    $product_sale_price = $_POST['product_sale_price'];
    $product_status = $_POST['product_status'];
    $product_brand = $_POST['product_brand'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = $_POST['product_description'];

    // Xử lý hình ảnh
    $target_dir = "../images/sanpham/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    
    // Kiểm tra loại hình ảnh
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check === false) {
        die("Tập tin không phải là hình ảnh.");
    }

    // Di chuyển tập tin hình ảnh vào thư mục đã chỉ định
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Thêm sản phẩm vào cơ sở dữ liệu
        $sql = "INSERT INTO SanPham (TenSP, MaDM, Gia, GiaBan, TinhTrang, HinhAnh, ThuongHieu, SoLuong, MoTa) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssddsssis", $product_name, $product_category, $product_price, $product_sale_price, $product_status, $target_file, $product_brand, $product_quantity, $product_description);
        
        if ($stmt->execute()) {
            echo "<p>Sản phẩm đã được thêm thành công.</p>";
        } else {
            echo "<p>Lỗi: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Có lỗi khi tải lên hình ảnh.</p>";
    }
}

?>

<h2>Thêm Sản Phẩm</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="product-name">Tên sản phẩm:</label>
        <input type="text" id="product-name" name="product_name" placeholder="Nhập tên sản phẩm" required>
    </div>
    
    <div class="form-group">
        <label for="product-category">Danh mục:</label>
        <select id="product-category" name="product_category" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['MaDM'] . "'>" . $row['TenDM'] . "</option>";
                }
            } else {
                echo "<option value=''>Không có danh mục nào</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="product-price">Giá:</label>
        <input type="number" id="product-price" name="product_price" placeholder="Nhập giá" step="0.01" required>
    </div>
    
    <div class="form-group">
        <label for="product-sale-price">Giá bán:</label>
        <input type="number" id="product-sale-price" name="product_sale_price" placeholder="Nhập giá bán" step="0.01" required>
    </div>
    
    <div class="form-group">
        <label for="product-status">Tình trạng:</label>
        <input type="text" id="product-status" name="product_status" placeholder="Nhập tình trạng" required>
    </div>
    
    <div class="form-group">
        <label for="product-image">Hình ảnh:</label>
        <input type="file" id="product-image" name="product_image" accept="image/*" required>
    </div>
    
    <div class="form-group">
        <label for="product-brand">Thương hiệu:</label>
        <input type="text" id="product-brand" name="product_brand" placeholder="Nhập thương hiệu" required>
    </div>
    
    <div class="form-group">
        <label for="product-quantity">Số lượng:</label>
        <input type="number" id="product-quantity" name="product_quantity" placeholder="Nhập số lượng" required>
    </div>
    
    <div class="form-group">
        <label for="product-description">Mô tả:</label>
        <textarea id="product-description" name="product_description" placeholder="Nhập mô tả" required></textarea>
    </div>
    
    <button name="add-product-button" id="add-product-button">Thêm sản phẩm</button>
</form>
<?php
$mysqli->close();
?>