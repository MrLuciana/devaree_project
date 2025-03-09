<?php
require_once('../includes/conn.php');

// ✅ Query หลัก
$id = $_POST['id'];
$sql = "SELECT payments.pay_id, payments.pay_amount, payments.pay_status, payments.pay_method, payments.pay_transaction_date, payments.pay_receipt,
               customers.cus_fname, customers.cus_lname,
               services.ser_name, bookings.boo_date, bookings.boo_hours, bookings.boo_status
        FROM payments 
        LEFT JOIN bookings ON payments.boo_id = bookings.boo_id
        LEFT JOIN customers ON bookings.cus_id = customers.cus_id
        LEFT JOIN services ON bookings.ser_id = services.ser_id
        WHERE payments.pay_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>
<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col">
            <!-- ลูกค้า -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="customer">ชื่อลูกค้า</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row['cus_lname']); ?></div>
                </div>
                <!-- บริการ -->
                <div class="col">
                    <label for="service">บริการ</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['ser_name']); ?></div>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">วัน/เดือน/ปี ที่จอง</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?= date('d M Y', strtotime($row['boo_date'])); ?></div>
                </div>
                <div class="col">
                    <label for="hours">จำนวนชั่วโมง</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['boo_hours']); ?>&nbsp;ชม.</div>
                </div>
                <div class="col">
                    <label for="amount">ยอดเงิน (บาท)</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['pay_amount']); ?></div>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="method">วิธีการชำระเงิน</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['pay_method']); ?></div>
                </div>
            </div>
            <!-- หลักฐานการโอนเงิน -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="receipt">หลักฐานการโอนเงิน</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;">
                        <!-- ตรวจสอบว่า $row['pay_receipt'] มีค่าและเป็น URL ของภาพ -->
                        <?php if (!empty($row['pay_receipt'])): ?>
                            <img src="<?php echo htmlspecialchars($row['pay_receipt']); ?>" alt="หลักฐานการโอนเงิน" style="max-width: 100%; height: auto;">
                        <?php else: ?>
                            <p>ไม่มีหลักฐานการโอนเงิน</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>