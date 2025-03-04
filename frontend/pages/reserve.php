<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if user is logged in with LINE
$isLoggedIn = isset($_SESSION['profile']) && isset($_SESSION['profile']->userId);

// If not logged in, redirect to index page with a message
if (!$isLoggedIn) {
  // Set a session variable to indicate login required
  $_SESSION['login_required'] = true;
  $_SESSION['redirect_after_login'] = 'pages/reserve.php';

  // Redirect to index page
  header('Location: ../index.php');
  exit;
}

// Get user data from session
$lineUserId = $_SESSION['profile']->userId ?? '';
$customerName = $_SESSION['profile']->cus_fname . ' ' . ($_SESSION['profile']->cus_lname ?? '');
$customerEmail = $_SESSION['profile']->cus_email ?? '';
$customerPhone = $_SESSION['customer']['cus_phone'] ?? '';

// Include database connection
// require_once '../includes/conn.php';

?>

<body>
  <nav class="bg-primary text-center text-white py-1 sticky-top mb-4">
    <h3>จองบริการ</h3>
  </nav>
  <section class="container">
    <!-- <h1 class="text-center my-3">จองบริการ</h1> -->
    <!-- <pre><?php print_r($_SESSION['profile']); ?></pre> -->

    <div class="card">
      <div class="card-body">
        <!-- User Information Card -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="m-0">ข้อมูลผู้จอง</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-2 text-center mb-3 mb-md-0">
                <?php if (isset($_SESSION['profile']->picture)): ?>
                  <img src="<?php echo htmlspecialchars($_SESSION['profile']->picture); ?>" alt="Profile Picture" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                <?php else: ?>
                  <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <i class="bi bi-person-fill text-white" style="font-size: 2rem;"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-md-10">
                <h5><?php echo htmlspecialchars($customerName); ?></h5>
                <p class="mb-1"><i class="bi bi-envelope me-2"></i><?php echo htmlspecialchars($customerEmail ?: 'ไม่ระบุอีเมล'); ?></p>
                <p class="mb-1"><i class="bi bi-telephone me-2"></i><?php echo htmlspecialchars($customerPhone ?: 'ไม่ระบุเบอร์โทรศัพท์'); ?></p>
                <?php if (empty($customerPhone)): ?>
                  <div class="alert alert-warning mt-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    กรุณาเพิ่มเบอร์โทรศัพท์ในหน้า <a href="user.php" class="alert-link">ข้อมูลผู้ใช้</a> เพื่อให้ทางร้านสามารถติดต่อกลับได้
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <form id="reservationForm">
          <!-- Hidden fields for customer information -->
          <input type="hidden" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customerName); ?>">
          <input type="hidden" id="customer_phone" name="customer_phone" value="<?php echo htmlspecialchars($customerPhone); ?>">
          <input type="hidden" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($customerEmail); ?>">
          <input type="hidden" id="line_user_id" name="line_user_id" value="<?php echo htmlspecialchars($lineUserId); ?>">

          <!-- Service Selection -->
          <div class="mb-3">
            <label for="ser_id" class="form-label">เลือกบริการ <span class="text-danger">*</span></label>
            <select class="form-select" id="ser_id" name="ser_id" required>
              <option value="">---เลือกบริการ---</option>
              <?php
              // Fallback services in case database query fails
              $fallbackServices = [
                ['id' => 1, 'name' => 'นวดแผนไทย', 'price' => 600],
                ['id' => 2, 'name' => 'นวดน้ำมันอโรมา', 'price' => 1200],
                ['id' => 3, 'name' => 'นวดเท้า', 'price' => 500],
                ['id' => 4, 'name' => 'สปาหน้า', 'price' => 1500]
              ];

              // Try to get services from database
              $hasDbServices = false;
              try {
                $sql = "SELECT * FROM services WHERE ser_active = 'yes' ORDER BY ser_id DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                  $hasDbServices = true;
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['ser_id']}' data-price='{$row['ser_price1']}'>{$row['ser_name']}</option>";
                  }
                }
              } catch (Exception $e) {
                // Log error but continue with fallback options
                error_log("Error fetching services: " . $e->getMessage());
              }

              // Use fallback services if no database services were found
              if (!$hasDbServices) {
                foreach ($fallbackServices as $service) {
                  echo "<option value='{$service['id']}' data-price='{$service['price']}'>{$service['name']}</option>";
                }
              }
              ?>
            </select>
            <div class="invalid-feedback">กรุณาเลือกบริการ</div>
          </div>

          <!-- Date and Time Selection -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="reserve_date" class="form-label">เลือกวันที่ <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="reserve_date" name="reserve_date" required>
              <div class="invalid-feedback">กรุณาเลือกวันที่</div>
            </div>
            <div class="col-md-6">
              <label for="reserve_time" class="form-label">เลือกเวลา <span class="text-danger">*</span></label>
              <select class="form-select" id="reserve_time" name="reserve_time" required>
                <option value="">---เลือกเวลา---</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
              </select>
              <div class="invalid-feedback">กรุณาเลือกเวลา</div>
            </div>
          </div>

          <!-- Duration -->
          <div class="mb-3">
            <label for="duration" class="form-label">ระยะเวลา (ชั่วโมง) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="duration" name="duration" min="1" value="1" required>
            <div class="invalid-feedback">กรุณาระบุระยะเวลา</div>
          </div>

          <!-- Special Requests -->
          <div class="mb-3">
            <label for="special_requests" class="form-label">ข้อมูลเพิ่มเติม</label>
            <textarea class="form-control" id="special_requests" name="special_requests" rows="3"></textarea>
          </div>

          <!-- Price Summary -->
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">สรุปการจอง</h5>
              <div class="d-flex justify-content-between">
                <span>บริการ:</span>
                <span id="summary_service">-</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>ราคา/ชั่วโมง:</span>
                <span><span id="service_price">0</span> บาท</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>จำนวนชั่วโมง:</span>
                <span><span id="summary_hours">1</span> ชม.</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between">
                <h5 class="m-0">รวมทั้งสิ้น:</h5>
                <h5 class="m-0 text-danger"><span id="total_price">0</span> บาท</h5>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <button type="submit" id="reserve_submitBtn" class="btn btn-primary w-100" <?php echo empty($customerPhone) ? 'disabled' : ''; ?>>
              <i class="bi bi-calendar-plus me-2"></i>ยืนยันการจอง
            </button>
            <?php if (empty($customerPhone)): ?>
              <div class="text-danger mt-2 text-center">
                <small>กรุณาเพิ่มเบอร์โทรศัพท์ในหน้าข้อมูลผู้ใช้ก่อนทำการจอง</small>
              </div>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Loading Overlay -->
  <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
    <div class="spinner-border text-light" role="status">
      <span class="visually-hidden">กำลังโหลด...</span>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Hide any loading spinners
      $(".spinner-border").parent().hide();

      // Set minimum date for date input to today
      const today = new Date().toISOString().split('T')[0];
      $("#reserve_date").attr('min', today);

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
      function validateForm() {
        let isValid = true;
        const requiredFields = [
          "#ser_id",
          "#reserve_date",
          "#reserve_time",
          "#duration"
        ];

        // Check required fields
        requiredFields.forEach(field => {
          const $field = $(field);
          if (!$field.val()) {
            $field.addClass("is-invalid");
            isValid = false;
          } else {
            $field.removeClass("is-invalid");
          }
        });

        // Check if phone number is provided
        const customerPhone = $("#customer_phone").val();
        if (!customerPhone) {
          isValid = false;
        }

        // Enable/disable submit button
        if (!isValid) {
          $("#reserve_submitBtn").prop("disabled", true);
        } else {
          // Only enable if phone number is provided
          $("#reserve_submitBtn").prop("disabled", !customerPhone);
        }

        return isValid;
      }

      // Attach event listeners
      $("#ser_id, #duration").on("change", function() {
        updatePriceSummary();
        validateForm();
      });

      $("form input, form select").on("input change", validateForm);

      // Initial validation and price calculation
      updatePriceSummary();
      validateForm();

      // Form submission
      $("#reservationForm").on("submit", function(e) {
        e.preventDefault();

        if (!validateForm()) {
          return false;
        }

        // Show loading overlay
        $("#loadingOverlay").show();

        // Collect form data
        const formData = {
          customer_name: $("#customer_name").val(),
          customer_phone: $("#customer_phone").val(),
          customer_email: $("#customer_email").val(),
          line_user_id: $("#line_user_id").val(),
          ser_id: $("#ser_id").val(),
          reserve_date: $("#reserve_date").val(),
          reserve_time: $("#reserve_time").val(),
          duration: $("#duration").val(),
          special_requests: $("#special_requests").val()
        };

        // Send AJAX request
        $.ajax({
          url: "../includes/reserve-action.php",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function(response) {
            // Hide loading overlay
            $("#loadingOverlay").hide();

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

            console.error("AJAX Error:", status, error);
          }
        });
      });
    });
  </script>
</body>

</html>