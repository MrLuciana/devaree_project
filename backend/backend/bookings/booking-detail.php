<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM bookings 
        INNER JOIN categories 
        ON bookings.cat_id = categories.cat_id 
        WHERE boo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="code">รหัสบริการ</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_code']); ?></div>
        </div>
        <div class="col-8">
            <label for="name">ชื่อบริการ</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_name']); ?></div>
        </div>
        <div class="col">
            <label for="cat_id">หมวดหมู่</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cat_name']); ?></div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="price1">ราคา (1 ชม.)</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_price1']); ?></div>
        </div>
        <div class="col">
            <label for="price2">ราคา (2 ชม.)</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_price2']); ?></div>
        </div>
        <div class="col">
            <label for="price3">ราคา (3 ชม.)</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_price3']); ?></div>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="description">รายละเอียด</label>
            <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_description']); ?></div
        </div>
    </div>
    <small id="formError" class="text-danger"></small>
</div>