<?php
require_once('../includes/conn.php');

$perPage = isset($_POST['per_page']) ? intval($_POST['per_page']) : 5;
$page = isset($_POST['page_no']) ? intval($_POST['page_no']) : 1;
$start = ($page - 1) * $perPage;
$keyword = isset($_POST['keyword']) ? $conn->real_escape_string($_POST['keyword']) : '';

// ✅ Query หลัก
$sql = "SELECT 
    b.boo_id, b.cus_id, b.ser_id, b.pac_id, 
    b.boo_date, b.boo_hours, b.boo_start_time, 
    b.boo_status, b.boo_amount, b.boo_updated_at,
    s.ser_name, p.pac_name
FROM bookings AS b
LEFT JOIN customers AS c ON b.cus_id = c.cus_id
LEFT JOIN employees AS e ON b.emp_id = e.emp_id
LEFT JOIN services AS s ON b.ser_id = s.ser_id
LEFT JOIN packages AS p ON b.pac_id = p.pac_id";

$sql .= " WHERE b.cus_id = '" . $_POST['id'] . "' ORDER BY b.boo_date ASC, b.boo_start_time ASC LIMIT $start, $perPage";
$result = $conn->query($sql);
if (!$result) {
    die("เกิดข้อผิดพลาดใน SQL: " . $conn->error);
}

if ($result->num_rows > 0) { ?>
    <div class="table-responsive-lg">
        <table class="display table table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 5%;">#</th>
                    <th scope="col" style="width: 15%;">บริการ</th>
                    <th scope="col" style="width: 15%;">วันที่จอง</th>
                    <th scope="col" style="width: 10%;">จำนวนชั่วโมง</th>
                    <th scope="col" style="width: 10%;">ยอดเงิน (บาท)</th>
                    <th scope="col" style="width: 15%;">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($i = $i + 1); ?></td>
                        <td><?= htmlspecialchars($row['ser_name']); ?></td>
                        <td class="text-center"><?= date('d M Y', strtotime($row['boo_date'])); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['boo_hours']); ?> ชม.</td>
                        <td class="text-end"><?= is_numeric($row['boo_amount']) ? number_format($row['boo_amount'], 2) : '0.00'; ?></td>
                        <td class="text-center">
                            <select name="boo_status" class="form-select status-select" data-boo_id="<?= $row['boo_id']; ?>">
                                <option value="pending" <?= $row['boo_status'] == 'pending' ? 'selected' : ''; ?>>⏳ Pending</option>
                                <option value="confirmed" <?= $row['boo_status'] == 'confirmed' ? 'selected' : ''; ?>>✅ Confirmed</option>
                                <option value="canceled" <?= $row['boo_status'] == 'canceled' ? 'selected' : ''; ?>>❌ Canceled</option>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo "<tr><td colspan='11' class='text-center text-muted'>ไม่มีข้อมูลบริการ</td></tr>";
}
?>