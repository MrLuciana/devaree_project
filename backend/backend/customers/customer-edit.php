<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM customers 
        WHERE customer_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="fname">ชื่อจริง</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_fname']; ?>" type="text" id="fname" class="form-control">
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_lname']; ?>" type="text" id="lname" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_email']; ?>" type="text" id="email" class="form-control">
        </div>
        <div class="col">
            <label for="phone">เบอร์โทร</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_phone']; ?>" type="text" id="phone" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="address">ที่อยู่</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_address']; ?>" type="text" id="address" class="form-control">
        </div>
        <div class="col">
            <label for="city">เมือง</label>
            <input onkeyup="checkNull();" value="<?php echo $row['customer_city']; ?>" type="text" id="city" class="form-control">
        </div>
    </div>

</div>

<div class="modal-footer">
    <button onclick="customerUpdate('<?php echo $id; ?>');" id="btnSubmit"
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
        const address = document.getElementById('address').value.trim();
        const city = document.getElementById('city').value.trim();
        
        if (fname && lname && email && phone && address && city) {
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
        document.getElementById('address').value = "";
        document.getElementById('city').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>