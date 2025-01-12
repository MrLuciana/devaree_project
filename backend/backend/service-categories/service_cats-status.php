<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

$service_cats_id = $_POST['service_cats_id'];
$new_status = $_POST['status'];

// สร้างคำสั่ง SQL
$stmt = $conn->prepare("UPDATE service_categories SET service_cats_status = ? WHERE service_cats_id = ?");
$stmt->bind_param("ii", $new_status, $service_cats_id);

// ดำเนินการคำสั่ง SQL
if ($stmt->execute() === TRUE) {
    echo json_encode(["message" => "Service status updated successfully"]);
} else {
    echo json_encode(["error" => "Error updating status: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>