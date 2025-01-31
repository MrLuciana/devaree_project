<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM packages 
        INNER JOIN categories 
        ON packages.cat_id = categories.cat_id 
        WHERE pac_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="code">รหัสแพ็กเกจ</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_code']); ?>" type="text" id="code" class="form-control">
        </div>
        <div class="col-8">
            <label for="name">ชื่อแพ็กเกจ</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_name']); ?>" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="cat_id">หมวดหมู่</label>
            <select id="cat_id" class="form-control">
                <?php
                $sql = "SELECT * FROM categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row_cats = $result->fetch_assoc()) {
                ?>
                    <option value="<?php echo htmlspecialchars($row_cats['cat_id']); ?>">
                        <?php echo htmlspecialchars($row_cats['cat_name']); ?>
                    </option>
                <?php }
                $stmt->close();
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label for="price1">ราคา (1 ชม.)</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_price1']); ?>" type="number" id="price1" class="form-control">
        </div>
        <div class="col">
            <label for="price2">ราคา (2 ชม.)</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_price2']); ?>" type="number" id="price2" class="form-control">
        </div>
        <div class="col">
            <label for="price3">ราคา (3 ชม.)</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_price3']); ?>" type="number" id="price3" class="form-control">
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="description">รายละเอียด</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['pac_description']); ?>" type="text" id="description" class="form-control">
        </div>
    </div>
    <small id="formError" class="text-danger"></small>
</div>

<div class="modal-footer">
    <button onclick="packageUpdate('<?php echo htmlspecialchars($id); ?>');" id="btnSubmit"
        data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        อัปเดตรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>


<script>
    function checkNull() {
        const code = document.getElementById('code').value.trim();
        const name = document.getElementById('name').value.trim();
        const price1 = document.getElementById('price1').value.trim();
        const price2 = document.getElementById('price2').value.trim();
        const price3 = document.getElementById('price3').value.trim();
        const description = document.getElementById('description').value.trim();
        const error = document.getElementById('formError');

        if (code && name && price1 && price2 && price3 && description) {
            document.getElementById('btnSubmit').disabled = false;
            error.textContent = ""; // ลบข้อความแจ้งเตือน
        } else {
            document.getElementById('btnSubmit').disabled = true;
            error.textContent = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
        }
    }

    document.getElementById('cat_id').addEventListener('change', checkNull);

    function clearForm() {
        document.getElementById('code').value = "";
        document.getElementById('name').value = "";
        document.getElementById('price1').value = "";
        document.getElementById('price2').value = "";
        document.getElementById('price3').value = "";
        document.getElementById('description').value = "";
        document.getElementById('cat_id').selectedIndex = 0;

        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('formError').textContent = "";
    }
</script>