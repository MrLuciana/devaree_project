<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM bookings
    INNER JOIN customers ON bookings.cus_id = customers.cus_id
    INNER JOIN employees ON bookings.emp_id = employees.emp_id
    LEFT JOIN services ON bookings.ser_id = services.ser_id
    LEFT JOIN packages ON bookings.pac_id = packages.pac_id
    WHERE bookings.boo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col-7">
            <!-- ลูกค้า -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="addBooking-customer">ชื่อลูกค้า</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['cus_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row['cus_lname']); ?></div>
                </div>
            </div>
            <!-- พนักงาน -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="addBooking-employee">ชื่อพนักงาน</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row['emp_lname']); ?></div>
                </div>
            </div>

            <!-- บริการ & แพ็กเกจ-->
            <div class="row mt-3 mb-3">
                <div class="col-8">
                    <label for="serpac">บริการ & แพ็กเกจ</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['ser_name'] ?? $row['pac_name']); ?></div>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">วัน/เดือน/ปี ที่จอง</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['boo_date']; ?></div>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="hour">ชั่วโมงที่จอง</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;">
                        <?php
                        if (!empty($row['boo_ser_hours'])) {
                            echo htmlspecialchars($row['boo_ser_hours']);
                        } else {
                            echo htmlspecialchars($row['boo_pac_hours']);
                        }
                        ?>&nbsp;ชม.</div>
                </div>
                <div class="col">
                    <label for="start_time">เริ่มเวลา</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['boo_res_time']; ?></div>
                </div>
                <div class=" col">
                    <label for="method">วิธีชำระเงิน</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;">
                        <?php
                        $method_map = [
                            "cash" => "เงินสด",
                            "bank_transfer" => "โอนเงิน"
                        ];
                        echo isset($method_map[$row["boo_method"]]) ? $method_map[$row["boo_method"]] : "ไม่ระบุ";
                        ?>
                    </div>
                </div>
            </div>
            <div class=" row mt-3 mb-3">
                <div class="col">
                    <label for="notes">หมายเหตุเพิ่มเติม</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;">
                        <?php echo !empty($row['boo_notes']) ? $row['boo_notes'] : "ไม่มีรายละเอียด"; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ส่วนสรุปยอด -->
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3">📋 สรุปยอดการจอง</h5>
                    <hr>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>บริการ & แพ็กเกจ:</b></span>
                        <span id="summary_type"><?php echo htmlspecialchars($row['ser_name'] ?? $row['pac_name']); ?></span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>ราคา:</b></span>
                        <span id="summary_price"><?php echo $row['boo_amount']; ?></span> บาท
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>จำนวนชั่วโมง:</b></span>
                        <span id="summary_hours">
                            <?php
                            if (!empty($row['boo_ser_hours'])) {
                                echo htmlspecialchars($row['boo_ser_hours']);
                            } else {
                                echo htmlspecialchars($row['boo_pac_hours']);
                            }
                            ?></span> ชม.
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0"><b>รวมทั้งสิ้น:</b></h5>
                        <h5 class="m-0 text-danger"><b><span id="total_price"><?php echo $row['boo_amount']; ?></span> บาท</b></h5>
                    </div>
                    <hr>
                    <h5 class="card-title text-center mb-3">หลักฐานการโอนเงิน</h5>
                    <div class="text-center">
                        <?php if (!empty($row['boo_receipt'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($row['boo_receipt'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="img-fluid"
                                alt="receipt"
                                style="max-height: 200px;">
                        <?php else: ?>
                            <p class="text-muted">ไม่มีหลักฐานการโอนเงิน</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>