<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$code = $_POST['code'];
$name = $_POST['name'];
$price1 = $_POST['price1'];
$price2 = $_POST['price2'];
$price3 = $_POST['price3'];
$cat_id = $_POST['cat_id'];
$description = $_POST['description'];

$sql = "UPDATE services SET 
        ser_code = '$code',
        ser_name = '$name', 
        ser_price1 = '$price1',
        ser_price2 = '$price2',
        ser_price3 = '$price3',
        cat_id = '$cat_id', 
        ser_description = '$description' 
        WHERE services.ser_id = '$id'";

$result = $conn->query($sql);
