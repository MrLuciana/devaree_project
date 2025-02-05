<?php
require_once('../includes/conn.php');

$id = isset($_POST['id']) ? $_POST['id'] : '';

if (empty($id)) {
    die("Error: ไม่พบ ID พนักงาน");
}

$sql = "SELECT * FROM employees 
        WHERE emp_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="fname">ชื่อจริง</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_fname']); ?></div>
        </div>
        <div class="col">
            <label for="lname">นามสกุล</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_lname']); ?></div>
        </div>
        <div class="col">
            <label for="gender">เพศ:</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_gender']); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_email']); ?></div>
        </div>
        <div class="col">
            <label for="phone">เบอร์โทร</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_phone']); ?></div>
        </div>
        <div class="col">
            <label for="hire_date">วันที่เริ่มงาน:</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;">
                <?php
                $date = date_create($row['emp_hire_date']);
                echo date_format($date, "d/m/Y");
                ?>
            </div>
        </div>
    </div>
</div>