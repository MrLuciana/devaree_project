<?php
if (isset($_POST['per_page'])) {
    $perPage = intval($_POST['per_page']); // ป้องกัน SQL Injection
} else {
    $perPage = 5;
}
if (isset($_POST['page_no'])) {
    $page = intval($_POST['page_no']);
} else {
    $page = 1;
}

require_once("../includes/conn.php");

$start = ($page - 1) * $perPage;

// ตรวจสอบค่าหน้าไม่ให้เกินขอบเขต
$sql_count = "SELECT COUNT(*) as total FROM services";
$total_result = $conn->query($sql_count);
$total_row = $total_result->fetch_assoc();
$total_record = intval($total_row['total']);
$total_page = ceil($total_record / $perPage);

if ($page < 1) $page = 1;
if ($page > $total_page) $page = $total_page;

$sql = "SELECT * FROM services LIMIT $start, $perPage";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>

    <table class="display table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อบริการ</th>
                <th>รายละเอียด</th>
                <th>ราคา (บาท)</th>
                <th>หมวดหมู่</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = $start + 1;
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo htmlspecialchars($no); ?></th>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_description']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_category']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_status']); ?></td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="modal" data-target="#IModal"
                                onclick="serviceModalDetail(<?php echo htmlspecialchars($row['service_id']); ?> , 'แสดงรายละเอียด')"
                                class="btn btn-primary">
                                <i class="fas fa-eye"></i></button>
                            <button data-toggle="modal" data-target="#IModal"
                                onclick="serviceModalEdit(<?php echo htmlspecialchars($row['service_id']); ?> , 'แก้ไขข้อมูล')"
                                class="btn btn-success"><i class="fas fa-edit"></i></button>
                            <button onclick="serviceModalDelete(<?php echo htmlspecialchars($row['service_id']); ?>)" class=" btn btn-danger">
                                <i class="fas fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
            <?php
                $no++;
            } ?>
        </tbody>
    </table>
    <hr style="margin-top:-16px;">
    <nav class="text-center">
        <ul class="pagination">
            <li class="page-item <?php echo ($page == 1) ? "disabled" : ""; ?>">
                <a class="page-link" id="1" aria-label="First">&laquo;&laquo;</a>
            </li>
            <li class="page-item <?php echo ($page == 1) ? "disabled" : ""; ?>">
                <a class="page-link" id="<?php echo $page - 1; ?>" aria-label="Previous">&laquo;</a>
            </li>
            <?php
            for ($i = 1; $i <= $total_page; $i++) {
                $active = ($i == $page) ? "active" : "";
                echo "<li class='page-item $active'><a class='page-link' id='$i'>$i</a></li>";
            }
            ?>
            <li class="page-item <?php echo ($page == $total_page) ? "disabled" : ""; ?>">
                <a class="page-link" id="<?php echo $page + 1; ?>" aria-label="Next">&raquo;</a>
            </li>
            <li class="page-item <?php echo ($page == $total_page) ? "disabled" : ""; ?>">
                <a class="page-link" id="<?php echo $total_page; ?>" aria-label="Last">&raquo;&raquo;</a>
            </li>
        </ul>
    </nav>

<?php
} else {
    echo "<p class='text-center'>ไม่พบรายการ</p>";
}
?>