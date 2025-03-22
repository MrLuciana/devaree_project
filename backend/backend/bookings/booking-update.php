<?php
require_once('../includes/conn.php');

$id = $conn->real_escape_string($_POST['boo_id']);
$boo_notes = $conn->real_escape_string($_POST['boo_notes']);
$boo_date = $conn->real_escape_string($_POST['boo_date']);
$boo_res_time = $conn->real_escape_string($_POST['boo_res_time']);
$boo_method = $conn->real_escape_string($_POST['boo_method']);

$sql = "UPDATE bookings SET 
        boo_notes = '$boo_notes',
        boo_date = '$boo_date',
        boo_res_time = '$boo_res_time'
        boo_method = '$boo_method'
        WHERE boo_id = '$id'";  // ใช้ 'boo_id' ตามที่คุณต้องการ

if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลสำเร็จ"]);
} else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
}

$conn->close();
