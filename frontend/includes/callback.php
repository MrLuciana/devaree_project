<?php
session_start();
require_once('LineLogin.php');

$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error') || !property_exists($token, 'id_token')) {
  header('location: ../index.php');
  exit();
}

$profile = $line->profileFormIdToken($token);
$_SESSION['profile'] = $profile;

// Database integration
require_once('conn.php');

$lineID = $profile->userId;
$firstName = explode(' ', $profile->name)[0] ?? '';
$lastName = explode(' ', $profile->name)[1] ?? '';
$email = $profile->email ?? null;

// Check if user exists
$stmt = $conn->prepare("SELECT cus_lineID FROM customers WHERE cus_lineID = ?");
$stmt->bind_param("s", $lineID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  // Insert new user
  $stmt = $conn->prepare("INSERT INTO customers (cus_lineID, cus_fname, cus_lname, cus_email) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $lineID, $firstName, $lastName, $email);
  $stmt->execute();
}
else {
  echo "test user already exists";  
}


if (empty($profile) || !is_array($profile)) {
  header('location: ../index.php');
  exit();
}

header('location: ../index.php');
exit();
