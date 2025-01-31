<?php
require_once('../includes/conn.php');

header('Content-Type: application/json; charset=utf-8'); // กำหนด Content-Type เป็น JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // รับค่าจาก POST
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $price1 = isset($_POST['price1']) && is_numeric($_POST['price1']) ? (float)$_POST['price1'] : 0;
        $price2 = isset($_POST['price2']) && is_numeric($_POST['price2']) ? (float)$_POST['price2'] : 0;
        $price3 = isset($_POST['price3']) && is_numeric($_POST['price3']) ? (float)$_POST['price3'] : 0;
        $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        // ตรวจสอบค่าที่จำเป็น
        if (empty($code) || empty($name) || empty($description) || !filter_var($cat_id, FILTER_VALIDATE_INT)) {
            echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
            exit;
        }

        // ตรวจสอบรหัสแพ็กเกจซ้ำ
        $sqlCheck = "SELECT pac_code FROM packages WHERE pac_code = ?";
        $stmt = $conn->prepare($sqlCheck);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "รหัสแพ็กเกจซ้ำ กรุณาลองใหม่"]);
            $stmt->close();
            exit;
        }
        $stmt->close();

        // บันทึกข้อมูล
        $sqlInsert = "INSERT INTO packages (pac_code, pac_name, pac_price1, pac_price2, pac_price3, cat_id, pac_description)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("ssdddss", $code, $name, $price1, $price2, $price3, $cat_id, $description);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
        } else {
            echo json_encode(["status" => "error", "message" => "ไม่สามารถบันทึกข้อมูลได้"]);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
    }
}

$conn->close();
