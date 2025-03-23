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

    if ($stmt->execute()) {
        // กรณีสถานะเป็น 'confirmed' -> สร้างข้อมูลการชำระเงิน
        if ($new_status == 'paid') {
            // ดึงข้อมูล pay_amount และ pay_method จาก payments
            $amount_method_query = "SELECT pay_amount, pay_method FROM payments WHERE pay_id = ?";
            $amount_method_stmt = $conn->prepare($amount_method_query);
            $amount_method_stmt->bind_param("i", $pay_id);
            $amount_method_stmt->execute();
            $result = $amount_method_stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pay_amount = $row['pay_amount'];
                $pay_method = $row['pay_method'];  // ดึงวิธีการชำระเงินจาก payments
            } else {
                // หากไม่พบข้อมูล ให้ส่ง error กลับ
                echo json_encode(['status' => 'error', 'message' => 'ไม่พบวิธีชำระเงิน']);
                exit;
            }
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตสถานะ']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
}
