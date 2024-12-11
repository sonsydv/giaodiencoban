<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng không phải admin, chuyển hướng đến trang chính
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit;
}

// Xóa sách
$book_id = $_GET['book_id'];
$sql = "DELETE FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();

echo "Xóa sách thành công!";
?>
