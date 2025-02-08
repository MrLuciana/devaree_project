<?php
header('Content-Type: application/json'); // ระบุประเภทของการตอบกลับเป็น JSON

require_once '../includes/conn.php';

if (isset($_POST['boo_id'], $_POST['new_status'])) {
    $boo_id = $_POST['boo_id'];
    $new_status = $_POST['new_status'];

    // อัปเดตสถานะใน bookings
    $update_query = "UPDATE bookings SET boo_status = ? WHERE boo_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $boo_id);

    if ($stmt->execute()) {
        // กรณีสถานะเป็น 'confirmed' -> สร้างข้อมูลการชำระเงิน
        if ($new_status == 'confirmed') {
            $amount_query = "SELECT boo_amount FROM bookings WHERE boo_id = ?";
            $amount_stmt = $conn->prepare($amount_query);
            $amount_stmt->bind_param("i", $boo_id);
            $amount_stmt->execute();
            $result = $amount_stmt->get_result();

            $pay_amount = 0;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pay_amount = $row['boo_amount'];
            }

            $pay_method = 'cash'; // วิธีการชำระเงินเริ่มต้น
            $pay_status = 'pending'; // สถานะการชำระเงินเริ่มต้น
            $pay_transaction_date = date('Y-m-d H:i:s'); // วันที่สร้างการชำระเงิน

            $insert_query = "INSERT INTO payments (boo_id, pay_amount, pay_method, pay_status, pay_transaction_date)
                             VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iisss", $boo_id, $pay_amount, $pay_method, $pay_status, $pay_transaction_date);
            $insert_stmt->execute();
        }

        // กรณีสถานะเป็น 'pending' -> ลบข้อมูลการชำระเงินที่เคยสร้าง
        if ($new_status == 'pending') {
            $delete_query = "DELETE FROM payments WHERE boo_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $boo_id);
            $delete_stmt->execute();
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตสถานะ']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
}
