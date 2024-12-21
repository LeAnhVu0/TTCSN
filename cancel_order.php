<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

$maDH = $_GET['id'] ?? null;

if (!$maDH) {
    echo "Mã đơn hàng không hợp lệ!";
    exit();
}

// Kiểm tra trạng thái đơn hàng
$sql = "SELECT TrangThai FROM donhang WHERE MaDH = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maDH);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Đơn hàng không tồn tại!";
    exit();
}

// Kiểm tra trạng thái đơn hàng
var_dump($order['TrangThai']); // Kiểm tra trạng thái trước khi hủy
if ($order['TrangThai'] != '0') {
    echo "Không thể hủy đơn hàng đã xử lý hoặc đã hủy!";
    exit();
}

// Hủy đơn hàng
$sql = "UPDATE donhang SET TrangThai = '2' WHERE MaDH = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maDH);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        // Cập nhật thành công
    } else {
        echo "Không có đơn hàng nào được cập nhật!";
        exit();
    }
} else {
    echo "Lỗi khi cập nhật trạng thái: " . $stmt->error;
    exit();
}

// Chuyển hướng về trang quản lý đơn hàng
header('Location: quanlydonhang.php');
exit();
?>