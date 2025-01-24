<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM courses 
        INNER JOIN course_categories 
        ON courses.course_cats_id = course_categories.course_cats_id 
        WHERE course_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <label for="name">ชื่อบริการ</label>
            <input onkeyup="checkNull();" value="<?php echo $row['course_name']; ?>" type="text" id="name" class="form-control">
        </div>
        <div class="col">
            <label for="price">ราคา</label>
            <input onkeyup="checkNull();" value="<?php echo $row['course_price']; ?>" type="number" id="price" class="form-control">
        </div>
        <div class="col">
            <label for="course_cats_id">หมวดหมู่</label>
            <select id="course_cats_id" class="form-control">
                <?php
                $selected_course_cats = $row['course_cats_id'];
                $sql = "SELECT * FROM course_categories WHERE course_cats_status = '1'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row_course_cats = $result->fetch_assoc()) { 
                    $selected = ($row_course_cats['course_cats_id'] == $selected_course_cats) ? 'selected' : '';
                    ?>
                    <option value="<?php echo htmlspecialchars($row_course_cats['course_cats_id']); ?>"<?php echo $selected; ?>>
                        <?php echo htmlspecialchars($row_course_cats['course_cats_name']); ?>
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
            <input onkeyup="checkNull();" value="<?php echo $row['course_description']; ?>"
                type="text" id="description" class="form-control">
        </div>
    </div>

</div>

<div class="modal-footer">
    <button onclick="courseUpdate('<?php echo $id; ?>');" id="btnSubmit"
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

    document.getElementById('course_cats_id').addEventListener('change', checkNull); // ตรวจจับการเปลี่ยนแปลง course_cats_id

    function clearForm() {
        document.getElementById('name').value = "";
        document.getElementById('price').value = "";
        document.getElementById('description').value = "";
        document.getElementById('course_cats_id').value = "";

        document.getElementById('btnSubmit').disabled = true;
    }
</script>
