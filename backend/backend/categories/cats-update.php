<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE categories SET 
        cats_name = '$name',
        WHERE categories.cats_id = '$id'";

$result = $conn->query($sql);
