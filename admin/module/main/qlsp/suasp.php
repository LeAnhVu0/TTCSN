<?php
// Lấy mã sản phẩm từ URL
$product_id = isset($_GET['MaSP']) ? $_GET['MaSP'] : null;

// Khởi tạo biến để lưu thông tin sản phẩm
$product = null;

// Nếu có mã sản phẩm, lấy thông tin sản phẩm từ cơ sở dữ liệu
if ($product_id) {
    $sql = "SELECT * FROM SanPham WHERE MaSP = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Xử lý cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];
    $product_sale_price = $_POST['product_sale_price'];
    $product_status = $_POST['product_status'];
    $product_brand = $_POST['product_brand'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = $_POST['product_description'];

    // Cập nhật thông tin sản phẩm
    $update_sql = "UPDATE SanPham SET TenSP=?, MaDM=?, Gia=?, GiaBan=?, TinhTrang=?, ThuongHieu=?, SoLuong=?, MoTa=? WHERE MaSP=?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("ssddsssis", $product_name, $product_category, $product_price, $product_sale_price, $product_status, $product_brand, $product_quantity, $product_description, $product_id);
    
    if ($stmt->execute()) {
        echo "<p>Cập nhật sản phẩm thành công.</p>";
    } else {
        echo "<p>Lỗi: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Lấy danh sách danh mục cho dropdown
$categories_sql = "SELECT MaDM, TenDM FROM DanhMucSP";
$categories_result = $mysqli->query($categories_sql);
?>

<h2>Sửa Sản Phẩm</h2>
<form action="" method="POST">
    <div class="form-group">
        <label for="product-name">Tên sản phẩm:</label>
        <input type="text" id="product-name" name="product_name" value="<?php echo $product['TenSP']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="product-category">Danh mục:</label>
        <select id="product-category" name="product_category" required>
            <?php
            while ($row = $categories_result->fetch_assoc()) {
                $selected = ($row['MaDM'] == $product['MaDM']) ? 'selected' : '';
                echo "<option value='" . $row['MaDM'] . "' $selected>" . $row['TenDM'] . "</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="product-price">Giá:</label>
        <input type="number" id="product-price" name="product_price" value="<?php echo $product['Gia']; ?>" step="0.01" required>
    </div>
    
    <div class="form-group">
        <label for="product-sale-price">Giá bán:</label>
        <input type="number" id="product-sale-price" name="product_sale_price" value="<?php echo $product['GiaBan']; ?>" step="0.01" required>
    </div>
    
    <div class="form-group">
        <label for="product-status">Tình trạng:</label>
        <input type="text" id="product-status" name="product_status" value="<?php echo $product['TinhTrang']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="product-brand">Thương hiệu:</label>
        <input type="text" id="product-brand" name="product_brand" value="<?php echo $product['ThuongHieu']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="product-quantity">Số lượng:</label>
        <input type="number" id="product-quantity" name="product_quantity" value="<?php echo $product['SoLuong']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="product-description">Mô tả:</label>
        <textarea id="product-description" name="product_description" required><?php echo $product['MoTa']; ?></textarea>
    </div>
    
    <button type="submit">Cập nhật sản phẩm</button>
</form>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h2 {
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 4px;
    }

    button:hover {
        opacity: 0.8;
    }
</style>

<?php
$mysqli->close();
?>