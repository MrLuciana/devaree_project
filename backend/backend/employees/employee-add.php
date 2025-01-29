<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $hire_date = isset($_POST['hire_date']) ? $_POST['hire_date'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($fname) || empty($lname) || empty($gender) || empty($phone) || empty($email) || empty($hire_date)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $fname = $conn->real_escape_string($fname);
    $lname = $conn->real_escape_string($lname);
    $gender = $conn->real_escape_string($gender);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);
    $hire_date = $conn->real_escape_string($hire_date);

    // SQL Insert
    $sql = "INSERT INTO employees (emp_fname, emp_lname, emp_gender, emp_phone, emp_email, emp_hire_date)
            VALUES ('$fname', '$lname', '$gender', '$phone', '$email', '$hire_date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
