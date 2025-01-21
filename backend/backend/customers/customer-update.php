<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];

$sql = "UPDATE customers SET 
        customer_fname = '$fname',
        customer_lname = '$lname',
        customer_email = '$email',
        customer_phone = '$phone',
        customer_address = '$address',
        customer_city = '$city',
        WHERE customers.customer_id = '$id'";

$result = $conn->query($sql);
