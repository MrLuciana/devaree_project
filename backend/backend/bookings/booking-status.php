<?php
require_once '../includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if ($_booVER['REQUEST_METHOD'] === 'POST') {
    $boo_id = $_POST['boo_id'] ?? null;
    $boo_active = $_POST['boo_active'] ?? null;

    if ($boo_id && ($boo_active === 'yes' || $boo_active === 'no')) {
        $stmt = $conn->prepare("UPDATE bookings SET boo_active = ? WHERE boo_id = ?");
        $stmt->bind_param("si", $boo_active, $boo_id);
        $success = $stmt->execute();
        echo json_encode(["success" => $success]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>