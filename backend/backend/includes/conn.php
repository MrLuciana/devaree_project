<?php
$host_name = "localhost";
$user_name = "root";
$pass_word = "rootroot";
$db_name = "db_devaree";

// Create connection
$conn = new mysqli($host_name, $user_name, $pass_word, $db_name);
mysqli_set_charset($conn, "utf8");
date_default_timezone_set("Asia/Bangkok");