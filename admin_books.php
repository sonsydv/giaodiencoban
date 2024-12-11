<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sách</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
    <?php
header('Content-Disposition: inline; filename="admin_books.php"');
?>

        <h1>Quản lý Sách - Hệ thống Quản lý Thư viện</h1>
    </header>

    <!-- Navigation -->
    <nav>
        <!-- Đảm bảo các liên kết này đúng file và không có thuộc tính "download" -->
        <a href="index.html">Trang chủ</a>
        <a href="admin_add_book.php">Thêm sách</a>
        <a href="admin_books">Quản lý Sách</a>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Danh sách sách</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kết nối cơ sở dữ liệu
                include('db.php'); 

                // Truy vấn danh sách sách
                $sql = "SELECT * FROM books";
                $result = $conn->query($sql);

                // Hiển thị dữ liệu sách
                if ($result->num_rows > 0) {
                    while ($book = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$book['book_id']}</td>";
                        echo "<td>{$book['title']}</td>";
                        echo "<td>{$book['author']}</td>";
                        echo "<td>
                                <a href='admin_edit_book.php?book_id={$book['book_id']}'>Sửa</a> | 
                                <a href='admin_delete_book.php?book_id={$book['book_id']}'>Xóa</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có sách nào trong hệ thống.</td></tr>";
                }

                // Đóng kết nối
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript -->
    <script src="script.js"></script>
</body>
</html>
