<?php
// โหลด autoload.php เพื่อให้สามารถใช้ class ต่างๆ ที่ติดตั้งผ่าน Composer ได้
require_once __DIR__ . '/../../../vendor/autoload.php';

// สร้าง instance ของ Dotenv และระบุ path ของไฟล์ .env
// Load .env only in non-production environments
if (getenv('APP_ENV') !== 'production') {
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    } catch (\Dotenv\Exception\InvalidPathException $e) {
        echo $e->getMessage();
    }
}

$servername = $_ENV['DB_SERVERNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset('utf8');
// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error()); // บันทึกข้อผิดพลาดลงไฟล์ log
    exit("Connection failed, please check the logs." . mysqli_connect_error()); // แสดงข้อความทั่วไปในโปรดักชั่น
}
