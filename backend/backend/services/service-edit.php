<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM services 
        INNER JOIN service_categories 
        ON services.service_cats_id = service_categories.service_cats_id 
        WHERE service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['service_name']); ?>" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="price">ราคา</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['service_price']); ?>" type="number" id="price" class="form-control">
        </div>
        <div class="col">
            <label for="service_cats_id">หมวดหมู่</label>
            <select id="service_cats_id" class="form-control">
                <?php
                $selected_service_cats = $row['service_cats_id'];
                $sql = "SELECT * FROM service_categories WHERE service_cats_status = '1'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row_service_cats = $result->fetch_assoc()) {
                    $selected = ($row_service_cats['service_cats_id'] == $selected_service_cats) ? 'selected' : '';
                ?>
                    <option value="<?php echo htmlspecialchars($row_service_cats['service_cats_id']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($row_service_cats['service_cats_name']); ?>
                    </option>
                <?php }
                $stmt->close();
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <label for="description">รายละเอียด</label>
            <input onkeyup="checkNull();" value="<?php echo htmlspecialchars($row['service_description']); ?>" type="text" id="description" class="form-control">
        </div>
    </div>
    <small id="formError" class="text-danger"></small>
</div>

<div class="modal-footer">
    <button onclick="serviceUpdate('<?php echo htmlspecialchars($id); ?>');" id="btnSubmit"
        data-bs-dismiss="modal" disabled class="btn btn-primary" style="font-size:12pt;width:150px;">
        อัปเดตรายการ
    </button>
    <button class="btn btn-light" onclick="clearForm();" style="font-size:12pt;width:100px;">
        เคลียร์
    </button>
</div>


<script>
    function checkNull() {
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();
        const description = document.getElementById('description').value.trim();
        const error = document.getElementById('formError');

        if (name && price && description) {
            document.getElementById('btnSubmit').disabled = false;
            error.textContent = ""; // ลบข้อความแจ้งเตือน
        } else {
            document.getElementById('btnSubmit').disabled = true;
            error.textContent = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
        }
    }

    document.getElementById('service_cats_id').addEventListener('change', checkNull);

    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price').value = "";
        document.getElementById('description').value = "";
        document.getElementById('service_cats_id').selectedIndex = 0;

        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('formError').textContent = "";
    }
</script>