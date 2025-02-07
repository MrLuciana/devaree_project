<?php
require_once('../includes/conn.php');

$perPage = isset($_POST['per_page']) ? intval($_POST['per_page']) : 5;
$page = isset($_POST['page_no']) ? intval($_POST['page_no']) : 1;
$start = ($page - 1) * $perPage;
$keyword = isset($_POST['keyword']) ? $conn->real_escape_string($_POST['keyword']) : '';

// ✅ Query หลัก
$sql = "SELECT 
    b.boo_id, b.cus_id, b.emp_id, b.ser_id, b.pac_id, 
    b.boo_date, b.boo_hours, b.boo_start_time, 
    b.boo_notes, b.boo_amount, b.boo_updated_at,
    c.cus_fname, c.cus_lname, s.ser_name, p.pac_name
FROM bookings AS b
LEFT JOIN customers AS c ON b.cus_id = c.cus_id
LEFT JOIN employees AS e ON b.emp_id = e.emp_id
LEFT JOIN services AS s ON b.ser_id = s.ser_id
LEFT JOIN packages AS p ON b.pac_id = p.pac_id";

if (!empty($keyword)) {
    $sql .= " WHERE 
        b.boo_id LIKE '%$keyword%' OR 
        c.cus_fname LIKE '%$keyword%' OR 
        e.emp_fname LIKE '%$keyword%' ";
}

$sql .= " ORDER BY b.boo_date ASC, b.boo_start_time ASC LIMIT $start, $perPage";
$result = $conn->query($sql);
if (!$result) {
    die("เกิดข้อผิดพลาดใน SQL: " . $conn->error);
}


if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table class="display table table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>ชื่อลูกค้า</th>
                    <th>บริการ</th>
                    <th>วันที่จอง</th>
                    <th>จำนวนชั่วโมง</th>
                    <th>ยอดเงิน (บาท)</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($i = $i + 1); ?></td>
                        <td><?= htmlspecialchars($row['cus_fname'] . " " . $row['cus_lname']); ?></td>
                        <td><?= htmlspecialchars($row['ser_name']); ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($row['boo_date'])); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['boo_hours']); ?> ชม.</td>
                        <td class="text-end"><?= is_numeric($row['boo_amount']) ? number_format($row['boo_amount'], 2) : '0.00'; ?></td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" onclick="bookingModalDetail('<?= htmlspecialchars($row['boo_id'], ENT_QUOTES); ?>');">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button data-toggle="modal" data-target="#IModal" class="btn btn-primary btn-sm" onclick="bookingModalEdit('<?= htmlspecialchars($row['boo_id'], ENT_QUOTES); ?>', 'แก้ไขข้อมูล');">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="bookingModalDelete('<?= htmlspecialchars($row['boo_id'], ENT_QUOTES); ?>');">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        $count_sql = "SELECT COUNT(*) AS total FROM bookings";
        $fetch_query = $conn->query($count_sql);
        $total_record = $fetch_query->fetch_assoc()['total'];
        $total_page = ceil($total_record / $perPage);
        ?>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="#" data-page="1">&laquo;&laquo;</a>
                </li>
                <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="#" data-page="<?= $page - 1; ?>">&laquo;</a>
                </li>

                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="#" data-page="<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?= $page == $total_page ? 'disabled' : ''; ?>">
                    <a class="page-link" href="#" data-page="<?= $page + 1; ?>">&raquo;</a>
                </li>
                <li class="page-item <?= $page == $total_page ? 'disabled' : ''; ?>">
                    <a class="page-link" href="#" data-page="<?= $total_page; ?>">&raquo;&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
<?php
} else {
    echo "<tr><td colspan='11' class='text-center text-muted'>ไม่มีข้อมูลบริการ</td></tr>";
}
?>