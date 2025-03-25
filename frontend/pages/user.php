<?php

use chillerlan\QRCode\QRCode;
// Split the full name into parts
require_once('includes/conn.php');
$nameParts = explode(' ', $_SESSION['profile']->name);
$firstName = $nameParts[0] ?: '';
$lastName = $nameParts[1] ?: '';
$email = $_SESSION['profile']->email ?: '';
$lineID = $_SESSION['profile']->userId;

// Fetch user data from the database
$stmt = $conn->prepare("SELECT cus_fname, cus_lname, cus_gender, cus_birthdate, cus_phone, cus_email FROM customers WHERE cus_lineID = ?");
$stmt->bind_param("s", $lineID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $userData = $result->fetch_assoc();
} else {
  $userData = [];
}
?>

<head>
  <title>ข้อมูลลูกค้า : NK Wellness & Spa</title>
</head>

<body>
  <nav class="bg-primary text-center text-white py-2 sticky-top mb-4">
    <h4 class="m-0">ข้อมูลลูกค้า</h4>
  </nav>
  <section class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h4 class="m-0">เกี่ยวกับคุณ</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-auto d-flex justify-content-center"><img src="<?php echo htmlspecialchars($_SESSION['profile']->picture); ?>" alt="Profile Picture" width="100px" class="rounded mb-3 mb-md-0"></div>
          <div class="col-12 col-md-9">
            <h3 class="text-md-start text-center"><?php echo htmlspecialchars($userData['cus_fname'] . ' ' . $userData['cus_lname']); ?></h3>
            <p class="m-0">อีเมล: <?php echo htmlspecialchars($userData['cus_email'] ?: ''); ?></p>
            <p class="m-0">เบอร์โทร: <?php echo htmlspecialchars($userData['cus_phone'] ?: ''); ?></p>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <p class="m-0 small text-secondary">ID: <?php echo htmlspecialchars($_SESSION['profile']->userId); ?></p>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h4>ประวัติการใช้บริการ</h4>
      </div>
      <div class="card-body">
        <!-- Fetch and display the user's service history from the database -->
        <?php
        $stmt = $conn->prepare("SELECT bookings.boo_id, ser_name, boo_date, boo_res_time, boo_amount,pay_method, boo_status, pay_status 
        FROM bookings 
        INNER JOIN services ON bookings.ser_id = services.ser_id 
        LEFT JOIN payments ON bookings.boo_id = payments.boo_id 
        WHERE cus_id = ? 
        ORDER BY boo_date DESC, boo_res_time DESC");
        $stmt->bind_param("s", $_SESSION['profile']->cus_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="card mb-3">
              <div class="card-header">
                <h4 class="m-0"><?php echo htmlspecialchars($row['ser_name']); ?></h4>
              </div>
              <div class="card-body">
                <ul>
                  <li><i class="bi bi-calendar-fill me-2"></i><?php echo htmlspecialchars($row['boo_date']) . " - " . htmlspecialchars($row['boo_res_time']); ?></li>
                  <li><i class="bi bi-cash me-2"></i><?php echo htmlspecialchars($row['boo_amount']) . ' บาท'; ?></li>
                  <div>
                    <?php if ($row['boo_status'] == 'confirmed') { ?>
                      <!-- <li>หมายเลขการจอง: <span><?php echo htmlspecialchars($row['boo_id']); ?></span></li> -->
                      <li>ช่องทางการชำระ: <span><?php
                                                if ($row['pay_method'] == 'bank_transfer') echo 'โอนผ่านธนาคาร';
                                                else if ($row['pay_method'] == 'cash') echo 'เงินสด';
                                                else echo 'ไม่ทราบช่องทางการชำระ';
                                                ?></span></li>
                    <?php } ?>
                  </div>
                  <li>
                    <div id="status_display">
                      <span>สถานะ:</span>
                      <?php if ($row['boo_status'] == 'completed') {
                        echo '<span class="badge bg-success">เสร็จสิ้น</span>';
                      } else if ($row['boo_status'] == 'pending') {
                        echo '<span class="badge bg-warning text-dark">รอการยืนยัน</span>';
                      } else if ($row['boo_status'] == 'confirmed') {
                        echo '<span class="badge bg-primary">ยืนยันแล้ว</span>';
                      } else if ($row['boo_status'] == 'cancelled') {
                        echo '<span class="badge bg-danger">ยกเลิกแล้ว</span>';
                      } else {
                        echo '<span class="badge bg-secondary">ไม่ทราบสถานะ</span>';
                      } ?>
                    </div>
                  </li>
                  <?php if ($row['boo_status'] == 'confirmed') { ?>

                    <li id="payment_status"><span>สถานะการชำระเงิน:</span>
                      <?php
                      if ($row['pay_status'] == 'pending') {
                        echo '<span class="badge bg-warning text-dark">รอการชำระเงิน</span>';
                      } else if ($row['pay_status'] == 'paid') {
                        echo '<span class="badge bg-success">ชำระแล้ว</span>';
                      } else if ($row['pay_status'] == 'cancelled') {
                        echo '<span class="badge bg-danger">ยกเลิก</span>';
                      } else {
                        echo '<span class="badge bg-secondary">ไม่ทราบสถานะ</span>';
                      }
                      ?>
                    </li>
                  <?php } ?>
                </ul>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <?php if ($row['boo_status'] == 'pending') { ?>
                  <div id="booking_payment">
                    <div id="cancel_booking">
                      <button class="btn btn-danger" id="cancelButton" disabled aria-disabled="true">ยกเลิกการจอง</button>
                    </div>
                  <?php } else if ($row['boo_status'] == 'confirmed') { ?>
                    <div id="payment_status">
                      <button class="btn btn-primary" id="paymentButton" data-bs-toggle="modal" data-bs-target="#staticBackdrop">ชำระเงิน</button>
                    </div>

                  <?php } ?>
                  </div>
              </div>
            </div>
        <?php }
        } else {
          echo '<div class="alert alert-info m-0" role="alert">ยังไม่มีประวัติการใช้บริการ</div>';
        }
        ?>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h4>ตั้งค่าบัญชี</h4>
      </div>
      <div class="card-body">
        <div id="user-form">
          <div>
            <div class="form-floating mb-3">
              <input placeholder="ชื่อ (ภาษาไทย)" type="text" name="firstName" id="editUser_firstName" class="form-control">
              <label for="editUser_firstName">ชื่อ (ภาษาไทย)<span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="นามสกุล (ภาษาไทย)" type="text" name="lastName" id="editUser_lastName" class="form-control">
              <label for="editUser_lastName">นามสกุล (ภาษาไทย)<span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
              <select name="gender" id="editUser_gender" class="form-control">
                <option value="">---- เลือกเพศ ----</option>
                <option value="male">ชาย</option>
                <option value="female">หญิง</option>
                <option value="other">อื่นๆ</option>
              </select><label for="editUser_gender">เพศ<span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="วันเกิด" type="date" name="birthDate" id="editUser_birthDate" class="form-control">
              <label for="editUser_birthDate">วันเกิด <span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="เบอร์โทร" type="tel" name="phone" id="editUser_phone" maxlength="10" class="form-control">
              <label for="editUser_phone">เบอร์โทร<span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="อีเมล" type="email" name="email" id="editUser_email" class="form-control">
              <label for="editUser_email">อีเมล</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100">บันทึก</button>
        </div>
      </div>
    </div>
  </section>
  <?php include_once("includes/user/user-script.php"); ?>
</body>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">QRCode พร้อมเพย์</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $pp = new \KS\PromptPay();
        $target = '0656208219';
        echo '<img src="' . (new QRCode)->render($pp->generatePayload($target)) . '" alt="QR Code" />';
        ?>
        <p class="text-center">กรุณาชำระเงินจำนวน <strong>*** บาท</strong> ผ่าน QR Code ด้านบน</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">เสร็จสิ้น</button>
      </div>
    </div>
  </div>
</div>

<style>
  .card .card-header h4 {
    margin: 8px 0;
  }
</style>