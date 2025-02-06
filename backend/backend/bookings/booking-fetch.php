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
    c.cus_fname, e.emp_fname, s.ser_name, p.pac_name
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

$sql .= " ORDER BY b.boo_date DESC, b.boo_start_time DESC LIMIT $start, $perPage";
$result = $conn->query($sql);
if (!$result) {
    die("เกิดข้อผิดพลาดใน SQL: " . $conn->error);
}


if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table class="display table table-striped table-hover">
            <thead>
                <tr>
                    <th>รหัสการจอง</th>
                    <th>ลูกค้า</th>
                    <th>พนักงาน</th>
                    <th>บริการ</th>
                    <th>แพ็คเกจ</th>
                    <th>วันที่จอง</th>
                    <th>เวลาเริ่ม</th>
                    <th>จำนวนชั่วโมง</th>
                    <th>ยอดเงิน (บาท)</th>
                    <th>หมายเหตุ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['boo_id']; ?></td>
                        <td><?= $row['cus_fname']; ?></td>
                        <td><?= $row['emp_fname']; ?></td>
                        <td><?= $row['ser_name']; ?></td>
                        <td><?= $row['pac_name']; ?></td>
                        <td><?= $row['boo_date']; ?></td>
                        <td><?= $row['boo_start_time']; ?></td>
                        <td><?= $row['boo_hours']; ?> ชั่วโมง</td>
                        <td><?= number_format($row['boo_amount'], 2); ?></td>
                        <td><?= !empty($row['boo_notes']) ? $row['boo_notes'] : '-'; ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $row['boo_id']; ?>">แก้ไข</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['boo_id']; ?>">ลบ</button>
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