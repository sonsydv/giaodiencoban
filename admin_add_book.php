<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng không phải admin, chuyển hướng đến trang chính
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];

    // Thêm sách mới vào cơ sở dữ liệu
    $sql = "INSERT INTO books (title, author, available) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $author);
    $stmt->execute();

    echo "Thêm sách thành công!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sách</title>
</head>
<body>
    <h2>Thêm Sách Mới</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Tên sách" required><br>
        <input type="text" name="author" placeholder="Tác giả" required><br>
        <button type="submit">Thêm sách</button>
    </form>
</body>
</html>
