<?php
require_once('../includes/conn.php');

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("<p class='text-danger text-center'>เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล</p>");
}
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="service_name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" type="text" id="service_name" class="form-control">
        </div>
        <div class="col">
            <label for="service_description">รายละเอียด</label>
            <input onkeyup="checkNull();" type="text" id="service_description" class="form-control">
        </div>
    </div>
    
    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="email">อีเมล์</label>
            <input onkeyup="checkNull();" type="email" id="email" class="form-control">
        </div>
        <div class="col">
            <label for="password">รหัสผ่าน</label>
            <input onkeyup="checkNull();" type="password" id="password" class="form-control">
        </div>
    </div>
</div>

<div class="modal-footer">
    <button onclick="memberAdd();" id="btnSubmit" data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
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
        const password = document.getElementById('password').value.trim();
        const btnSubmit = document.getElementById('btnSubmit');

        btnSubmit.disabled = !(fname && lname && email && password);
    }

    function clearForm() {
        document.getElementById('fname').value = "";
        document.getElementById('lname').value = "";
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>
