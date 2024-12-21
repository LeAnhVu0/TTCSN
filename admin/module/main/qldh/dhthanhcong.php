<h2 class="status-title">Đơn Hàng Thành công</h2>
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
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM donhang JOIN khachhang ON donhang.MaKH = khachhang.MaKH WHERE trangthai = '1'";
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
                    <td><form method="POST" style="display: inline;">
                            <button type="submit" name="Xem" value="<?php echo $row['MaDH']; ?>" class="btn xem-btn">Xem</button>
                        </form></td>
            </tr>
            <?php }}?>
        </tbody>
    </table>
</div>
<?php 
include('xemchitietdonhang.php');
?>