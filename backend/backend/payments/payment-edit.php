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
                    <select id="addBooking-customer" class="form-control">
                        <?php
                        $sql = "SELECT * FROM customers";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_cus = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row_cus['cus_id']); ?>" <?php if ($row['cus_id'] == $row_cus['cus_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_cus['cus_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row_cus['cus_lname']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                    </select>
                </div>
            </div>
            <!-- พนักงาน -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="addBooking-employee">พนักงาน</label>
                    <select id="addBooking-employee" class="form-control">
                        <?php
                        $sql = "SELECT * FROM employees";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_emp = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row_emp['emp_id']); ?>" <?php if ($row['emp_id'] == $row_emp['emp_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_emp['emp_fname']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row_emp['emp_lname']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                    </select>
                </div>
            </div>

            <!-- บริการ & แพ็กเกจ-->
            <div class="row mt-3 mb-3">
                <div class="col-8">
                    <label for="service">บริการ</label>
                    <select id="service" class="form-control">
                        <?php
                        $sql = "SELECT * FROM services";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_ser = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row_ser['ser_id']); ?>" data-price="<?php echo $row_ser['ser_price1']; ?>" <?php if ($row['ser_id'] == $row_ser['ser_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_ser['ser_name']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="package">แพ็กเกจที่ใช้งานได้</label>
                    <select id="package" class="form-control">
                        <?php
                        $sql = "SELECT * FROM packages";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_pac = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row_pac['pac_id']); ?>" data-price="<?php echo $row_pac['pac_price1']; ?>" <?php if ($row['pac_id'] == $row_pac['pac_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_pac['pac_name']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">วัน/เดือน/ปี ที่จอง</label>
                    <input type="date" id="date" class="form-control" value="<?php echo htmlspecialchars($row['boo_date']); ?>">
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="hour">ชั่วโมง</label>
                    <input type="number" id="hour" class="form-control" min="1"
                        value="<?php echo htmlspecialchars($row['boo_hours']); ?>"
                        oninput="this.value = Math.max(1, this.value);">
                        <!-- $boo_hours = max(1, intval($_POST['boo_hours'])); -->
                </div>
                <div class="col">
                    <label for="start_time">เวลาเริ่มต้น</label>
                    <input type="time" id="start_time" class="form-control" value="<?php echo htmlspecialchars($row['boo_start_time']); ?>">
                </div>
                <div class=" col">
                    <label for="method">วิธีชำระเงิน</label>
                    <select id="method" class="form-control">
                        <option value="cash" <?php if ($row['boo_method'] == "cash") echo "selected"; ?>>เงินสด</option>
                        <option value="bank_transfer" <?php if ($row['boo_method'] == "bank_transfer") echo "selected"; ?>>โอนเงิน</option>
                    </select>
                </div>
            </div>
            <div class=" row mt-3 mb-3">
                <div class="col">
                    <label for="notes">หมายเหตุเพิ่มเติม</label>
                    <textarea id="notes" class="form-control" onkeyup="checkNull();"><?php echo htmlspecialchars($row['boo_notes']); ?></textarea>
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
                    <button id="submitBtn" class="btn btn-primary w-100" onclick="bookingUpdate();" disabled>✅ ยืนยันการจอง</button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function checkNull() {
        let fields = ["addBooking-customer", "addBooking-employee", "package", "service", "date", "hour", "start_time", "method"];
        let isFilled = fields.every(id => {
            let el = document.getElementById(id);
            if (!el) console.warn(`❗ ไม่พบ Element ที่มี ID: ${id}`);
            return el && el.value && el.value.trim() !== "";
        });
        document.getElementById("submitBtn").disabled = !isFilled;
    }

    function updatePrice() {
        let serviceSelect = document.getElementById("service");
        let packageSelect = document.getElementById("package");
        let hourInput = document.getElementById("hour");

        // ดึงข้อมูลที่เลือก
        let serviceName = serviceSelect.selectedOptions[0]?.textContent || "-";
        let packageName = packageSelect.selectedOptions[0]?.textContent || "-";
        let servicePricePerHour = parseFloat(serviceSelect.selectedOptions[0]?.getAttribute("data-price")) || 0;
        let packagePrice = parseFloat(packageSelect.selectedOptions[0]?.getAttribute("data-price")) || 0;
        let hours = parseInt(hourInput.value) || 1;

        // คำนวณราคาทั้งหมด
        let serviceTotalPrice = servicePricePerHour * hours;
        let totalPrice = serviceTotalPrice + packagePrice;

        // 🎯 อัปเดตข้อมูลสรุปยอด
        document.getElementById("summary_service").innerText = serviceName;
        document.getElementById("summary_package").innerText = packageName;
        document.getElementById("summary_hours").innerText = hours;

        document.getElementById("service_price").innerText = serviceTotalPrice.toLocaleString();
        document.getElementById("package_price").innerText = packagePrice.toLocaleString();
        document.getElementById("total_price").innerText = totalPrice.toLocaleString();
    }

    // ⭐ เพิ่ม Event Listener สำหรับ input เพื่ออัปเดตสรุปยอดอัตโนมัติ
    ["hour", "service", "package", "addBooking-customer", "addBooking-employee", "date", "start_time", "notes", "method"].forEach(id => {
        document.getElementById(id).addEventListener("change", () => {
            updatePrice();
            checkNull();
        });
    });
</script>