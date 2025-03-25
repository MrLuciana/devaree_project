<?php
$packageQuery = "SELECT * FROM packages WHERE pac_active = 'yes' ORDER BY pac_id DESC";
$packageResult = mysqli_query($conn, $packageQuery);
$packages = [];
while ($row = mysqli_fetch_assoc($packageResult)) {
  $packages[] = $row;
}
?>
<form id="package-reserve">
  <div class="mb-3">
    <label for="package_id" class="form-label">เลือกแพ็คเกจ <span class="text-danger">*</span></label>
    <select name="package_id" id="package_id" class="form-select" required>
      <option value="">---เลือกแพ็คเกจ---</option>
      <?php
      foreach ($packages as $package) {
        echo "<option value='{$package['pac_id']}' data-hour='{$package['pac_hour']}' data-price='{$package['pac_price1']}'>{$package['pac_name']} - {$package['pac_description']}</option>";
      }
      ?>
    </select>
    <span class="invalid-feedback">กรุณาเลือกแพ็คเกจ</span>
  </div>

  <div class="row mb-3">
    <div class="col-6">
      <div>
        <label for="package_price" class="form-label">ราคาแพ็คเกจ</label>
        <input type="text" class="form-control" id="package_price" name="package_price" readonly>
      </div>
    </div>
    <div class="col-6">
      <div>
        <label for="package_hour" class="form-label">ระยะเวลา</label>
        <input type="text" class="form-control" id="package_hour" name="package_hour" min="1" readonly>
      </div>
    </div>
  </div>

  <div class="mb-3">
    <div class="row">
      <div class="col-6">
        <label for="reserve_date" class="form-label">เลือกวันที่ <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="reserve_date" name="reserve_date" min="<?php echo date('Y-m-d'); ?>" required>
        <div class="invalid-feedback">กรุณาเลือกวันที่</div>
      </div>
      <div class="col-6">
        <label for="reserve_time" class="form-label">เลือกเวลา <span class="text-danger">*</span></label>
        <input type="time" class="form-control" id="reserve_time" name="reserve_time" required>
        <div class="invalid-feedback">กรุณาเลือกเวลา</div>
      </div>
    </div>
  </div>

  <div class="mb-3">
    <label for="payment_method" class="form-label">วิธีการชำระเงิน</label>
    <select class="form-select" id="payment_method" name="payment_method">
      <option value="">---เลือกวิธีการชำระเงิน---</option>
      <option value="cash">เงินสด (ชำระหน้าร้าน)</option>
      <option value="promptpay">พร้อมเพย์</option>
    </select>
    <div class="invalid-feedback">กรุณาระบุวิธีการชำระเงิน</div>
  </div>

  <div class="mb-3">
    <label for="additional_info" class="form-label">ข้อมูลเพิ่มเติม</label>
    <textarea name="additional_info" id="additional_info" class="form-control"></textarea>
  </div>

  <div class="card mb-3 bg-primary-subtle border-primary" id="package_summary_card">
    <div class="card-body">
      <h5 class="card-title">สรุปการจองแพ็คเกจ</h5>
      <div class="d-flex justify-content-between">
        <span>แพ็คเกจ:</span>
        <span id="summary_package">---เลือกแพ็คเกจ---</span>
      </div>
      <div class="d-flex justify-content-between">
        <span>ราคา:</span>
        <span><span id="summary_package_price">0</span> บาท</span>
      </div>
      <div class="d-flex justify-content-between">
        <span>ระยะเวลา:</span>
        <span><span id="summary_package_hours">1</span> ชม.</span>
      </div>
      <hr>
      <div class="d-flex justify-content-between">
        <h5 class="m-0">รวมทั้งสิ้น:</h5>
        <h5 class="m-0 text-danger"><span id="summary_package_total_price">0</span> บาท</h5>
      </div>
    </div>
  </div>

  <div class="mb-3">
    <button class="btn btn-primary w-100" type="submit" disabled aria-disabled="true" id="package-form-submitBtn">
      <i class="bi bi-calendar-plus me-2"></i>ยืนยันการจองแพ็คเกจ
    </button>
  </div>
