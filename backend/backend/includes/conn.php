<?php
$servername = "localhost";
$username = "root";
$password = "rootroot";
$database = "db_devaree";

$conn = mysqli_connect($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error()); // บันทึกข้อผิดพลาดลงไฟล์ log
    exit("Connection failed, please check the logs."); // แสดงข้อความทั่วไปในโปรดักชั่น
}
?>
