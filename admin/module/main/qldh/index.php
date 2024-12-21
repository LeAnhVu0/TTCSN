<h1>Quản Lý Đơn Hàng</h1>

<?php
// Kết nối cơ sở dữ liệu
// $mysqli là biến kết nối của bạn (thường được khai báo ở một nơi khác trong mã của bạn)
$dh_thanhcong = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM donhang WHERE TrangThai = '1'");
$dh_choduyet = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM donhang WHERE TrangThai = '0'");
$dh_tuchoi = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM donhang WHERE TrangThai = '2'");

// Lấy số lượng từ kết quả truy vấn
$thanhcong = mysqli_fetch_assoc($dh_thanhcong)['total'];
$choduyet = mysqli_fetch_assoc($dh_choduyet)['total'];
$tuchoi = mysqli_fetch_assoc($dh_tuchoi)['total'];

// Tính tổng doanh thu (ví dụ, tính theo tổng tiền của các đơn thành công)
$doanhthu = mysqli_query($mysqli, "SELECT SUM(TongTien) as total FROM donhang WHERE TrangThai = '1'");
$doanhthu_total = mysqli_fetch_assoc($doanhthu)['total'];
?>

<div class="summary">
    <a href="index.php?action=manage-orders&value=dhthanhcong">
        <div class="summary-item">
            <h3>Đơn Hàng Thành Công</h3>
            <p><?php echo $thanhcong; ?></p>
        </div>
    </a>
    <a href="index.php?action=manage-orders&value=duyetdh">
        <div class="summary-item">
            <h3>Đơn Hàng Chờ Duyệt</h3>
            <p><?php echo $choduyet; ?></p>
        </div>
    </a>
    <a href="index.php?action=manage-orders&value=huydh">
        <div class="summary-item">
            <h3>Đơn Hàng Từ Chối</h3>
            <p><?php echo $tuchoi; ?></p>
        </div>
    </a>
    <div class="summary-item">
        <h3>Tổng Doanh Thu</h3>
        <p><?php echo number_format($doanhthu_total, 0, ',', '.') . " VNĐ"; ?></p>
    </div>
</div>
