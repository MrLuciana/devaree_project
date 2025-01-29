<?php
require_once('../includes/conn.php');

$id = $conn->real_escape_string($_POST['id']);
$code = $conn->real_escape_string($_POST['code']);
$name = $conn->real_escape_string($_POST['name']);
$price1 = $conn->real_escape_string($_POST['price1']);
$price2 = $conn->real_escape_string($_POST['price2']);
$price3 = $conn->real_escape_string($_POST['price3']);
$cat_id = $conn->real_escape_string($_POST['cat_id']);
$description = $conn->real_escape_string($_POST['description']);

$sql = "UPDATE services SET 
        ser_code = '$code',
        ser_name = '$name', 
        ser_price1 = '$price1',
        ser_price2 = '$price2',
        ser_price3 = '$price3',
        cat_id = '$cat_id', 
        ser_description = '$description' 
        WHERE ser_id = '$id'";  // ใช้ 'ser_id' ตามที่คุณต้องการ

if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลสำเร็จ"]);
} else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
}

$conn->close();
