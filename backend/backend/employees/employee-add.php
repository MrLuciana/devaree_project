<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($fname) || empty($lname) || empty($position) || empty($phone) || empty($email)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $fname = $conn->real_escape_string($fname);
    $lname = $conn->real_escape_string($lname);
    $position = $conn->real_escape_string($position);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);

    // SQL Insert
    $sql = "INSERT INTO employees (employee_fname, employee_lname, employee_position, employee_phone, employee_email)
            VALUES ('$fname', '$lname', '$position', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
?>
