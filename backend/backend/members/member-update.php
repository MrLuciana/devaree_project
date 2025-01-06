<?php 
require_once('../includes/conn.php');
$id = $_POST['id'];
$title = $_POST['title'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pro_id = $_POST['pro_id'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "UPDATE member SET
         mem_title = '$title',
         mem_fname = '$fname',
         mem_lname = '$lname',
         pro_id = '$pro_id',
         mem_email = '$email',
         mem_password = '$password'
         WHERE member.mem_id = '$id'";
$result = $conn->query($sql);
