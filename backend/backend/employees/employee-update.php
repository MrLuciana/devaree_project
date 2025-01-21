<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$position = $_POST['position'];

$sql = "UPDATE employees SET 
        employee_fname = '$fname',
        employee_lname = '$lname',
        employee_email = '$email',
        employee_phone = '$phone',
        employee_position = '$position',
        WHERE employees.employee_id = '$id'";

$result = $conn->query($sql);
