<?php
require_once('../includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';

    // ตรวจสอบว่ามีค่า id ที่ส่งมาหรือไม่
    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ไม่พบรหัสบริการ"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $id = $conn->real_escape_string($id);

    // ตรวจสอบว่ามีข้อมูลนี้อยู่หรือไม่
    $checkSql = "SELECT * FROM employees WHERE emp_id = '$id'";
    $checkResult = $conn->query($checkSql);
    if ($checkResult->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "ไม่พบข้อมูลที่ต้องการลบ"]);
        exit;
    }

    // คำสั่งลบข้อมูล
    $sql = "DELETE FROM employees WHERE emp_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "ลบข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
?>
