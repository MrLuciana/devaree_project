<?php
require_once('../includes/conn.php');
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="fname">ชื่อจริง</label>
            <input onkeyup="checkNull();" type="text" id="fname" class="form-control">
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <input onkeyup="checkNull();" type="text" id="lname" class="form-control">
        </div>
        <div class="col">
            <label for="gender">เลือกเพศ:</label>
            <select onchange="checkNull();" id="gender" class="form-control">
                <option value="">-- กรุณาเลือก --</option>
                <option value="male">ชาย</option>
                <option value="female">หญิง</option>
                <option value="other">อื่น ๆ</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label>
            <input onkeyup="checkNull();" type="text" id="email" class="form-control">
        </div>
        <div class="col">
            <label for="phone">เบอร์โทร</label>
            <input onkeyup="checkNull();" type="text" id="phone" class="form-control">
        </div>
        <div class="col">
            <label for="hire_date">วันที่เริ่มงาน:</label>
            <input onchange="checkNull();" type="date" name="hire_date" id="hire_date" class="form-control">
        </div>
    </div>
</div>

<div class="modal-footer">
    <button onclick="customerAdd();" id="btnSubmit" data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        บันทึกรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>

<script>
    function checkNull() {
        const fname = document.getElementById('fname').value.trim();
        const lname = document.getElementById('lname').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const gender = document.getElementById('gender').value
        const hire_date = document.getElementById('hire_date').value

        if (fname && lname && email && phone && gender && hire_date) {
            document.getElementById('btnSubmit').disabled = false;
        } else {
            document.getElementById('btnSubmit').disabled = true;
        }
    }

    function clearForm() {
        document.getElementById('fname').value = "";
        document.getElementById('lname').value = "";
        document.getElementById('email').value = "";
        document.getElementById('phone').value = "";
        document.getElementById('gender').value = "";
        document.getElementById('hire_date').value = "";

        checkNull();
    }
</script>