<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $category = isset($_POST['catagory']) ? $_POST['catagory'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($name) || empty($description) || empty($price) || empty($category)) {
        die(json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]));
    }

    // ป้องกัน SQL Injection
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $price = $conn->real_escape_string($price);
    $category = $conn->real_escape_string($category);

    // SQL Insert
    $sql = "INSERT INTO services (service_name, service_description, service_price, service_category)
                VALUES ('$name', '$description', '$price', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
