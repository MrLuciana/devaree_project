<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$service_cats_id = $_POST['service_cats_id'];
$description = $_POST['description'];

$sql = "UPDATE services SET 
        service_name = '$name', 
        service_price = '$price', 
        service_cats_id = '$service_cats_id', 
        service_description = '$description' 
        WHERE services.service_id = '$id'";

$result = $conn->query($sql);
