<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$sql = "UPDATE service_categories SET 
        scat_name = '$name', 
        scat_description = '$description' 
        WHERE service_categories.scat_id = '$id'";

$result = $conn->query($sql);
