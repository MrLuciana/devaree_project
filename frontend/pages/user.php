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
        <div>
          <div>
            <div class="form-floating mb-3">
              <input placeholder="ชื่อ (ภาษาไทย)" type="text" name="firstName" id="editUser_firstName" class="form-control" value="<?php echo htmlspecialchars($firstName); ?>">
              <label for="editUser_firstName">ชื่อ (ภาษาไทย)</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="นามสกุล (ภาษาไทย)" type="text" name="lastName" id="editUser_lastName" class="form-control" value="<?php echo htmlspecialchars($lastName); ?>">
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
              <label for="editUser_hire_date">วันเกิด</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="เบอร์โทร" type="tel" name="phone" id="editUser_phone" maxlength="10" value="" class="form-control">
              <label for="editUser_phone">เบอร์โทร</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="อีเมล" type="email" name="email" id="editUser_email" class="form-control" value="<?php echo htmlspecialchars($_SESSION['profile']->email); ?>">
              <label for="editUser_email">อีเมล</label>
            </div>
            <div class="form-floating mb-3">
              <input placeholder="ที่อยู่" type="text" name="address" id="editUser_address" class="form-control">
              <label for="editUser_address">ที่อยู่</label>
            </div>

          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100" id="editUser_submitBtn" disabled onclick="dummySubmit()">บันทึก</button>
        </div>
      </div>
    </div>
  </section>
</body>

<style>
  .card .card-header h4 {
    margin: 8px 0;
  }
</style>

<script>
  const fields = ['editUser_firstName', 'editUser_lastName', 'editUser_email', 'editUser_phone', 'editUser_birthDate'];

  document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('editUser_submitBtn');
    const genderSelect = document.getElementById('editUser_gender');

    // Function to check form validity
    const checkFormValidity = () => {
      const hasEmptyFields = fields.some(f => document.getElementById(f).value === '');
      const isGenderEmpty = genderSelect.value === '';
      submitBtn.disabled = hasEmptyFields || isGenderEmpty;
    };

    // Add listeners to text fields
    fields.forEach(field => {
      const input = document.getElementById(field);
      input.addEventListener('input', checkFormValidity);
    });

    // Add listener to gender select
    genderSelect.addEventListener('change', checkFormValidity);

    // Initial check
    checkFormValidity();
  });

  function dummySubmit() {
    Swal.fire({
      icon: "success",
      title: "บันทึกข้อมูลสำเร็จ",
      showConfirmButton: false,
      timer: 1500
    });
    const formFields = {
      'ชื่อ': 'editUser_firstName',
      'นามสกุล': 'editUser_lastName',
      'เพศ': 'editUser_gender',
      'เบอร์โทร': 'editUser_phone',
      'อีเมล': 'editUser_email',
      'วันเกิด': 'editUser_birthDate'
    };

    const formData = {};
    Object.entries(formFields).forEach(([label, id]) => {
      formData[label] = document.getElementById(id).value;
    });

    console.table(formData);
    // clearForm();
  }

  function clearForm() {
    fields.forEach(field => {
      document.getElementById(field).value = '';
    });
    genderSelect.selectedIndex = 0;
    checkFormValidity();
  }
</script>