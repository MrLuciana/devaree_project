<?php
require_once('../includes/conn.php');
$id = $_POST['id'];
$sql = "SELECT member.*, program.* FROM member,program WHERE member.pro_id = program.pro_id AND mem_id='$id' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();

?>
<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="title">คำนำหน้า</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['mem_title']; ?></div>

        </div>
        <div class="col">
            <label for="fname">ชื่อ</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['mem_fname']; ?></div>
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['mem_lname']; ?></div>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="pro_id">หลักสูตร / สาขาวิชา</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['pro_name']; ?></div>
        </div>
        <div class="col">
            <label for="email"> อีเมล์</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['mem_email']; ?></div>
        </div>
        <div class="col">
            <label for="password"> รหัสผ่าน</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['mem_password']; ?></div>
        </div>
    </div>
</div>
<div class="modal-footer">

</div>