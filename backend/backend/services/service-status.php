<?php
include '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$service_id = $_POST['service_id'];
$new_status = $_POST['status'];

// สร้างคำสั่ง SQL
$stmt = $conn->prepare("UPDATE services SET service_status = ? WHERE service_id = ?");
$stmt->bind_param("ii", $new_status, $service_id);

// ดำเนินการคำสั่ง SQL
if ($stmt->execute() === TRUE) {
    echo json_encode(["message" => "Service status updated successfully"]);
} else {
    echo json_encode(["error" => "Error updating status: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>