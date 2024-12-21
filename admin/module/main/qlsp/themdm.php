<?php
// Thêm danh mục
if (isset($_POST['add-category'])) {
    $tendanhmuc = $_POST['category-name'];
    $mota = $_POST['category-description'];

    $sql = "INSERT INTO danhmucsp (TenDM, MoTa) VALUES ('$tendanhmuc', '$mota')";
    if ($mysqli->query($sql) === TRUE) {
        echo "Thêm thành công";
    } else {
        echo "Lỗi: " . $mysqli->error;
    }
}

// Cập nhật danh mục
if (isset($_POST['update-category'])) {
    $madm = $_POST['MaDM'];
    $tendanhmuc = $_POST['category-name'];
    $mota = $_POST['category-description'];

    $sql = "UPDATE danhmucsp SET TenDM='$tendanhmuc', MoTa='$mota' WHERE MaDM=$madm";
    if ($mysqli->query($sql) === TRUE) {
        echo "Cập nhật thành công";
    } else {
        echo "Lỗi: " . $mysqli->error;
    }
}

// Xóa danh mục
if (isset($_POST['delete-btn'])) {
    $madm = $_POST['delete-btn'];
    $sql = "DELETE FROM danhmucsp WHERE MaDM=$madm";
    if ($mysqli->query($sql) === TRUE) {
        echo "Xóa thành công";
    } else {
        echo "Lỗi: " . $mysqli->error;
    }
}
?>

<!-- Form thêm danh mục -->
<form method="POST">
    <h2>Quản lý Danh Mục Sản Phẩm</h2>
    <div class="form-group">
        <label for="category-name">Tên danh mục:</label>
        <input type="text" id="category-name" name="category-name" placeholder="Nhập tên danh mục" required>
    </div>
    <div class="form-group">
        <label for="category-description">Mô tả:</label>
        <input type="text" id="category-description" name="category-description" placeholder="Nhập mô tả" required>
    </div>
    <button id="add-category" name="add-category">Thêm danh mục</button>
</form>

<h3>Danh Sách</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên Danh Mục</th>
            <th>Mô Tả</th>
            <th>Thao Tác</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Lấy danh sách danh mục
    $sql = "SELECT * FROM danhmucsp";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
            <tr>
                <td><?php echo $row['MaDM']; ?></td>
                <td><?php echo $row['TenDM']; ?></td>
                <td><?php echo $row['MoTa']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <button name="edit-btn" value="<?php echo $row['MaDM']; ?>">Sửa</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <button name="delete-btn" value="<?php echo $row['MaDM']; ?>">Xóa</button>
                    </form>
                </td>
            </tr>
    <?php
        }
    } else {
        echo "Lỗi: " . mysqli_error($mysqli);
    }
    ?>
    </tbody>
</table>

<?php
// Hiển thị form sửa nếu nút Sửa được nhấn
if (isset($_POST['edit-btn'])) {
    $madm = $_POST['edit-btn'];
    $sql = "SELECT * FROM danhmucsp WHERE MaDM=$madm";
    $editResult = mysqli_query($mysqli, $sql);
    $editRow = mysqli_fetch_assoc($editResult);
    ?>
    <h2>Chỉnh Sửa Danh Mục</h2>
    <form method="POST">
        <input type="hidden" name="MaDM" value="<?php echo $editRow['MaDM']; ?>">
        <div class="form-group">
            <label for="category-name">Tên danh mục:</label>
            <input type="text" id="category-name" name="category-name" value="<?php echo $editRow['TenDM']; ?>" required>
        </div>
        <div class="form-group">
            <label for="category-description">Mô tả:</label>
            <input type="text" id="category-description" name="category-description" value="<?php echo $editRow['MoTa']; ?>" required>
        </div>
        <button name="update-category">Cập nhật</button>
    </form>
    <?php
}

$mysqli->close();
?>