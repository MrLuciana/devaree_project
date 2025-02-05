<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pac_id = $_POST['pac_id'] ?? null;
    $pac_active = $_POST['pac_active'] ?? null;

    if ($pac_id && ($pac_active === 'yes' || $pac_active === 'no')) {
        $stmt = $conn->prepare("UPDATE packages SET pac_active = ? WHERE pac_id = ?");
        $stmt->bind_param("si", $pac_active, $pac_id);
        $success = $stmt->execute();
        echo json_encode(["success" => $success]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>