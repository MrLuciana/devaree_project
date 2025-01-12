<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$sql = "UPDATE course_categories SET 
        course_cats_name = '$name', 
        course_cats_description = '$description' 
        WHERE course_categories.course_cats_id = '$id'";

$result = $conn->query($sql);
