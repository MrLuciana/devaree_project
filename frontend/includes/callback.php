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
$nameParts = explode(' ', $profile->name);
$firstName = isset($nameParts[0]) ? $nameParts[0] : '';
$lastName = isset($nameParts[1]) ? $nameParts[1] : '';
$email = isset($profile->email) ? $profile->email : null;

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
} else {
  echo "test user already exists";
}

$stmt = $conn->prepare("SELECT * FROM customers WHERE cus_lineID = ?");
$stmt->bind_param("s", $lineID);
$stmt->execute();
$result = $stmt->get_result();
$customerData = $result->fetch_assoc();

// Store customer data in session
$_SESSION['customer'] = $customerData;

// Store profile data in session
$_SESSION['profile'] = (object) array_merge((array) $_SESSION['profile'], $customerData);

if (empty($profile) || !is_array($profile)) {
  header('location: ../index.php');
  exit();
}

header('location: ../index.php');
exit();
