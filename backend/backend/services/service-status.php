<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ser_id = $_POST['ser_id'] ?? null;
    $ser_active = $_POST['ser_active'] ?? null;

    if ($ser_id && ($ser_active === 'yes' || $ser_active === 'no')) {
        $stmt = $conn->prepare("UPDATE services SET ser_active = ? WHERE ser_id = ?");
        $stmt->bind_param("si", $ser_active, $ser_id);
        $success = $stmt->execute();
        echo json_encode(["success" => $success]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>