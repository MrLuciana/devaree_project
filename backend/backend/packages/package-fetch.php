<?php
if (isset($_POST['per_page'])) {
    $perPage = $_POST['per_page'];
} else {
    $perPage = 5;
}
if (isset($_POST['page_no'])) {
    $page = $_POST['page_no'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perPage;
// echo $page;
$keyword = $_POST['keyword'];

require_once('../includes/conn.php');

if (!empty($keyword)) {
    $sql = "SELECT * FROM packages INNER JOIN categories ON packages.cat_id = categories.cat_id WHERE (pac_code LIKE '%{$keyword}%' OR pac_name LIKE '%{$keyword}%') ORDER BY pac_id DESC LIMIT $start, $perPage";
} else {
    $sql = "SELECT * FROM packages INNER JOIN categories ON packages.cat_id = categories.cat_id ORDER BY pac_id DESC LIMIT $start, $perPage";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table id="basic-datatables" class="display table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 3%;">รหัส</th>
                    <th scope="col" style="width: 15%;">ชื่อแพ็กเกจ</th>
                    <th scope="col" style="width: 10%;">ราคา (1 ชม.)</th>
                    <th scope="col" style="width: 10%;">ราคา (2 ชม.)</th>
                    <th scope="col" style="width: 10%;">ราคา (3 ชม.)</th>
                    <th scope="col" style="width: 8%;">หมวดหมู่</th>
                    <th scope="col" style="width: 5%;">สถานะ</th>
                    <th scope="col" style="width: 15%;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["pac_code"]); ?></td>
                        <td><?php echo htmlspecialchars($row["pac_name"]); ?></td>
                        <td><?php echo number_format($row["pac_price1"]); ?></td>
                        <td><?php echo number_format($row["pac_price2"]); ?></td>
                        <td><?php echo number_format($row["pac_price3"]); ?></td>
                        <td><?php echo htmlspecialchars($row["cat_name"]); ?></td>
                        <td>
                            <?php
                            $active = ($row['pac_active'] == 'yes') ? 'yes' : 'no'; // ตรวจสอบค่า active
                            ?>
                            <button id="activeButton<?php echo $row['pac_id']; ?>"
                                class="btn btn-<?php echo ($active == 'yes') ? 'success' : 'danger'; ?> btn-sm"
                                onclick="toggleActive(<?php echo $row['pac_id']; ?>, '<?php echo $active; ?>')">
                                <?php echo ($active == 'yes') ? 'เปิด' : 'ปิด'; ?>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="packageModalDetail('<?php echo $row['pac_id']; ?>');"><i class="fas fa-eye"></i></button>
                            <button data-toggle="modal" data-target="#IModal" class="btn btn-primary btn-sm" onclick="packageModalEdit('<?php echo $row['pac_id']; ?>','แก้ไขข้อมูล');"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="packageModalDelete('<?php echo $row['pac_id']; ?>');"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr><?php } ?>
            </tbody>
        </table>
        <?php
        $sql = "SELECT * FROM packages INNER JOIN categories WHERE packages.cat_id = categories.cat_id ORDER BY pac_id DESC";
        $fetch_query = $conn->query($sql);
        $total_record = mysqli_num_rows($fetch_query);
        $total_page = ceil($total_record / $perPage);
        ?>
        <div class="row">
            <div class="col">
                <nav>
                    <ul class="pagination justify-content-center"> <!-- เพิ่ม justify-content-center -->
                        <?php
                        $range_page = 2;
                        $last_show_page = $page + $range_page;
                        if ($last_show_page > $total_page) {
                            $count_last = $last_show_page - $total_page;
                            $first_show_page = $page - ($range_page + $count_last);
                            $last_show_page = $total_page;
                        } else if ($last_show_page <= $total_page) {
                            $first_show_page = $page - $range_page;
                        }
                        if ($first_show_page < 1) {
                            $first_show_page = 1;
                            $count_first = $page - $first_show_page;
                            $last_show_page = $page + (($range_page * 2) - $count_first);
                            if ($last_show_page > $total_page) {
                                $last_show_page = $total_page;
                            }
                        }
                        ($page == 1) ? $set_disable_back = "disabled" : $set_disable_back = "";
                        ($page == $total_page) ? $set_disable_next = "disabled" : $set_disable_next = "";
                        ?>
                        <li class="page-item <?php echo $set_disable_back; ?>">
                            <a class="page-link" id="1" aria-label="Previous">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?php echo $set_disable_back; ?>">
                            <a class="page-link" id="<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = $first_show_page; $i <= $last_show_page; $i++) {
                            ($i == $page) ? $active = "active" : $active = "";
                        ?>
                            <li class="page-item <?php echo $active; ?>" style="width: 36pt;">
                                <a class="page-link" id="<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php echo $set_disable_next; ?>">
                            <a class="page-link" id="<?php echo ($page < $total_page) ? $page + 1 : $total_page; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?php echo $set_disable_next; ?>">
                            <a class="page-link" id="<?php echo $total_page; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

<?php
} else {
    echo "<tr><td colspan='7' class='text-center text-muted'>ไม่มีข้อมูลแพ็กเกจ</td></tr>";
}
?>