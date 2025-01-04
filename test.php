<?php
// รหัสผ่านที่ผู้ใช้กรอก
$password = "1234";

// สร้าง hash ของรหัสผ่าน
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// เช็คผลลัพธ์
echo $hashed_password;
?>
