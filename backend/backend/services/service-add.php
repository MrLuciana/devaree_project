<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $service_cats_id = isset($_POST['service_cats_id']) ? $_POST['service_cats_id'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($name) || empty($description) || empty($price) || empty($service_cats_id)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $price = $conn->real_escape_string($price);
    $service_cats_id = $conn->real_escape_string($service_cats_id);

    // SQL Insert
    $sql = "INSERT INTO services (service_name, service_description, service_price, service_cats_id)
            VALUES ('$name', '$description', '$price', '$service_cats_id')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
?>
