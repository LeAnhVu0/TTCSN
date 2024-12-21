<?php
// Kết nối cơ sở dữ liệu
// Thêm kết nối đến cơ sở dữ liệu ở đây

// Kiểm tra nếu người dùng đã thực hiện thao tác duyệt hoặc hủy đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $orderId = $_POST['approve'];
        $update_sql = "UPDATE donhang SET TrangThai = '1' WHERE MaDH = $orderId";
        $resuilt=mysqli_query($mysqli,$update_sql);
    } elseif (isset($_POST['cancel'])) {
        $orderId = $_POST['cancel'];
        $update_sql = "UPDATE donhang SET TrangThai = '2' WHERE MaDH = $orderId";
        $resuilt=mysqli_query($mysqli,$update_sql);
    }
}
?>

<!-- HTML phần hiển thị bảng đơn hàng -->
<h2 class="status-title">Đơn Hàng Chờ Duyệt</h2>
<table>
    <thead>
        <tr>
            <th>Mã ĐH</th>
            <th>Mã Khách Hàng</th>
            <th>Tên Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Thời Gian Đặt</th>
            <th>Tổng Tiền</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM donhang JOIN khachhang ON donhang.MaKH = khachhang.MaKH WHERE trangthai = '0'";
        $resuilt = mysqli_query($mysqli, $sql);
        
        if ($resuilt && mysqli_num_rows($resuilt) > 0) {
            while ($row = mysqli_fetch_assoc($resuilt)) {
        ?>
                <tr>
                    <td><?php echo $row['MaDH']; ?></td>
                    <td><?php echo $row['MaKH']; ?></td>
                    <td><?php echo $row['TenKH']; ?></td>
                    <td><?php echo $row['SDT']; ?></td>
                    <td><?php echo $row['DiaCHiGiaoHang']; ?></td>
                    <td><?php echo $row['NgayDat']; ?></td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="approve" value="<?php echo $row['MaDH']; ?>" class="btn">Duyệt</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="cancel" value="<?php echo $row['MaDH']; ?>" class="btn cancel-btn">Hủy</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="Xem" value="<?php echo $row['MaDH']; ?>" class="btn xem-btn">Xem</button>
                        </form>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='8'>Không có đơn hàng chờ duyệt.</td></tr>";
        }
        ?>
    </tbody>
    
</table>
<?php 
include('xemchitietdonhang.php');
?>