</form>
<style>
  #package_summary_card .d-flex {
    font-size: 12pt;
  }
</style>
<script>
  // Function to validate form fields
  function validateForm() {
    let isValid = true;
    const requiredFields = document.querySelectorAll("#package-reserve [required]");

    requiredFields.forEach(function(field) {
      if (!field.value) {
        field.classList.add("is-invalid");
        isValid = false;
      } else {
        field.classList.remove("is-invalid");
      }
    });

    // Enable or disable the submit button based on form validity
    const submitBtn = document.getElementById("package-form-submitBtn");
    if (isValid) {
      submitBtn.removeAttribute("disabled");
      submitBtn.setAttribute("aria-disabled", "false");
    } else {
      submitBtn.setAttribute("disabled", "true");
      submitBtn.setAttribute("aria-disabled", "true");
    }

    return isValid;
  }

  document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('package_id');
    const packagePriceInput = document.getElementById('package_price');
    const packageHourInput = document.getElementById('package_hour');

    packageSelect.addEventListener('change', function() {
      const selectedOption = packageSelect.options[packageSelect.selectedIndex];
      const price = selectedOption.dataset.price;
      const hour = selectedOption.dataset.hour;
      packagePriceInput.value = price;
      packageHourInput.value = hour;

      document.getElementById('summary_package').textContent = selectedOption.textContent;
      document.getElementById('summary_package_price').textContent = price;
      document.getElementById('summary_package_hours').textContent = hour;
      document.getElementById('summary_package_total_price').textContent = price;
    });
  });

  $(document).ready(function() {

    // Function to update price summary
    function updatePriceSummary() {
      const serviceSelect = $("#ser_id");
      const durationInput = $("#duration");

      const serviceName = serviceSelect.find("option:selected").text() || "-";
      const servicePrice = parseFloat(serviceSelect.find("option:selected").data("price")) || 0;
      const duration = parseInt(durationInput.val()) || 1;

      const totalPrice = servicePrice * duration;

      $("#summary_service").text(serviceName);
      $("#service_price").text(servicePrice.toLocaleString());
      $("#summary_hours").text(duration);
      $("#total_price").text(totalPrice.toLocaleString());
    }

    // Function to validate form

    // Initial validation and price calculation
    updatePriceSummary();

    // Form submission
    $("#package-reserve").on("submit", function(e) {
      e.preventDefault();

      // if (!validateForm()) {
      //   return false;
      // }


      // Collect form data
      const formData = {
        customer_name: $("#customer_name").val(),
        customer_phone: $("#customer_phone").val(),
        customer_email: $("#customer_email").val(),
        line_user_id: $("#line_user_id").val(),
        special_requests: $("#special_requests").val(),
        ser_id: $("#ser_id").val(),
        package_id: $("#package_id").val(),
        reserve_date: $("#reserve_date").val(),
        reserve_time: $("#reserve_time").val(),
        duration: $("#duration").val()
      };


      // Send AJAX request
      $.ajax({
        url: "pages/reserve/reserve-action-packages.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
          if (response.status === "success") {
            // Show success message
            Swal.fire({
              icon: 'success',
              title: 'จองสำเร็จ!',
              text: response.message,
              confirmButtonText: 'ตกลง'
            }).then((result) => {
              // Reset form
              $("#ser_id").val('');
              $("#reserve_date").val('');
              $("#reserve_time").val('');
              $("#duration").val('1');
              $("#special_requests").val('');
              updatePriceSummary();
              validateForm();
              window.location.href = "index.php?page=user"; // Redirect to user page
            });
          } else {
            // Show error message
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด!',
              text: response.message,
              confirmButtonText: 'ตกลง'
            });
          }
        },
        error: function(xhr, status, error) {
          // Hide loading overlay
          $("#loadingOverlay").hide();

          // Show error message
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด!',
            text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
            confirmButtonText: 'ตกลง'
          });

          // console.error("AJAX Error:", status, error);
        }
      });
    });

  });
</script>