<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM employees 
        WHERE employee_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="fname">ชื่อจริง</label>
            <input onkeyup="checkNull();" value="<?php echo $row['employee_fname']; ?>" type="text" id="fname" class="form-control">
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <input onkeyup="checkNull();" value="<?php echo $row['employee_lname']; ?>" type="text" id="lname" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label>
            <input onkeyup="checkNull();" value="<?php echo $row['employee_email']; ?>" type="text" id="email" class="form-control">
        </div>
        <div class="col">
            <label for="phone">เบอร์โทร</label>
            <input onkeyup="checkNull();" value="<?php echo $row['employee_phone']; ?>" type="text" id="phone" class="form-control">
        </div>
        <div class="col">
            <label for="position">ตำแหน่ง</label>
            <input onkeyup="checkNull();" value="<?php echo $row['employee_position']; ?>" type="text" id="position" class="form-control">
        </div>
    </div>

</div>

<div class="modal-footer">
    <button onclick="employeeUpdate('<?php echo $id; ?>');" id="btnSubmit"
        data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        อัปเดตรายการ
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
        const position = document.getElementById('position').value.trim();

        
        if (fname && lname && email && phone && position) {
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
        document.getElementById('position').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>