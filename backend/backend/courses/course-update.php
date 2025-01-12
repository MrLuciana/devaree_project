<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$course_cats_id = $_POST['course_cats_id'];
$description = $_POST['description'];

$sql = "UPDATE courses SET 
        course_name = '$name', 
        course_price = '$price', 
        course_cats_id = '$course_cats_id', 
        course_description = '$description' 
        WHERE courses.course_id = '$id'";

$result = $conn->query($sql);
