<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    echo "Bạn phải đăng nhập để xem lịch sử!";
    exit;
}

$student_id = $_GET['student_id'];
$sql = "SELECT books.title AS book_title, borrow_history.borrow_date FROM borrow_history JOIN books ON borrow_history.book_id = books.book_id WHERE borrow_history.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

echo json_encode($history);
?>
