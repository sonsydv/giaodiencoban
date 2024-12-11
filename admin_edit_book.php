<?php
session_start();
include('../db.php');

// Kiểm tra nếu người dùng không phải admin, chuyển hướng đến trang chính
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.html');
    exit;
}

// Lấy thông tin sách cần sửa
$book_id = $_GET['book_id'];
$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];

    // Cập nhật thông tin sách
    $updateSql = "UPDATE books SET title = ?, author = ? WHERE book_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssi", $title, $author, $book_id);
    $stmt->execute();

    echo "Cập nhật sách thành công!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sách</title>
</head>
<body>
    <h2>Sửa Thông Tin Sách</h2>
    <form method="POST">
        <input type="text" name="title" value="<?= $book['title'] ?>" required><br>
        <input type="text" name="author" value="<?= $book['author'] ?>" required><br>
        <button type="submit">Cập nhật sách</button>
    </form>
</body>
</html>
