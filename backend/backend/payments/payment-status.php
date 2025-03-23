<?php
header('Content-Type: application/json'); // ระบุประเภทของการตอบกลับเป็น JSON

require_once '../includes/conn.php';

if (isset($_POST['pay_id'], $_POST['new_status'])) {
    $pay_id = $_POST['pay_id'];
    $new_status = $_POST['new_status'];

    // อัปเดตสถานะใน payments
    $update_query = "UPDATE payments SET pay_status = ? WHERE pay_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $pay_id);

    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success', 'message' => 'อัปเดตสถานะสําเร็จ']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
}
