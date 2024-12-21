<?php
// Khởi tạo biến
$order = null;
$products = [];

// Kiểm tra nếu nút "Xem" được nhấn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Xem'])) {
    // Lấy mã đơn hàng từ giá trị button
    $orderId = $_POST['Xem'];

    // Truy vấn thông tin đơn hàng
    $sql = "SELECT donhang.MaDH, donhang.NgayDat, donhang.TongTien, donhang.Phivanchuyen, donhang.KhuyenMai, donhang.TrangThai,
                   khachhang.TenKH, khachhang.SoDienThoai, khachhang.DiaChi
            FROM donhang
            JOIN khachhang ON donhang.MaKH = khachhang.MaKH
            WHERE donhang.MaDH = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy thông tin đơn hàng.";
        exit;
    }
    $stmt->close();

    // Truy vấn danh sách sản phẩm trong đơn hàng
    $productSql = "SELECT sanpham.TenSP, chitietdonhang.SoLuong, sanpham.Gia
                   FROM chitietdonhang
                   JOIN sanpham ON chitietdonhang.MaSP = sanpham.MaSP
                   WHERE chitietdonhang.MaDH = ?";
    $productStmt = $mysqli->prepare($productSql);
    $productStmt->bind_param("i", $orderId);
    $productStmt->execute();
    $productResult = $productStmt->get_result();

    while ($product = $productResult->fetch_assoc()) {
        $products[] = $product;
    }
    $productStmt->close();
}
?>



<!-- Modal for Order Details -->
<div id="detail-modal" class="modal" style="display: <?php echo isset($order) ? 'block' : 'none'; ?>;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('detail-modal').style.display='none'">&times;</span>
        <h2>Chi Tiết Đơn Hàng</h2>
        <form>
            <label>Mã ĐH:</label>
            <p><?php echo isset($order['MaDH']) ? $order['MaDH'] : ''; ?></p>
            
            <label>Ngày Đặt:</label>
            <p><?php echo isset($order['NgayDat']) ? $order['NgayDat'] : ''; ?></p>
            
            <label>Tên Người Nhận:</label>
            <p><?php echo isset($order['TenKH']) ? $order['TenKH'] : ''; ?></p>
            
            <label>SĐT Người Nhận:</label>
            <p><?php echo isset($order['SoDienThoai']) ? $order['SoDienThoai'] : ''; ?></p>
            
            <label>Địa Chỉ Giao Hàng:</label>
            <p><?php echo isset($order['DiaChi']) ? $order['DiaChi'] : ''; ?></p>
            
            <label>Giá Trị Đơn Hàng:</label>
            <p><?php echo isset($order['TongTien']) ? number_format($order['TongTien'], 0, ',', '.') . ' VNĐ' : ''; ?></p>
            
            <label>Phí Vận Chuyển:</label>
            <p><?php echo isset($order['Phivanchuyen']) ? number_format($order['Phivanchuyen'], 0, ',', '.') . ' VNĐ' : ''; ?></p>
            
            <label>Khuyến Mãi:</label>
            <p><?php echo isset($order['KhuyenMai']) ? number_format($order['KhuyenMai'], 0, ',', '.') . ' VNĐ' : ''; ?></p>
            
            <label>Tổng Tiền:</label>
            <p><?php echo isset($order['TongTien']) ? number_format($order['TongTien'] + $order['Phivanchuyen'] - $order['KhuyenMai'], 0, ',', '.') . ' VNĐ' : ''; ?></p>

            <label>Khách Hàng Mã KH:</label>
            <p><?php echo isset($order['MaKH']) ? $order['MaKH'] : ''; ?></p>

            <h3>Danh Sách Sản Phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($products) {
                        foreach ($products as $product) {
                            $totalPrice = $product['Gia'] * $product['SoLuong'];
                            echo "<tr>
                                    <td>{$product['TenSP']}</td>
                                    <td>{$product['SoLuong']}</td>
                                    <td>" . number_format($product['Gia'], 0, ',', '.') . " VNĐ</td>
                                    <td>" . number_format($totalPrice, 0, ',', '.') . " VNĐ</td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<!-- JavaScript để hiển thị modal khi nhấn nút xem -->
<script>
    // Hiển thị modal khi nhấn nút xem
    <?php if (isset($_POST['Xem']) && !empty($order)): ?>
        document.getElementById('detail-modal').style.display = 'block';
    <?php endif; ?>

    // Đóng modal khi nhấn vào dấu x
    document.querySelector('.close').onclick = function() {
        document.getElementById('detail-modal').style.display = 'none';
    };
</script>

<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
