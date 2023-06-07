<?php
// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CodeAndPunch";

// Tạo kết nối tới MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Tạo bảng challenges trong database
$sql = "CREATE TABLE file (
    file_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    challenge_name VARCHAR(255) NOT NULL,
    description TEXT,
    answer VARCHAR(255),
    deadline DATETIME,
    file_path VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng challenges đã được tạo thành công";
} else {
    echo "Lỗi trong quá trình tạo bảng: " . $conn->error;
}

// Đóng kết nối
$conn->close();
?>
