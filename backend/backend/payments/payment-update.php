<?php
require_once('../includes/conn.php');

// บันทึกการแก้ไข
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cus_id = $_POST['cus_id'];
        $emp_id = $_POST['emp_id'];
        $ser_id = $_POST['ser_id'];
        $pac_id = $_POST['pac_id'];
        $boo_date = $_POST['boo_date'];
        $boo_hours = $_POST['boo_hours'];
        $boo_start_time = $_POST['boo_start_time'];
        $boo_method = $_POST['boo_method'];
        $boo_notes = $_POST['boo_notes'];
    
        // คำนวณราคารวม
        $servicePrice = $_POST['service_price'];
        $packagePrice = $_POST['package_price'];
        $boo_total = $servicePrice + $packagePrice;
    
        $updateQuery = "UPDATE bookings SET 
            cus_id = ?, emp_id = ?, ser_id = ?, pac_id = ?, 
            boo_date = ?, boo_hours = ?, boo_start_time = ?, 
            boo_method = ?, boo_notes = ?, boo_total = ? 
            WHERE boo_id = ?";
    
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param(
            "iiiisissdii",
            $cus_id, $emp_id, $ser_id, $pac_id,
            $boo_date, $boo_hours, $boo_start_time,
            $boo_method, $boo_notes, $boo_total, $boo_id
        );
    
        if ($stmt->execute()) {
            echo "<script>alert('✅ แก้ไขข้อมูลสำเร็จ!');</script>";
            exit;
        } else {
            echo "<script>alert('❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
        }
    }
