<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET boo_status = ? WHERE boo_id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }

    $stmt->close();
    $conn->close();
}
?>