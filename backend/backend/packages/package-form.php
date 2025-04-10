<?php
require_once('../includes/conn.php');

// ดึงรหัสล่าสุด
$sql = "SELECT pac_code FROM packages ORDER BY pac_code DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$lastCode = $result->fetch_assoc()['pac_code'] ?? 'PACK000'; // Fix: Changed from SERV000 to PACK000
$stmt->close();

// สร้างรหัสใหม่
$numberPart = (int)substr($lastCode, 4); 
$newNumberPart = str_pad($numberPart + 1, 3, '0', STR_PAD_LEFT);
$newpackageCode = 'PACK' . $newNumberPart;

// ดึงบริการทั้งหมดที่มีสถานะ active
$sqlServices = "SELECT ser_id, ser_name FROM services WHERE ser_active = 'yes'";
$stmtServices = $conn->prepare($sqlServices);
$stmtServices->execute();
$services = $stmtServices->get_result();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="code">รหัสแพ็กเกจ</label>
            <input type="text" id="code" class="form-control" value="<?php echo htmlspecialchars($newpackageCode); ?>" readonly>
        </div>

        <div class="col-8">
            <label for="name">ชื่อแพ็กเกจ</label>
            <input onkeyup="checkNull();" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="cat_id">หมวดหมู่</label>
            <select id="cat_id" class="form-control">
                <?php
                $sql = "SELECT * FROM categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['cat_id']) . "'>" . htmlspecialchars($row['cat_name']) . "</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="price1">ราคา</label>
            <input onkeyup="checkNull();" type="number" id="price1" class="form-control">
        </div>
        <div class="col">
            <label for="hour">จำนวนชั่วโมง : นาที</label>
            <input type="text" id="hour" class="form-control" placeholder="hh:mm" maxlength="5" onkeyup="timeInput();">
            <small id="timeError" class="text-danger" style="display: none;">กรุณากรอกเวลาในรูปแบบ hh:mm (เช่น 02:30 หรือ 12:45)</small>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="services">เลือกบริการที่รวมอยู่ในแพ็กเกจ</label>
            <select id="services" name="services[]" multiple class="form-control" onchange="updateDescription()">
                <?php while($service = $services->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($service['ser_id']); ?>">
                        <?php echo htmlspecialchars($service['ser_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <small>กด Ctrl หรือ Shift เพื่อเลือกหลายบริการ</small>
            <input type="hidden" id="description" name="description">
        </div>
    </div>

</div>

<div class="modal-footer">
    <button onclick="packageAdd();" id="btnSubmit" data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        บันทึกรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>

<script>
    function updateDescription() {
        const selectedServices = [];
        const serviceSelect = document.getElementById('services');
        
        // Get all selected options
        for (let i = 0; i < serviceSelect.options.length; i++) {
            if (serviceSelect.options[i].selected) {
                selectedServices.push(serviceSelect.options[i].text);
            }
        }
        
        // Combine selected services with comma separator
        document.getElementById('description').value = selectedServices.join(', ');
        checkNull();
    }

    function checkNull() {
        const code = document.getElementById('code').value.trim();
        const name = document.getElementById('name').value.trim();
        const description = document.getElementById('description').value.trim();
        const cat_id = document.getElementById('cat_id').value;
        const price1 = document.getElementById('price1').value.trim();
        const hour = document.getElementById('hour').value.trim();

        const btnSubmit = document.getElementById('btnSubmit');

        // ตรวจสอบค่าต่าง ๆ ให้ครบถ้วน
        if (code && name && description && cat_id && price1 && hour) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }


    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price1').value = "";
        document.getElementById('hour').value = "";
        document.getElementById('services').selectedIndex = -1;
        document.getElementById('description').value = "";
        document.getElementById('cat_id').value = "";
        document.getElementById('btnSubmit').disabled = true;
    }

    function timeInput() {
        document.getElementById("hour").addEventListener("input", function(event) {
            let input = this.value.replace(/\D/g, ""); // เอาเฉพาะตัวเลข
            let timeError = document.getElementById("timeError");

            if (input.length > 4) {
                input = input.substring(0, 4); // จำกัดให้ไม่เกิน 4 หลัก
            }

            if (input.length > 2) {
                input = input.substring(0, 2) + ":" + input.substring(2);
            }

            this.value = input;

            let regex = /^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
            if (regex.test(input)) {
                this.classList.remove("is-invalid");
                timeError.style.display = "none";
            } else {
                this.classList.add("is-invalid");
                timeError.style.display = "block";
            }
        });
    }
    
    // Initialize the event listener for hour input when page loads
    document.addEventListener("DOMContentLoaded", function() {
        timeInput();
    });
</script>
