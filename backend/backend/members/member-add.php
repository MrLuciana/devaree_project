<?php 
require_once('../includes/conn.php');
$title = $_POST['title'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pro_id = $_POST['pro_id'];
$email = $_POST['email'];
$password = $_POST['password'];


$sql = "INSERT INTO member (mem_title, mem_fname, mem_lname, pro_id, mem_email, mem_password, mem_active)
VALUES ('$title', '$fname', '$lname', '$pro_id', '$email', '$password','Y')";
$result = $conn->query($sql);