<?php
// Split the full name into parts
$nameParts = explode(' ', $_SESSION['profile']->name);
$firstName = $nameParts[0] ?? '';
$lastName = $nameParts[1] ?? '';
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
            <h3 class="text-md-start text-center"><?php echo htmlspecialchars($_SESSION['profile']->name); ?></h3>
            <p class="m-0">อีเมล: </p>
            <p class="m-0">เบอร์โทร: </p>
            <p class="m-0">ที่อยู่: </p>
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
              <input placeholder="ชื่อ (ภาษาไทย)" type="text" name="firstName" id="editUser_firstName" class="form-control" v-model="formData.firstName">
              <label for="editUser_firstName">ชื่อ (ภาษาไทย)</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="นามสกุล (ภาษาไทย)" type="text" name="lastName" id="editUser_lastName" class="form-control" v-model="formData.lastName">
              <label for="editUser_lastName">นามสกุล (ภาษาไทย)</label>
            </div>
            <div class="form-floating mb-3">
              <select name="gender" id="editUser_gender" class="form-control" v-model="formData.gender">
                <option value="">---- เลือกเพศ ----</option>
                <option value="male">ชาย</option>
                <option value="female">หญิง</option>
                <option value="other">อื่นๆ</option>
              </select><label for="editUser_gender">เพศ</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="วันเกิด" type="date" name="birthDate" id="editUser_birthDate" class="form-control" v-model="formData.birthDate">
              <label for="editUser_hire_date">วันเกิด</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="เบอร์โทร" type="tel" name="phone" id="editUser_phone" maxlength="10" class="form-control" v-model="formData.phone">
              <label for="editUser_phone">เบอร์โทร</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="อีเมล" type="email" name="email" id="editUser_email" class="form-control" v-model="formData.email">
              <label for="editUser_email">อีเมล</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="ที่อยู่" type="text" name="address" id="editUser_address" class="form-control" v-model="formData.address">
              <label for="editUser_address">ที่อยู่</label>
            </div>

          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100" @click="submitForm" :disabled="!checkFields()">บันทึก</button>
        </div>
      </div>
    </div>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        <form action="includes/LineLogout.php" method="POST">
          <button type="submit" class="btn btn-danger w-100">ออกจากระบบ</button>
        </form>
      </div>
    </div>
  </section>
  <script>
    const firstName = "<?php echo htmlspecialchars($firstName); ?>";
    const lastName = "<?php echo htmlspecialchars($lastName); ?>";
    const email = "<?php echo htmlspecialchars($_SESSION['profile']->email); ?>";
  </script>
  <script src="assets/js/user-form.js" type="module"></script>
</body>

<style>
  .card .card-header h4 {
    margin: 8px 0;
  }
</style>