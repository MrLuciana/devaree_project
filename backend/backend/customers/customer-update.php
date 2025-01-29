<?php
require_once('../includes/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $hire_date = isset($_POST['hire_date']) ? $_POST['hire_date'] : '';

    if (empty($id) || empty($fname) || empty($lname) || empty($gender) || empty($phone) || empty($email) || empty($hire_date)) {
        echo json_encode(["status" => "error", "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE customers SET cus_fname=?, cus_lname=?, cus_gender=?, cus_phone=?, cus_email=?, cus_hire_date=? WHERE cus_id=?");
    $stmt->bind_param("ssssssi", $fname, $lname, $gender, $phone, $email, $hire_date, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลสำเร็จ"]);
    } else {
        echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close(); 
}
