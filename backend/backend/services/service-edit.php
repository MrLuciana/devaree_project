<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM services 
        INNER JOIN service_categories 
        WHERE services.service_cats_id = service_categories.service_cats_id 
        AND service_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" value="<?php echo $row['service_name']; ?>" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="price">ราคา</label>
            <input onkeyup="checkNull();" value="<?php echo $row['service_price']; ?>" type="number" id="price" class="form-control">
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
            <input onkeyup="checkNull();" value="<?php echo $row['service_description']; ?>"
                type="text" id="description" class="form-control">
        </div>
    </div>

</div>

<div class="modal-footer">
    <button onclick="serviceUpdate('<?php echo $id; ?>');" id="btnSubmit"
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

        if (name && price && description) {
            document.getElementById('btnSubmit').disabled = false;
        } else {
            document.getElementById('btnSubmit').disabled = true;
        }
    }

    document.getElementById('service_cats_id').addEventListener('change', checkNull); // ตรวจจับการเปลี่ยนแปลง service_cats_id

    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price').value = "";
        document.getElementById('description').value = "";
        document.getElementById('service_cats_id').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>