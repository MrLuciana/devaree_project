<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

$course_id = $_POST['course_id'];
$new_status = $_POST['status'];

// สร้างคำสั่ง SQL
$stmt = $conn->prepare("UPDATE courses SET course_status = ? WHERE course_id = ?");
$stmt->bind_param("ii", $new_status, $course_id);

// ดำเนินการคำสั่ง SQL
if ($stmt->execute() === TRUE) {
    echo json_encode(["message" => "course status updated successfully"]);
} else {
    echo json_encode(["error" => "Error updating status: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>