<?php
require_once('../includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price1 = isset($_POST['price1']) ? $_POST['price1'] : '';
    $price2 = isset($_POST['price2']) ? $_POST['price2'] : '';
    $price3 = isset($_POST['price3']) ? $_POST['price3'] : '';
    $cats_id = isset($_POST['cats_id']) ? $_POST['cats_id'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($code) || empty($name) || empty($price1) || empty($price2) || empty($price3) || empty($cats_id) || empty($description)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ตรวจสอบว่ารหัสไม่ซ้ำก่อนบันทึก
    $sqlCheck = "SELECT * FROM services WHERE service_code = ?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "รหัสบริการซ้ำ กรุณาลองใหม่"]);
        $stmt->close();
        exit;
    }
    $stmt->close();

    // ดำเนินการบันทึกข้อมูล
    $sqlInsert = "INSERT INTO services (service_code, service_name, service_price1, service_price2, service_price3, cats_id, service_description)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("ssdddss", $code, $name, $price1, $price2, $price3, $cats_id, $description);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "ไม่สามารถบันทึกข้อมูลได้"]);
    }
    $stmt->close();
}
$conn->close();
