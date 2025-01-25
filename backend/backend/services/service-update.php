<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$code = $_POST['code'];
$name = $_POST['name'];
$price1 = $_POST['price1'];
$price2 = $_POST['price2'];
$price3 = $_POST['price3'];
$cats_id = $_POST['cats_id'];
$description = $_POST['description'];

$sql = "UPDATE services SET 
        service_code = '$code',
        service_name = '$name', 
        service_price1 = '$price1',
        service_price2 = '$price2',
        service_price3 = '$price3',
        cats_id = '$cats_id', 
        service_description = '$description' 
        WHERE services.service_id = '$id'";

$result = $conn->query($sql);
