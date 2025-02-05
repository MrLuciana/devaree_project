<?php
require_once('../includes/conn.php');

$id = isset($_POST['id']) ? $_POST['id'] : '';

if (empty($id)) {
    die("Error: ไม่พบ ID พนักงาน");
}

$sql = "SELECT * FROM customers 
        WHERE cus_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="fname">ชื่อจริง</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_fname']); ?></div>
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_lname']); ?></div>
        </div>
        <div class="col">
            <label for="gender">เลือกเพศ:</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_gender']); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_email']); ?></div>
        </div>
        <div class="col">
            <label for="phone">เบอร์โทร</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_phone']); ?></div>
        </div>
        <div class="col">
            <label for="birthdate">วัน/เดือน/ปี เกิด:</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;">
                <?php
                $date = date_create($row['cus_birthdate']);
                echo date_format($date, "d/m/Y");
                ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col">
            <label for="address">ที่อยู่</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_address']); ?></div>
        </div>
    </div>

</div>