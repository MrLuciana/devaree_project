<?php
require_once('../includes/conn.php');

// ดึงข้อมูล Customer
$customerQuery = "SELECT * FROM customers";
$customerResult = mysqli_query($conn, $customerQuery);
$customers = [];
while ($row = mysqli_fetch_assoc($customerResult)) {
    $customers[] = $row;
}
// ด฿งข้อมูล Employee
$employeeQuery = "SELECT * FROM employees";
$employeeResult = mysqli_query($conn, $employeeQuery);
$employees = [];
while ($row = mysqli_fetch_assoc($employeeResult)) {
    $employees[] = $row;
}

// ดึงข้อมูล Service
$serviceQuery = "SELECT * FROM services";
$serviceResult = mysqli_query($conn, $serviceQuery);
$services = [];
while ($row = mysqli_fetch_assoc($serviceResult)) {
    $services[] = $row;
}

// ดึงข้อมูล Package
$packageQuery = "SELECT * FROM packages";
$packageResult = mysqli_query($conn, $packageQuery);
$packages = [];
while ($row = mysqli_fetch_assoc($packageResult)) {
    $packages[] = $row;
}
?>

<div class="modal-body" style="padding: 30px 15px 20px 15px;">
    <div class="row">
        <div class="col-7">
            <!-- ลูกค้า -->
            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="addBooking-customer">ชื่อลูกค้า</label>
                    <select id="addBooking-customer" class="form-control" onchange="customerChange();">
                        <option value="0">-- เลือกลูกค้า --</option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?= $customer['cus_id'] ?>"> <?= $customer['cus_fname'] ?>&nbsp;&nbsp;<?= $customer['cus_lname'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="booking-details">
                <!-- พนักงาน -->
                <div class="row mt-3 mb-3">
                    <div class="col">
                        <label for="addBooking-employee">พนักงาน</label>
                        <select id="addBooking-employee" class="form-control">
                            <option value="">-- เลือกพนักงาน --</option>
                            <?php foreach ($employees as $employee) { ?>
                                <option value="<?= $employee['emp_id'] ?>"> <?= $employee['emp_fname'] ?>&nbsp;&nbsp;<?= $employee['emp_lname'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- บริการ & แพ็กเกจ-->
                <div class="row mt-3 mb-3">
                    <div class="col">
                        <label for="selection_type">เลือกประเภท</label>
                        <select id="selection_type" class="form-control" onchange="selectionType(); updatePrice();">
                            <option value="">-- เลือกประเภท --</option>
                            <option value="service">บริการ</option>
                            <option value="package">แพ็กเกจ</option>
                        </select>
                    </div>
                    <div class="col" id="service_container" style="display:none;">
                        <label for="service">บริการ</label>
                        <select id="service" class="form-control" onchange="serviceHourChange();">
                            <option value="">-- เลือกบริการ --</option>
                            <?php foreach ($services as $service) { ?>
                                <option value="<?= $service['ser_id'] ?>"
                                    data-price1="<?= $service['ser_price1'] ?>"
                                    data-price2="<?= $service['ser_price2'] ?>"
                                    data-price3="<?= $service['ser_price3'] ?>">
                                    <?= $service['ser_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="service_hours">จำนวนชั่วโมง</label>
                        <select id="service_hours" class="form-control">
                            <option value="">-- เลือกชั่วโมง --</option>
                            <option value="1">1 ชั่วโมง</option>
                            <option value="2">2 ชั่วโมง</option>
                            <option value="3">3 ชั่วโมง</option>
                        </select>
                    </div>
                    <div class="col" id="package_container" style="display:none;">
                        <label for="package">แพ็กเกจ</label>
                        <select id="package" class="form-control" onchange="updatePrice(); updatePackageHours();">
                            <option value="">-- เลือกแพ็กเกจ --</option>
                            <?php foreach ($packages as $package) { ?>
                                <option value="<?= $package['pac_id'] ?>"
                                    data-price="<?= $package['pac_price1'] ?>"
                                    data-hours="<?= $package['pac_hour'] ?>">
                                    <?= $package['pac_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="package_hours">จำนวนชั่วโมง</label>
                        <div style="border:solid 1px #ddd; padding:5px 10px;" id="package_hours">- ชม.</div>
                    </div>
                </div>

                <!-- วัน/เดือน/ปี ที่จอง-->
                <div class="row mt-3 mb-3">
                    <div class="col">
                        <label for="reserve_date">วัน/เดือน/ปี ที่จอง</label>
                        <input type="text" id="reserve_date" class="form-control" onfocus="datePicker();">
                    </div>
                </div>

                <!-- เวลาเริ่มต้น & วิธีชำระเงิน-->
                <div class="row mt-3 mb-3">
                    <div class="col">
                        <label for="reserve_time">เวลาเริ่มต้น</label>
                        <input type="text" id="reserve_time" class="form-control" onfocus="timePicker();">
                    </div>
                    <div class=" col">
                        <label for="method">วิธีชำระเงิน</label>
                        <select id="method" name="boo_method" class="form-control">
                            <option value="">-- เลือกวิธีชำระเงิน --</option>
                            <option value="cash">เงินสด</option>
                            <option value="bank_transfer">โอนเงิน</option>
                        </select>
                    </div>
                </div>

                <!-- หมายเหตุเพิ่มเติม-->
                <div class=" row mt-3 mb-3">
                    <div class="col">
                        <label for="notes">หมายเหตุเพิ่มเติม</label>
                        <textarea type="text" id="notes" class="form-control" onkeyup="checkNull();"></textarea>
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
                        <span><b>ประเภท:</b></span>
                        <span id="summary_type">-</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>ชื่อ:</b></span>
                        <span id="summary_name">-</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>ราคา:</b></span>
                        <span id="summary_price">0</span> บาท
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><b>จำนวนชั่วโมง:</b></span>
                        <span id="summary_hours">0</span> ชม.
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0"><b>รวมทั้งสิ้น:</b></h5>
                        <h5 class="m-0 text-danger"><b><span id="total_price">0</span> บาท</b></h5>
                    </div>
                    <hr>
                    <button id="submitBtn" class="btn btn-primary w-100" onclick="bookingAdd();" disabled>✅ ยืนยันการจอง</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // ฟังก์ชัน customerChange ที่จะถูกเรียกเมื่อเลือกลูกค้า
    function customerChange() {
        let customerSelected = document.getElementById("addBooking-customer").value !== "0";
        let bookingDetails = document.querySelectorAll(".booking-details");

        // ซ่อนหรือแสดงส่วนการจองตามสถานะของการเลือกลูกค้า
        bookingDetails.forEach(section => {
            section.style.display = customerSelected ? "block" : "none";
        });

        // ตรวจสอบฟอร์มว่ากรอกครบถ้วนหรือไม่
        checkNull();
    }

    // ผูก event listener กับ select โดยตรง
    document.getElementById("addBooking-customer").addEventListener("change", customerChange);

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
    ["hour", "service", "package", "selection_type"].forEach(id => {
        document.getElementById(id).addEventListener("change", () => {
            updatePrice();
            checkNull();
        });
    });

    // ฟังก์ชัน selectionType ที่จะถูกเรียกเมื่อมีการเปลี่ยนแปลงการเลือกประเภท
    function selectionType() {
        const selectedValue = document.getElementById('selection_type').value;

        // ซ่อนทั้งสอง div ก่อน
        document.getElementById('service_container').style.display = 'none';
        document.getElementById('package_container').style.display = 'none';

        // แสดง div ตามประเภทที่เลือก
        if (selectedValue === 'service') {
            document.getElementById('service_container').style.display = 'block';
        } else if (selectedValue === 'package') {
            document.getElementById('package_container').style.display = 'block';
        }
    }

    // ผูก event listener กับ select
    document.getElementById('selection_type').addEventListener('change', selectionType);

    // แก้ไข serviceHourChange ให้ถูกต้อง
    function serviceHourChange() {
        let selectedOption = document.getElementById("service").selectedOptions[0];
        if (!selectedOption) return;

        let price1 = selectedOption.getAttribute("data-price1");
        let price2 = selectedOption.getAttribute("data-price2");
        let price3 = selectedOption.getAttribute("data-price3");

        // console.log("บริการที่เลือก:", selectedOption.text);
        // console.log("ราคา 1:", price1);
        // console.log("ราคา 2:", price2);
        // console.log("ราคา 3:", price3);

        document.getElementById("service_hours").value = 1;

        document.getElementById("service_hours").addEventListener("change", function() {
            let hours = this.value;
            console.log("จำนวนชั่วโมงที่เลือก:", hours);
            updatePrice();
        });

        updatePrice();
        checkNull();
    }

    function updatePackageHours() {
        let packageSelect = document.getElementById("package");
        let selectedOption = packageSelect.selectedOptions[0];

        if (selectedOption) {
            let packageHours = selectedOption.getAttribute("data-hours") || "-";
            document.getElementById("package_hours").innerText = packageHours + " ชม.";
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

<style>
    .booking-details {
        display: none;
        /* ซ่อนส่วนการกรอกข้อมูล */
    }
</style>