<script>
  $(document).ready(function() {
    // Initialize form data with values from PHP or window variables
    const userData = {
      firstName: '<?php echo isset($userData["cus_fname"]) ? htmlspecialchars($userData["cus_fname"]) : htmlspecialchars($firstName); ?>',
      lastName: '<?php echo isset($userData["cus_lname"]) ? htmlspecialchars($userData["cus_lname"]) : htmlspecialchars($lastName); ?>',
      gender: '<?php echo isset($userData["cus_gender"]) ? htmlspecialchars($userData["cus_gender"]) : ""; ?>',
      birthDate: '<?php echo isset($userData["cus_birthdate"]) ? htmlspecialchars($userData["cus_birthdate"]) : ""; ?>',
      phone: '<?php echo isset($userData["cus_phone"]) ? htmlspecialchars($userData["cus_phone"]) : ""; ?>',
      email: '<?php echo isset($userData["cus_email"]) ? htmlspecialchars($userData["cus_email"]) : htmlspecialchars($email); ?>',
      address: '<?php echo isset($userData["cus_address"]) ? htmlspecialchars($userData["cus_address"]) : ""; ?>'
    };

    // Set initial form values
    $('#editUser_firstName').val(userData.firstName);
    $('#editUser_lastName').val(userData.lastName);
    $('#editUser_gender').val(userData.gender);
    $('#editUser_birthDate').val(userData.birthDate);
    $('#editUser_phone').val(userData.phone);
    $('#editUser_email').val(userData.email);
    $('#editUser_address').val(userData.address);

    // Function to check if all required fields are filled
    function checkFields() {
      const firstName = $('#editUser_firstName').val();
      const lastName = $('#editUser_lastName').val();
      const gender = $('#editUser_gender').val();
      const birthDate = $('#editUser_birthDate').val();
      const phone = $('#editUser_phone').val();
      const email = $('#editUser_email').val();
      const address = $('#editUser_address').val();

      // Return true if all required fields are filled
      return firstName && lastName && gender && birthDate && phone && email && address;
    }

    // Update submit button state on input change
    $('#user-form input, #user-form select').on('input change', function() {
      const allFieldsFilled = checkFields();
      $('#user-form button[type="submit"]').prop('disabled', !allFieldsFilled);
    });

    // Initial check for form fields
    $('#user-form button[type="submit"]').prop('disabled', !checkFields());

    // Handle form submission
    $('#user-form button[type="submit"]').on('click', function(e) {
      e.preventDefault();

      // Collect form data
      const formData = {
        firstName: $('#editUser_firstName').val(),
        lastName: $('#editUser_lastName').val(),
        gender: $('#editUser_gender').val(),
        birthDate: $('#editUser_birthDate').val(),
        phone: $('#editUser_phone').val(),
        email: $('#editUser_email').val(),
        address: $('#editUser_address').val()
      };

      console.log('Form submitted:', formData);

      // Show loading state
      const $submitButton = $(this);
      const originalButtonText = $submitButton.html();
      $submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...');
      $submitButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        url: 'includes/update_customer.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          // Reset button state
          $submitButton.html(originalButtonText);
          $submitButton.prop('disabled', false);

          if (response.status === 'success') {
            // Show success message using SweetAlert2 if available, otherwise use alert
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location.href = '?page=home'; // Redirect to home page
              });
            } else {
              alert(response.message);
              window.location.href = '?page=home'; // Redirect to home page
            }
          } else {
            // Show error message
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                icon: 'error',
                title: 'แก้ไขข้อมูลไม่สำเร็จ',
                text: response.message || 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
              });
            } else {
              alert(response.message || 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล');
            }
          }
        },
        error: function(xhr, status, error) {
          // Reset button state
          $submitButton.html(originalButtonText);
          $submitButton.prop('disabled', false);

          console.error('AJAX Error:', status, error);

          // Show error message
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง'
            });
          } else {
            alert('ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง');
          }
        }
      });
    });

    // Add form validation
    $('#editUser_phone').on('input', function() {
      const phoneNumber = $(this).val();
      // Allow only digits and limit to 10 characters
      $(this).val(phoneNumber.replace(/\D/g, '').substring(0, 10));
    });

    $('#editUser_email').on('blur', function() {
      const email = $(this).val();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (email && !emailRegex.test(email)) {
        $(this).addClass('is-invalid');
        if (!$(this).next('.invalid-feedback').length) {
          $(this).after('<div class="invalid-feedback">กรุณากรอกอีเมลให้ถูกต้อง</div>');
        }
      } else {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
      }
    });
  });
</script>