<?php
session_start();
require_once('conn.php');

// Check if the user is logged in
if (!isset($_SESSION['profile'])) {
  echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
  exit();
}

// Get the user ID from the session
$lineID = $_SESSION['profile']->userId;

// Get the form data
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$gender = $_POST['gender'] ?? '';
$birthDate = $_POST['birthDate'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';

// Sanitize the input data
$firstName = htmlspecialchars($firstName);
$lastName = htmlspecialchars($lastName);
$gender = htmlspecialchars($gender);
$phone = htmlspecialchars($phone);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$address = htmlspecialchars($address);

// Validate the input data (add more validation as needed)
if (empty($firstName) || empty($lastName) || empty($gender) || empty($phone) || empty($email) || empty($address)) {
  echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
  exit();
}

// Update the customer information in the database
$stmt = $conn->prepare("UPDATE customers SET cus_fname = ?, cus_lname = ?, cus_gender = ?, cus_birthdate = ?, cus_phone = ?, cus_email = ?, cus_address = ? WHERE cus_lineID = ?");
$stmt->bind_param("ssssssss", $firstName, $lastName, $gender, $birthDate, $phone, $email, $address, $lineID);

if ($stmt->execute()) {
  echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
}

$stmt->close();
$conn->close();
