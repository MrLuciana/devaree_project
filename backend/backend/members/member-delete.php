<?php 
require_once('../includes/conn.php');
$id = $_POST['id'];

$sql = "DELETE FROM member WHERE mem_id='$id' ";
      
$result = $conn->query($sql);