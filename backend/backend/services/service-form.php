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
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="price">ราคา</label>
            <input onkeyup="checkNull();" type="int" id="price" class="form-control">
        </div>
        <div class="col">
            <label for="category">หมวดหมู่</label>
            <select id="category" name="category" class="form-control">
                <option value="นาย">นาย</option>
                <option value="นาง">นาง</option>
            </select>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="description">รายละเอียด</label>
            <input onkeyup="checkNull();" type="text" id="description" class="form-control">
        </div>
    </div>
</div>

<div class="modal-footer">
    <button onclick="serviceAdd();" id="btnSubmit" data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        บันทึกรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>

<script>
    function checkNull() {
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();
        const description = document.getElementById('description').value.trim();
        const category = document.getElementById('category').value.trim();
        const btnSubmit = document.getElementById('btnSubmit');

        if (name && price && category && description) {
            document.getElementById('btnSubmit').disabled = false;
        } else {
            document.getElementById('btnSubmit').disabled = true;
        }
    }

    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price').value = "";
        document.getElementById('description').value = "";
        document.getElementById('category').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>