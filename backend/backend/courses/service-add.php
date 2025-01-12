<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $scat_id = isset($_POST['scat_id']) ? $_POST['scat_id'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($name) || empty($description) || empty($price) || empty($scat_id)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $price = $conn->real_escape_string($price);
    $scat_id = $conn->real_escape_string($scat_id);

    // SQL Insert
    $sql = "INSERT INTO services (service_name, service_description, service_price, scat_id)
            VALUES ('$name', '$description', '$price', '$scat_id')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
?>
