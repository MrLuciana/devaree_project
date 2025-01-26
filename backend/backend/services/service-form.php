<?php
require_once('../includes/conn.php');

// ดึงรหัสล่าสุด
$sql = "SELECT service_code FROM services ORDER BY service_code DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$lastCode = $result->fetch_assoc()['service_code'] ?? 'SERV000'; // ถ้าไม่มีรหัสใช้ค่าเริ่มต้น
$stmt->close();

// สร้างรหัสใหม่
$numberPart = (int)substr($lastCode, 4); // ตัดตัวอักษร 'SERV' ออก
$newNumberPart = str_pad($numberPart + 1, 3, '0', STR_PAD_LEFT); // เพิ่มเลข +1 และเติม 0 ซ้าย
$newServiceCode = 'SERV' . $newNumberPart;

?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="code">รหัสบริการ</label>
            <input type="text" id="code" class="form-control" value="<?php echo htmlspecialchars($newServiceCode); ?>" readonly>
        </div>

        <div class="col-8">
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="cats_id">หมวดหมู่</label>
            <select id="cats_id" class="form-control">
                <?php
                $sql = "SELECT * FROM categories WHERE cats_status = '1'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['cats_id']) . "'>" . htmlspecialchars($row['cats_name']) . "</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="price1">ราคา (1 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price1" class="form-control">
        </div>
        <div class="col">
            <label for="price2">ราคา (2 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price2" class="form-control">
        </div>
        <div class="col">
            <label for="price3">ราคา (3 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price3" class="form-control">
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
        const code = document.getElementById('code').value.trim();
        const name = document.getElementById('name').value.trim();
        const price1 = parseFloat(document.getElementById('price1').value.trim());
        const price2 = parseFloat(document.getElementById('price2').value.trim());
        const price3 = parseFloat(document.getElementById('price3').value.trim());
        const description = document.getElementById('description').value.trim();
        const cats_id = document.getElementById('cats_id').value.trim();
        const btnSubmit = document.getElementById('btnSubmit');

        if (code && name && price1 > 0 && price2 > 0 && price3 > 0 && description && cats_id) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }


    function clearForm() {
        document.getElementById('code').value = "";
        document.getElementById('name').value = "";
        document.getElementById('price1').value = "";
        document.getElementById('price2').value = "";
        document.getElementById('price3').value = "";
        document.getElementById('description').value = "";
        document.getElementById('cats_id').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>