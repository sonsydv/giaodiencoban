<?php
session_start();
include('db.php');

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Bạn phải đăng nhập để trả sách!";
    exit;
}

// Tiếp tục xử lý trả sách
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $student_id = $_POST['student_id'];

    // Kiểm tra sách đã được mượn chưa
    $sql = "SELECT * FROM borrow_history WHERE book_id = ? AND user_id = ? AND return_date IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $book_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cập nhật trạng thái sách là có sẵn
        $updateSql = "UPDATE books SET available = 1 WHERE book_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        // Cập nhật ngày trả sách
        $updateHistorySql = "UPDATE borrow_history SET return_date = NOW() WHERE book_id = ? AND user_id = ? AND return_date IS NULL";
        $stmt = $conn->prepare($updateHistorySql);
        $stmt->bind_param("ii", $book_id, $student_id);
        $stmt->execute();

        echo "Trả sách thành công!";
    } else {
        echo "Không tìm thấy sách này trong lịch sử mượn!";
    }
}
?>
