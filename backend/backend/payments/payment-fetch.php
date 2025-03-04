<?php
require_once('../includes/conn.php');

$perPage = isset($_POST['per_page']) ? intval($_POST['per_page']) : 5;
$page = isset($_POST['page_no']) ? intval($_POST['page_no']) : 1;
$start = ($page - 1) * $perPage;
// ✅ Query หลัก
$sql = "SELECT * FROM payments 
        LEFT JOIN bookings ON payments.boo_id = bookings.boo_id
        LEFT JOIN customers ON bookings.cus_id = customers.cus_id
        LEFT JOIN services ON bookings.ser_id = services.ser_id
        ORDER BY payments.pay_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table class="display table table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 5%;">#</th>
                    <th scope="col" style="width: 14%;">ชื่อลูกค้า</th>
                    <th scope="col" style="width: 15%;">บริการ</th>
                    <th scope="col" style="width: 15%;">วันที่จอง</th>
                    <th scope="col" style="width: 10%;">จำนวนชั่วโมง</th>
                    <th scope="col" style="width: 10%;">ยอดเงิน (บาท)</th>
                    <th scope="col" style="width: 15%;">สถานะ</th>
                    <th scope="col" style="width: 15%;">จัดการ</th>
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
                        <td class="text-center"><?= date('d M Y', strtotime($row['boo_date'])); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['boo_hours']); ?> ชม.</td>
                        <td class="text-end"><?= is_numeric($row['boo_amount']) ? number_format($row['pay_amount'], 2) : '0.00'; ?></td>
                        <td class="text-center">
                            <select name="pay_status" class="form-select status-select" data-pay_id="<?= $row['pay_id']; ?>">
                                <option value="pending" <?= $row['pay_status'] == 'pending' ? 'selected' : ''; ?>>⏳ Pending</option>
                                <option value="confirmed" <?= $row['pay_status'] == 'paid' ? 'selected' : ''; ?>>✅ paid</option>
                                <option value="canceled" <?= $row['pay_status'] == 'canceled' ? 'selected' : ''; ?>>❌ Canceled</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" onclick="bookingModalDetail('<?= htmlspecialchars($row['boo_id'], ENT_QUOTES); ?>', 'รายละเอียดการชำระเงิน');">
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
        $count_sql = "SELECT COUNT(*) AS total FROM payments";
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