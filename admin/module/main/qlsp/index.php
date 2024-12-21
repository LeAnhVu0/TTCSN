<style>
 /* Định dạng thẻ <a> */
 a {
        text-decoration: none;
        font-weight: 700;
        color: #007bff;
        transition: color 0.3s ease;
    }
    a:hover {
        color: #0056b3;
    }

    /* Định dạng tiêu đề */
    h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    /* Định dạng action-links */
    .action-links {
        margin-bottom: 20px;
    }
    .action-links a {
        margin-right: 15px;
        padding: 10px 15px;
        border: 1px solid #007bff;
        border-radius: 5px;
        background-color: #e9f5ff;
    }
    .action-links a:hover {
        background-color: #007bff;
        color: #fff;
    }

</style>
<h2>Quản Lý Sản Phẩm</h2>
<div class="action-links">
    <a href="index.php?action=manage-products&value=themsp">Thêm Sản Phẩm</a>
    <a href="index.php?action=manage-products&value=themdm">Quản Lý Danh Mục</a>
</div>

<?php
// Xử lý xóa sản phẩm
if (isset($_POST['delete-btn'])) {
    $product_id = $_POST['delete-btn'];
    $delete_sql = "DELETE FROM SanPham WHERE MaSP = ?";
    $stmt = $mysqli->prepare($delete_sql);
    $stmt->bind_param("s", $product_id);

    if ($stmt->execute()) {
        echo "<p>Sản phẩm đã được xóa thành công.</p>";
    } else {
        echo "<p>Lỗi: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Xử lý sửa sản phẩm
if (isset($_POST['edit-btn'])) {
    $product_id = $_POST['edit-btn'];

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM SanPham WHERE MaSP = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Sản phẩm không tồn tại.</p>";
        exit;
    }
    $stmt->close();

    // Hiển thị form chỉnh sửa
    ?>
    <h2>Chỉnh Sửa Sản Phẩm</h2>
    <form method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['MaSP']; ?>">

        <label for="product-name">Tên sản phẩm:</label>
        <input type="text" id="product-name" name="product_name" value="<?php echo htmlspecialchars($product['TenSP']); ?>" required>

        <label for="product-category">Danh mục:</label>
        <select id="product-category" name="product_category" required>
            <?php
            // Lấy danh sách danh mục
            $categories_sql = "SELECT MaDM, TenDM FROM DanhMucSP";
            $categories_result = $mysqli->query($categories_sql);
            while ($category = $categories_result->fetch_assoc()) {
                $selected = $product['MaDM'] == $category['MaDM'] ? 'selected' : '';
                echo "<option value='{$category['MaDM']}' $selected>{$category['TenDM']}</option>";
            }
            ?>
        </select>

        <label for="product-price">Giá:</label>
        <input type="number" id="product-price" name="product_price" value="<?php echo $product['Gia']; ?>" step="0.01" required>

        <label for="product-sale-price">Giá bán:</label>
        <input type="number" id="product-sale-price" name="product_sale_price" value="<?php echo $product['GiaBan']; ?>" step="0.01" required>

        <label for="product-status">Tình trạng:</label>
        <input type="text" id="product-status" name="product_status" value="<?php echo $product['TinhTrang']; ?>" required>

        <label for="product-quantity">Số lượng:</label>
        <input type="number" id="product-quantity" name="product_quantity" value="<?php echo $product['SoLuong']; ?>" required>

        <label for="product-description">Mô tả:</label>
        <textarea id="product-description" name="product_description" required><?php echo htmlspecialchars($product['MoTa']); ?></textarea>

        <button type="submit" name="update-btn">Cập nhật sản phẩm</button>
        <a href="index.php?action=manage-products">Quay lại</a>
    </form>
    <?php
}

// Cập nhật sản phẩm
if (isset($_POST['update-btn'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];
    $product_sale_price = $_POST['product_sale_price'];
    $product_status = $_POST['product_status'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = $_POST['product_description'];

    // Cập nhật thông tin sản phẩm
    $update_sql = "UPDATE SanPham SET TenSP=?, MaDM=?, Gia=?, GiaBan=?, TinhTrang=?, SoLuong=?, MoTa=? WHERE MaSP=?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("ssddssis", $product_name, $product_category, $product_price, $product_sale_price, $product_status, $product_quantity, $product_description, $product_id);

    if ($stmt->execute()) {
        echo "<p>Cập nhật sản phẩm thành công.</p>";
    } else {
        echo "<p>Lỗi: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Lấy danh sách sản phẩm
$sql = "SELECT sp.MaSP, sp.TenSP, dm.TenDM, sp.Gia, sp.GiaBan, sp.TinhTrang, sp.HinhAnh, sp.SoLuong, sp.MoTa 
        FROM SanPham sp 
        JOIN DanhMucSP dm ON sp.MaDM = dm.MaDM";
$result = $mysqli->query($sql);
?>

<table>
    <thead>
        <tr>
            <th>Mã Sản Phẩm</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá</th>
            <th>Giá Bán</th>
            <th>Tình Trạng</th>
            <th>Hình Ảnh</th>
            <th>Số Lượng</th>
            <th>Mô Tả</th>
            <th>Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo $row['MaSP']; ?></td>
                    <td><?php echo $row['TenSP']; ?></td>
                    <td><?php echo $row['TenDM']; ?></td>
                    <td><?php echo number_format($row['Gia'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo number_format($row['GiaBan'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo $row['TinhTrang']; ?></td>
                    <td><img src="<?php echo $row['HinhAnh']; ?>" alt="<?php echo $row['TenSP']; ?>" style="width: 50px; height: 50px;"></td>
                    <td><?php echo $row['SoLuong']; ?></td>
                    <td><?php echo $row['MoTa']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <button name="edit-btn" value="<?php echo $row['MaSP']; ?>" class="action-btn">Sửa</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <button name="delete-btn" value="<?php echo $row['MaSP']; ?>" class="action-btn delete-btn">Xóa</button>
                        </form>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='10'>Không có sản phẩm nào.</td></tr>";
        }

        $mysqli->close();
        ?>
    </tbody>
</table>
