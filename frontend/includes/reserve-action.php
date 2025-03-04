<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Include database connection
require_once 'conn.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Function to sanitize input data
function sanitize($data)
{
  global $conn;
  return mysqli_real_escape_string($conn, trim($data));
}

// Function to validate date format (YYYY-MM-DD)
function isValidDate($date)
{
  $d = DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}

// Function to validate time format (HH:MM)
function isValidTime($time)
{
  $t = DateTime::createFromFormat('H:i', $time);
  return $t && $t->format('H:i') === $time;
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // Get form data
    $customer_name = isset($_POST['customer_name']) ? sanitize($_POST['customer_name']) : '';
    $customer_phone = isset($_POST['customer_phone']) ? sanitize($_POST['customer_phone']) : '';
    $customer_email = isset($_POST['customer_email']) ? sanitize($_POST['customer_email']) : '';
    $line_user_id = isset($_POST['line_user_id']) ? sanitize($_POST['line_user_id']) : '';
    $ser_id = isset($_POST['ser_id']) ? intval($_POST['ser_id']) : 0;
    $reserve_date = isset($_POST['reserve_date']) ? sanitize($_POST['reserve_date']) : '';
    $reserve_time = isset($_POST['reserve_time']) ? sanitize($_POST['reserve_time']) : '';
    $duration = isset($_POST['duration']) ? intval($_POST['duration']) : 1;
    $special_requests = isset($_POST['special_requests']) ? sanitize($_POST['special_requests']) : '';

    // Validate required fields
    $errors = [];

    // Check if user is authenticated with LINE
    if (empty($line_user_id)) {
      $errors[] = "กรุณาเข้าสู่ระบบด้วย LINE ก่อนทำการจอง";
    }

    if (empty($customer_phone)) {
      $errors[] = "กรุณาเพิ่มเบอร์โทรศัพท์ในหน้าข้อมูลผู้ใช้ก่อนทำการจอง";
    } elseif (!preg_match('/^[0-9]{10}$/', $customer_phone)) {
      $errors[] = "เบอร์โทรศัพท์ไม่ถูกต้อง (ต้องเป็นตัวเลข 10 หลัก)";
    }

    if (empty($ser_id) || $ser_id <= 0) {
      $errors[] = "กรุณาเลือกบริการ";
    }

    if (empty($reserve_date) || !isValidDate($reserve_date)) {
      $errors[] = "กรุณาเลือกวันที่ให้ถูกต้อง";
    }

    if (empty($reserve_time) || !isValidTime($reserve_time)) {
      $errors[] = "กรุณาเลือกเวลาให้ถูกต้อง";
    }

    if ($duration <= 0) {
      $errors[] = "ระยะเวลาต้องมากกว่า 0";
    }

    // Check if service exists
    $service_query = "SELECT * FROM services WHERE ser_id = ? AND ser_active = 'yes'";
    $stmt = $conn->prepare($service_query);
    $stmt->bind_param("i", $ser_id);
    $stmt->execute();
    $service_result = $stmt->get_result();

    if ($service_result->num_rows === 0) {
      $errors[] = "ไม่พบบริการที่เลือก";
    }
    $stmt->close();

    // If there are validation errors, return error response
    if (!empty($errors)) {
      echo json_encode([
        'status' => 'error',
        'message' => implode(", ", $errors)
      ]);
      exit;
    }

    // Get customer ID from LINE user ID
    $customer_query = "SELECT cus_id FROM customers WHERE cus_lineID = ?";
    $stmt = $conn->prepare($customer_query);
    $stmt->bind_param("s", $line_user_id);
    $stmt->execute();
    $customer_result = $stmt->get_result();

    // Get customer ID
    if ($customer_result->num_rows > 0) {
      // Customer exists, get ID
      $customer_row = $customer_result->fetch_assoc();
      $cus_id = $customer_row['cus_id'];

      // Update customer information if needed
      if (!empty($customer_phone)) {
        $update_query = "UPDATE customers SET cus_phone = ? WHERE cus_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $customer_phone, $cus_id);
        $update_stmt->execute();
        $update_stmt->close();
      }

      if (!empty($customer_email)) {
        $update_query = "UPDATE customers SET cus_email = ? WHERE cus_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $customer_email, $cus_id);
        $update_stmt->execute();
        $update_stmt->close();
      }
    } else {
      // This should not happen as the user should already be in the database from LINE login
      // But just in case, create a new customer
      $name_parts = explode(' ', $customer_name, 2);
      $first_name = $name_parts[0];
      $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

      $insert_customer_query = "INSERT INTO customers (cus_lineID, cus_fname, cus_lname, cus_phone, cus_email) VALUES (?, ?, ?, ?, ?)";
      $insert_stmt = $conn->prepare($insert_customer_query);
      $insert_stmt->bind_param("sssss", $line_user_id, $first_name, $last_name, $customer_phone, $customer_email);
      $insert_stmt->execute();
      $cus_id = $insert_stmt->insert_id;
      $insert_stmt->close();
    }
    $stmt->close();

    // Calculate end time
    $start_datetime = new DateTime($reserve_date . ' ' . $reserve_time);
    $end_datetime = clone $start_datetime;
    $end_datetime->modify('+' . $duration . ' hours');
    $end_time = $end_datetime->format('H:i');

    // Get service price
    $service_query = "SELECT ser_price1 FROM services WHERE ser_id = ?";
    $stmt = $conn->prepare($service_query);
    $stmt->bind_param("i", $ser_id);
    $stmt->execute();
    $service_result = $stmt->get_result();
    $service_row = $service_result->fetch_assoc();
    $service_price = $service_row['ser_price1'];
    $stmt->close();

    // Calculate total price
    $total_price = $service_price * $duration;

    // Insert booking into database
    $booking_query = "INSERT INTO bookings (cus_id, ser_id, book_date, book_time_start, book_time_end, book_duration, book_price, book_note, book_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($booking_query);
    $stmt->bind_param("iisssiis", $cus_id, $ser_id, $reserve_date, $reserve_time, $end_time, $duration, $total_price, $special_requests);

    if ($stmt->execute()) {
      // Success
      echo json_encode([
        'status' => 'success',
        'message' => 'จองบริการสำเร็จ! ทางร้านจะติดต่อกลับเพื่อยืนยันการจองอีกครั้ง',
        'booking_id' => $stmt->insert_id
      ]);
    } else {
      // Database error
      throw new Exception("ไม่สามารถบันทึกการจองได้: " . $stmt->error);
    }
    $stmt->close();
  } catch (Exception $e) {
    // Handle exceptions
    error_log("Reservation Error: " . $e->getMessage());
    echo json_encode([
      'status' => 'error',
      'message' => 'เกิดข้อผิดพลาดในการจอง: ' . $e->getMessage()
    ]);
  }
} else {
  // Not a POST request
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method'
  ]);
}
