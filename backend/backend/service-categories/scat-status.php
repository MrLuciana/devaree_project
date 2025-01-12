<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

$scat_id = $_POST['scat_id'];
$new_status = $_POST['status'];

// สร้างคำสั่ง SQL
$stmt = $conn->prepare("UPDATE service_categories SET scat_status = ? WHERE scat_id = ?");
$stmt->bind_param("ii", $new_status, $scat_id);

// ดำเนินการคำสั่ง SQL
if ($stmt->execute() === TRUE) {
    echo json_encode(["message" => "Service status updated successfully"]);
} else {
    echo json_encode(["error" => "Error updating status: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>