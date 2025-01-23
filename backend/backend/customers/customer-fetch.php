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
    $sql = "SELECT * FROM customers 
            WHERE customer_fname LIKE '%{$keyword}%' 
            OR customer_lname LIKE '%{$keyword}%' 
            OR customer_email LIKE '%{$keyword}%' 
            OR customer_phone LIKE '%{$keyword}%' 
            OR customer_address LIKE '%{$keyword}%' 
            OR customer_city LIKE '%{$keyword}%' 
            ORDER BY customer_id DESC 
            LIMIT $start, $perPage";
} else {
    $sql = "SELECT * FROM customers ORDER BY customer_id DESC LIMIT $start, $perPage";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table id="basic-datatables" class="display table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%;">#</th>
                    <th scope="col" style="width: 15%;">ชื่อ-สกุล</th>
                    <th scope="col" style="width: 30%;">อีเมล</th>
                    <th scope="col" style="width: 15%;">เบอร์โทร</th>
                    <th scope="col" style="width: 10%;">ที่อยู่</th>
                    <th scope="col" style="width: 5%;">เมือง</th>
                    <th scope="col" style="width: 15%;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($i = $i + 1); ?></td>
                        <td><?php echo htmlspecialchars($row["customer_fname"] . " " . $row["customer_lname"]); ?></td>
                        <td><?php echo htmlspecialchars($row["customer_email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["customer_phone"]); ?></td>
                        <td><?php echo htmlspecialchars($row["customer_address"]); ?></td>
                        <td><?php echo htmlspecialchars($row["customer_city"]); ?></td>
                        <td>
                            <button data-toggle="modal" data-target="#IModal" class="btn btn-primary btn-sm" onclick="customerModalEdit('<?php echo $row['customer_id']; ?>','แก้ไขข้อมูล');">แก้ไข</button>
                            <button class="btn btn-danger btn-sm" onclick="customerModalDelete('<?php echo $row['customer_id']; ?>');">ลบ</button>
                        </td>
                    </tr><?php } ?>
            </tbody>
        </table>
        <?php
        $sql = "SELECT * FROM customers ORDER BY customer_id DESC";
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
    echo "<tr><td colspan='7' class='text-center text-muted'>ไม่มีข้อมูลบริการ</td></tr>";
}
?>