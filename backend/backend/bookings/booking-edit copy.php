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
                    <label for="editBooking-customer">ชื่อลูกค้า</label>
                    <select id="editBooking-customer" class="form-control">
                        <?php
                        $sql = "SELECT * FROM customers";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_cus = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row_cus['cus_id']; ?>" <?php if ($row['cus_id'] == $row_cus['cus_id']) echo "selected"; ?>>
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
                    <label for="editBooking-employee">ชื่อพนักงาน</label>
                    <select id="editBooking-employee" class="form-control">
                        <?php
                        $sql = "SELECT * FROM employees";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_emp = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row_emp['emp_id']; ?>" <?php if ($row['emp_id'] == $row_emp['emp_id']) echo "selected"; ?>>
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
                    <label for="serpac">บริการ & แพ็กเกจ</label>
                    <select id="serpac" class="form-control">
                        <option value="" disabled>---------บริการ---------</option>
                        <?php
                        $sql = "SELECT * FROM services";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_ser = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row_ser['ser_id']; ?>" <?php if ($row['ser_id'] == $row_ser['ser_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_ser['ser_name']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                        <option value="" disabled>---------แพ็กเกจ---------</option>
                        <?php
                        $sql = "SELECT * FROM packages";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row_pac = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row_pac['pac_id']; ?>" <?php if ($row['pac_id'] == $row_pac['pac_id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row_pac['pac_name']); ?>
                            </option>
                        <?php }
                        $stmt->close();
                        ?>
                    </select>
                </div>
            </div>

            <!-- วัน/เดือน/ปี ที่จอง -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">วัน/เดือน/ปี ที่จอง</label>
                    <input value="<?php echo $row['boo_date']; ?>" type="text" id="reserve_date" class="form-control" onfocus="datePicker();">
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">เริ่มเวลา</label>
                    <input value="<?php echo $row['boo_res_time']; ?>" type="text" id="reserve_time" class="form-control" onfocus="timePicker();">
                </div>
                <div class="col">
                    <label for="method">วิธีชำระเงิน</label>
                    <select id="method" class="form-control">
                        <option value="cash" <?php echo ($row['boo_method'] == 'cash') ? 'selected' : ''; ?>>เงินสด</option>
                        <option value="bank_transfer" <?php echo ($row['boo_method'] == 'bank_transfer') ? 'selected' : ''; ?>>โอนเงิน</option>
                    </select>
                </div>

            </div>
            <div class=" row mt-3 mb-3">
                <div class="col">
                    <label for="notes">หมายเหตุเพิ่มเติม</label>
                    <textarea id="notes" class="form-control" rows="3"><?php echo !empty($row['boo_notes']) ? $row['boo_notes'] : "ไม่มีรายละเอียด"; ?></textarea>
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
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="updateBooking" onclick="bookingUpdate('<?php echo $id; ?>');">บันทึกการจอง</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updatePrice() {
        let selectionType = document.getElementById('selection_type').value;
        let serviceSelect = document.getElementById("service");
        let packageSelect = document.getElementById("package");
        let serviceHour = document.getElementById("service_hours");
        let packageHour = document.getElementById("package_hours");

        let selectName = "-";
        let selectHour = "-";
        let selectPrice = "-";

        if (selectionType === 'service' && serviceSelect.value) {
            let selectedOption = serviceSelect.selectedOptions[0];
            let price1 = parseFloat(selectedOption.getAttribute("data-price1")) || 0;
            let price2 = parseFloat(selectedOption.getAttribute("data-price2")) || 0;
            let price3 = parseFloat(selectedOption.getAttribute("data-price3")) || 0;

            selectName = selectedOption.textContent;
            selectPrice = serviceHour.value === "1" ? price1 : serviceHour.value === "2" ? price2 : price3;
            selectHour = serviceHour.value;
        } else if (selectionType === 'package' && packageSelect.value) {
            let selectedOption = packageSelect.selectedOptions[0];
            selectName = selectedOption.textContent;
            selectPrice = parseFloat(selectedOption.getAttribute("data-price")) || 0;
            selectHour = packageHour.textContent;
        }

        document.getElementById("summary_type").innerText = selectionType === "service" ? "บริการ" : "แพ็กเกจ";
        document.getElementById("summary_name").innerText = selectName;
        document.getElementById("summary_price").innerText = selectPrice.toLocaleString();
        document.getElementById("summary_hours").innerText = selectHour;
        document.getElementById("total_price").innerText = selectPrice.toLocaleString();

    }

    // Event Listener สำหรับการเปลี่ยนค่า
    ["service", "package", "selection_type"].forEach(id => {
        document.getElementById(id).addEventListener("change", () => {
            updatePrice();
            // checkNull();
        });
    });
    // แก้ไข serviceHourChange ให้ถูกต้อง
    function serviceHourChange() {
        let selectedOption = document.getElementById("service").selectedOptions[0];
        if (!selectedOption) return;

        let price1 = selectedOption.getAttribute("data-price1");
        let price2 = selectedOption.getAttribute("data-price2");
        let price3 = selectedOption.getAttribute("data-price3");

        document.getElementById("service_hours").value = 1;

        document.getElementById("service_hours").addEventListener("change", function() {
            let hours = this.value;
            console.log("จำนวนชั่วโมงที่เลือก:", hours);
            updatePrice();
        });

        updatePrice();
        // checkNull();
    }

    function updatePackageHours() {
        let packageSelect = document.getElementById("package");
        let selectedOption = packageSelect.selectedOptions[0];

        if (selectedOption) {
            let packageHours = selectedOption.getAttribute("data-hours") || "-";
            document.getElementById("package_hours").innerText = packageHours;
        }
        updatePrice();
    }

    function timePicker() {
        const timePicker = new tempusDominus.TempusDominus(document.getElementById('reserve_time'), {
            localization: {
                format: "HH:mm",
                hourCycle: 'h24',
            },
            restrictions: {
                enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],

            },
            stepping: 15,
            defaultDate: new Date(),
            display: {
                icons: {
                    up: 'bi bi-chevron-up',
                    down: 'bi bi-chevron-down',
                },
                viewMode: 'clock',
                components: {
                    calendar: false,
                    hours: true,
                    minutes: true,
                    seconds: false,
                },
            },
        });
    }

    function datePicker() {
        const datePicker = new tempusDominus.TempusDominus(document.getElementById('reserve_date'), {
            localization: {
                format: 'dd/MM/yyyy',
                hourCycle: 'h24',
                locale: 'th',
            },
            defaultDate: new Date(),
            restrictions: {
                minDate: new Date(),
                maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)),
            },
            display: {
                icons: {
                    previous: 'bi bi-chevron-left',
                    next: 'bi bi-chevron-right',
                },
                viewMode: 'calendar',
                components: {
                    calendar: true,
                    clock: false,
                },
            },
        });
    }
</script>