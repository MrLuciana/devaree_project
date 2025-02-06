<?php
require_once('../includes/conn.php');

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'JSON Error: ' . json_last_error_msg()]);
    exit;
}

if ($data) {
    $cus_id = $data['cus_id'];
    $emp_id = $data['emp_id'];
    $ser_id = $data['ser_id'];
    $pac_id = $data['pac_id'];
    $boo_date = $data['boo_date'];
    $boo_hours = $data['boo_hours'];
    $boo_start_time = $data['boo_start_time'];
    $boo_notes = $data['boo_notes'];
    $boo_amount = $data['boo_amount'];

    $sql = "INSERT INTO bookings (cus_id, emp_id, ser_id, pac_id, boo_date, boo_hours, boo_start_time, boo_notes, boo_amount)
            VALUES ('$cus_id', '$emp_id', '$ser_id', '$pac_id', '$boo_date', '$boo_hours', '$boo_start_time', '$boo_notes', '$boo_amount')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'จองสำเร็จ!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลที่ส่งมา']);
}

mysqli_close($conn);
