<?php
include 'includes/conn.php';

//แสดงจํานวน
$sql = "SELECT 
    (SELECT COUNT(cus_id) FROM customers) AS total_customers, 
    (SELECT COUNT(service_id) FROM services) AS total_services, 
    (SELECT COUNT(course_id) FROM courses) AS total_courses";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_customers = $row['total_customers'];
$total_services = $row['total_services'];
$total_courses = $row['total_courses'];
?>

<div class="container">
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">ภาพรวม</h6>
      </div>
    </div>

    <?php
    include 'widgets/widget-total.php';
    include 'widgets/widget-service-history.php';
    ?>
  </div>
</div>