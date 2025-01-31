<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE categories SET 
        cat_name = '$name',
        WHERE categories.cat_id = '$id'";

$result = $conn->query($sql);
