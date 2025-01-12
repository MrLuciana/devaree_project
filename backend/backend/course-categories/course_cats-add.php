<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($name) || empty($description)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);

    // SQL Insert
    $sql = "INSERT INTO course_categories (course_cats_name, course_cats_description)
            VALUES ('$name', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
?>
