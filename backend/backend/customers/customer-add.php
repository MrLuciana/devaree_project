<?php
require_once('../includes/conn.php');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบหรือไม่
    if (empty($fname) || empty($lname) || empty($gender) || empty($phone) || empty($email) || empty($birthdate) || empty($address)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    // ป้องกัน SQL Injection
    $fname = $conn->real_escape_string($fname);
    $lname = $conn->real_escape_string($lname);
    $gender = $conn->real_escape_string($gender);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);
    $birthdate = $conn->real_escape_string($birthdate);
    $address = $conn->real_escape_string($address);

    // SQL Insert
    $sql = "INSERT INTO customers (cus_fname, cus_lname, cus_gender, cus_phone, cus_email, cus_birthdate, cus_address)
            VALUES ('$fname', '$lname', '$gender', '$phone', '$email', '$birthdate', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
}
$conn->close();
