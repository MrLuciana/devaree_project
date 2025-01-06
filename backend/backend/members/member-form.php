<?php
require_once('../includes/conn.php');
?>
<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="title">คำนำหน้า</label>
            <select id="title" class="form-control">
                <option value="นาย">นาย</option>
                <option value="นาง">นาง</option>
                <option value="นางสาว">นางสาว</option>
                <option value="ผู้ช่วยศาสตราจารย์">ผู้ช่วยศาสตราจารย์</option>
                <option value="ผู้ช่วยศาสตราจารย์ ดร.">ผู้ช่วยศาสตราจารย์ ดร.</option>

            </select>
        </div>
        <div class="col">
            <label for="fname">ชื่อ</label>
            <input onkeyup="checkNull();" type="text" id="fname" class="form-control">
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <input onkeyup="checkNull();" type="text" id="lname" class="form-control">
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="pro_id">หลักสูตร / สาขาวิชา</label>
            <select id="pro_id" class="form-control">
                <?php
                $sql = "SELECT program.* FROM  program";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row['pro_id']; ?>"><?php echo $row['pro_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="email"> อีเมล์</label>
            <input onkeyup="checkNull();" type="email" id="email" class="form-control">
        </div>
        <div class="col">
            <label for="password"> รหัสผ่าน</label>
            <input onkeyup="checkNull();" type="text" id="password" class="form-control">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button onclick="memberAdd();" id="btnSubmit" data-dismiss="modal" disabled class="btn btn-primary"
        style="font-size:12pt;width:150px;">
        บันทึกรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>
<script>
    function checkNull() {
        var fname = document.getElementById('fname').value;
        var lname = document.getElementById('lname').value;
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        if (fname && lname && email && password) {
            document.getElementById('btnSubmit').disabled = false;
        } else {
            document.getElementById('btnSubmit').disabled = true;
        }

    }

    function clearForm() {
        document.getElementById('fname').value = "";
        document.getElementById('lname').value = "";
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
        document.getElementById('btnSubmit').disabled = true;


    }

</script>