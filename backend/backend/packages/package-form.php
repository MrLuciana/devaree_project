<?php
require_once('../includes/conn.php');

// ดึงรหัสล่าสุด
$sql = "SELECT pac_code FROM packages ORDER BY pac_code DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$lastCode = $result->fetch_assoc()['pac_code'] ?? 'SERV000'; // ถ้าไม่มีรหัสใช้ค่าเริ่มต้น
$stmt->close();

// สร้างรหัสใหม่
$numberPart = (int)substr($lastCode, 4); // ตัดตัวอักษร 'SERV' ออก
$newNumberPart = str_pad($numberPart + 1, 3, '0', STR_PAD_LEFT); // เพิ่มเลข +1 และเติม 0 ซ้าย
$newpackageCode = 'PACK' . $newNumberPart;

?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="code">รหัสแพ็กเกจ</label>
            <input type="text" id="code" class="form-control" value="<?php echo htmlspecialchars($newpackageCode); ?>" readonly>
        </div>

        <div class="col-8">
            <label for="name">ชื่อแพ็กเกจ</label>
            <input onkeyup="checkNull();" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="cat_id">หมวดหมู่</label>
            <select id="cat_id" class="form-control">
                <?php
                $sql = "SELECT * FROM categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['cat_id']) . "'>" . htmlspecialchars($row['cat_name']) . "</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label>
                <input type="checkbox" id="enablePrice1" onchange="toggleInput('price1', this.checked)">
            </label>
            <label for="price1">ราคา (1 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price1" class="form-control" disabled>
        </div>
        <div class="col">
            <label>
                <input type="checkbox" id="enablePrice2" onchange="toggleInput('price2', this.checked)">
            </label>
            <label for="price2">ราคา (2 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price2" class="form-control" disabled>
        </div>
        <div class="col">
            <label>
                <input type="checkbox" id="enablePrice3" onchange="toggleInput('price3', this.checked)">
            </label>
            <label for="price3">ราคา (3 ชม.)</label>
            <input onkeyup="checkNull();" type="number" id="price3" class="form-control" disabled>
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
    <button onclick="packageAdd();" id="btnSubmit" data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
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
        const description = document.getElementById('description').value.trim();
        const cat_id = document.getElementById('cat_id').value.trim();

        const price1 = document.getElementById('price1').disabled ? true : parseFloat(document.getElementById('price1').value.trim()) > 0;
        const price2 = document.getElementById('price2').disabled ? true : parseFloat(document.getElementById('price2').value.trim()) > 0;
        const price3 = document.getElementById('price3').disabled ? true : parseFloat(document.getElementById('price3').value.trim()) > 0;

        const btnSubmit = document.getElementById('btnSubmit');

        if (code && name && description && cat_id && price1 && price2 && price3) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }

    function toggleInput(inputId, isEnabled) {
        const input = document.getElementById(inputId);
        input.disabled = !isEnabled;
        if (!isEnabled) {
            input.value = ""; // รีเซ็ตค่าเมื่อปิด
        }
    }

    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price1').value = "";
        document.getElementById('price2').value = "";
        document.getElementById('price3').value = "";
        document.getElementById('description').value = "";
        document.getElementById('cat_id').value = "";

        document.getElementById('enablePrice1').checked = false;
        document.getElementById('enablePrice2').checked = false;
        document.getElementById('enablePrice3').checked = false;

        toggleInput('price1', false);
        toggleInput('price2', false);
        toggleInput('price3', false);

        document.getElementById('btnSubmit').disabled = true;
    }
</script>