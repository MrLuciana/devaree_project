<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM categories WHERE cat_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" value="<?php echo $row['cat_name']; ?>" type="text" id="name" class="form-control">
        </div>
    </div>
</div>

<div class="modal-footer">
    <button onclick="catUpdate('<?php echo $id; ?>');" id="btnSubmit"
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

        if (name) {
            document.getElementById('btnSubmit').disabled = false;
        } else {
            document.getElementById('btnSubmit').disabled = true;
        }
    }

    function clearForm() {
        document.getElementById('name').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>
