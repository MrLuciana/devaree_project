<?php
require_once('../includes/conn.php');
$id = $_POST['id'];
$sql = "SELECT member.*, program.* FROM member,program WHERE member.pro_id = program.pro_id AND mem_id='$id' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// $conn->close();
?>
<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="title">คำนำหน้า</label>
            <select id="title" class="form-control">
                <option selected value="<?php echo $row['mem_title']?>">
                    <?php echo $row['mem_title']?>
                </option>
                <option value="นาย">นาย</option>
                <option value="นาง">นาง</option>
                <option value="นางสาว">นางสาว</option>
                <option value="ผู้ช่วยศาสตราจารย์">ผู้ช่วยศาสตราจารย์</option>
                <option value="ผู้ช่วยศาสตราจารย์ ดร.">ผู้ช่วยศาสตราจารย์ ดร.</option>

            </select>
        </div>
        <div class="col">
            <label for="fname">ชื่อ</label>
            <input onkeyup="checkNull();" value="<?php echo $row['mem_fname']?>" type="text" id="fname"
                class="form-control">

        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <input onkeyup="checkNull();" value="<?php echo $row['mem_lname']?>" type="text" id="lname"
                class="form-control">
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="pro_id">หลักสูตร / สาขาวิชา</label>
            <select id="pro_id" class="form-control">
                <?php
                $pro_id= $row['pro_id'];
                $sql = "SELECT program.* FROM  program WHERE program.pro_id != $pro_id" ;
                $result = $conn->query($sql);
                while ($row_pro = $result->fetch_assoc()) {
                ?>
                <option value="<?php echo $row_pro['pro_id'];?>"><?php echo $row_pro['pro_name']; ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="email"> อีเมล์</label>
            <input onkeyup="checkNull();" value="<?php echo $row['mem_email']?>" type="email" id="email"
                class="form-control">
        </div>
        <div class="col">
            <label for="password"> รหัสผ่าน</label>
            <input onkeyup="checkNull();" value="<?php echo $row['mem_password']?>" type="text" id="password"
                class="form-control">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button onclick="memberUpdate(<?php echo $id; ?>);" id="btnSubmit" data-dismiss="modal" disabled
        class="btn btn-primary" style="font-size:12pt;width:150px;">
        อัปเดตรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" data-dismiss="modal" style="font-size:12pt;width:100px;">
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


}
</script>