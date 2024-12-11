<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn phải đăng nhập để mượn sách!";
    exit;
}

// Tiếp tục xử lý mượn sách
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];

    // Kiểm tra xem sách có còn không
    $sql = "SELECT * FROM books WHERE book_id = ? AND available = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cập nhật trạng thái sách là đã mượn
        $updateSql = "UPDATE books SET available = 0 WHERE book_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        // Lưu vào lịch sử mượn sách
        $insertHistorySql = "INSERT INTO borrow_history (user_id, book_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertHistorySql);
        $stmt->bind_param("ii", $_SESSION['user_id'], $book_id);
        $stmt->execute();

        echo "Mượn sách thành công!";
    } else {
        echo "Sách không còn sẵn để mượn!";
    }
}
?>
