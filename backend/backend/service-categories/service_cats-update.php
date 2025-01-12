<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$sql = "UPDATE service_categories SET 
        service_cats_name = '$name', 
        service_cats_description = '$description' 
        WHERE service_categories.service_cats_id = '$id'";

$result = $conn->query($sql);
