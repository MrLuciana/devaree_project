<?php
require_once('../includes/conn.php');

$id = $_POST['id'];
$sql = "SELECT * FROM bookings
    INNER JOIN customers ON bookings.cus_id = customers.cus_id
    INNER JOIN employees ON bookings.emp_id = employees.emp_id
    INNER JOIN services ON bookings.ser_id = services.ser_id
    INNER JOIN packages ON bookings.pac_id = packages.pac_id
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
                    <label for="addBooking-employee">พนักงาน</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['emp_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row['emp_lname']); ?></div>
                </div>
            </div>

            <!-- บริการ & แพ็กเกจ-->
            <div class="row mt-3 mb-3">
                <div class="col-8">
                    <label for="service">บริการ</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['ser_name']); ?></div>
                </div>
                <div class="col">
                    <label for="package">แพ็กเกจที่ใช้งานได้</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo htmlspecialchars($row['pac_name']); ?></div>
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
                    <label for="hour">ชั่วโมง</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['boo_hours']; ?>&nbsp;ชม.</div>
                </div>
                <div class="col">
                    <label for="start_time">เวลาเริ่มต้น</label>
                    <div style="border:solid 1px #ddd; padding:5px 10px;"><?php echo $row['boo_start_time']; ?></div>
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
                        <span><b>บริการ:</b></span>
                        <span id="summary_service"><?php echo htmlspecialchars($row['ser_name']); ?></span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>ราคา/ชั่วโมง:</b></span>
                        <span id="service_price"><?php echo $row['ser_price1']; ?></span> บาท
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>แพ็กเกจ:</b></span>
                        <span id="summary_package"><?php echo htmlspecialchars($row['pac_name']); ?></span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>ราคาแพ็กเกจ:</b></span>
                        <span id="package_price"><?php echo $row['pac_price1']; ?></span> บาท
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>จำนวนชั่วโมง:</b></span>
                        <span id="summary_hours"><?php echo $row['boo_hours']; ?></span> ชม.
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0"><b>รวมทั้งสิ้น:</b></h5>
                        <h5 class="m-0 text-danger"><b><span id="total_price"><?php echo $row['boo_amount']; ?></span> บาท</b></h5>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>