<?php
include 'includes/conn.php';

//แสดงจํานวนผู้ใช้
$sql = "SELECT COUNT(id) AS total_users FROM customers";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];
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
    <div class="row">
      <!-- แสดงจํานวนผู้ใช้ -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Users</p>
                  <h4 class="card-title"><?php echo number_format($total_users); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- แสดงจํานวนผู้ใช้ -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Users</p>
                  <h4 class="card-title"><?php echo number_format($total_users); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>