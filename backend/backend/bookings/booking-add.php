<?php
require_once('../includes/conn.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// รับข้อมูล JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล JSON หรือ JSON ไม่ถูกต้อง']);
    exit;
}

// ดึงค่าจาก JSON
$cus_id = $data['cus_id'] ?? null;
$emp_id = $data['emp_id'] ?? null;
$ser_id = !empty($data['ser_id']) ? $data['ser_id'] : null;
$pac_id = !empty($data['pac_id']) ? $data['pac_id'] : null;
$boo_ser_hours = $data['boo_ser_hours'] ?? 0;
$boo_pac_hours = $data['boo_pac_hours'] ?? 0;
$boo_amount = $data['boo_amount'] ?? 0;
$boo_date = $data['boo_date'] ?? null;
$boo_res_time = $data['boo_res_time'] ?? null;
$boo_notes = $data['boo_notes'] ?? '';
$boo_method = $data['boo_method'] ?? '';

// ตรวจสอบค่าให้ถูกต้อง
if (!$cus_id || !$emp_id || (!$ser_id && !$pac_id) || !$boo_date || !$boo_res_time || !$boo_method) {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit;
}

// ใช้ Prepared Statement
$sql = "INSERT INTO bookings 
        (cus_id, emp_id, ser_id, pac_id, boo_date, boo_ser_hours, boo_pac_hours, boo_amount, boo_res_time, boo_notes, boo_method) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param(
        $stmt,
        "iiiisssssss",
        $cus_id,
        $emp_id,
        $ser_id,
        $pac_id,
        $boo_date,
        $boo_ser_hours,
        $boo_pac_hours,
        $boo_amount,
        $boo_res_time,
        $boo_notes,
        $boo_method
    );

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'จองสำเร็จ!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'SQL Prepare Failed: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
