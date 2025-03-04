<?php
// Split the full name into parts
require_once('includes/conn.php');
$nameParts = explode(' ', $_SESSION['profile']->name);
$firstName = $nameParts[0] ?: '';
$lastName = $nameParts[1] ?: '';
$email = $_SESSION['profile']->email ?: '';
$lineID = $_SESSION['profile']->userId;

// Fetch user data from the database
$stmt = $conn->prepare("SELECT cus_fname, cus_lname, cus_gender, cus_birthdate, cus_phone, cus_email, cus_address FROM customers WHERE cus_lineID = ?");
$stmt->bind_param("s", $lineID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $userData = $result->fetch_assoc();
} else {
  $userData = [];
}
?>

<body>
  <section class="container mt-2">
    <h1>หน้าข้อมูลผู้ใช้</h1>
    <p>แสดงรายละเอียดบัญชีผู้ใช้ / ประวัติการใช้บริการ</p>
    <div class="card">
      <div class="card-header">
        <h4 class="m-0">เกี่ยวกับคุณ</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-auto d-flex justify-content-center"><img src="<?php echo htmlspecialchars($_SESSION['profile']->picture); ?>" alt="Profile Picture" width="100px" class="rounded mb-3"></div>
          <div class="col-12 col-md-9">
            <h3 class="text-md-start text-center"><?php echo htmlspecialchars($userData['cus_fname'] . ' ' . $userData['cus_lname']); ?></h3>
            <p class="m-0">อีเมล: <?php echo htmlspecialchars($userData['cus_email'] ?: ''); ?></p>
            <p class="m-0">เบอร์โทร: <?php echo htmlspecialchars($userData['cus_phone'] ?: ''); ?></p>
            <p class="m-0">ที่อยู่: <?php echo htmlspecialchars($userData['cus_address'] ?: ''); ?></p>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <p class="m-0 small text-secondary">ID: <?php echo htmlspecialchars($_SESSION['profile']->userId); ?></p>
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
              <label for="editUser_firstName">ชื่อ (ภาษาไทย)</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="นามสกุล (ภาษาไทย)" type="text" name="lastName" id="editUser_lastName" class="form-control">
              <label for="editUser_lastName">นามสกุล (ภาษาไทย)</label>
            </div>
            <div class="form-floating mb-3">
              <select name="gender" id="editUser_gender" class="form-control">
                <option value="">---- เลือกเพศ ----</option>
                <option value="male">ชาย</option>
                <option value="female">หญิง</option>
                <option value="other">อื่นๆ</option>
              </select><label for="editUser_gender">เพศ</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="วันเกิด" type="date" name="birthDate" id="editUser_birthDate" class="form-control">
              <label for="editUser_birthDate">วันเกิด</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="เบอร์โทร" type="tel" name="phone" id="editUser_phone" maxlength="10" class="form-control">
              <label for="editUser_phone">เบอร์โทร</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="อีเมล" type="email" name="email" id="editUser_email" class="form-control">
              <label for="editUser_email">อีเมล</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="ที่อยู่" type="text" name="address" id="editUser_address" class="form-control" v-model="formData.address">
              <label for="editUser_address">ที่อยู่</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100">บันทึก</button>
        </div>
      </div>
    </div>
    </div>
  </section>
  <?php include_once("includes/user/user-script.php"); ?>
</body>

<style>
  .card .card-header h4 {
    margin: 8px 0;
  }
</style>