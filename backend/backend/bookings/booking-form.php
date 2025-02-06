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
                    <select id="addBooking-customer" class="form-control">
                        <option value="0">-- เลือกลูกค้า --</option>
                        <?php foreach ($customers as $customer) { ?>
                            <option value="<?= $customer['cus_id'] ?>"> <?= $customer['cus_fname'] ?>&nbsp;&nbsp;<?= $customer['cus_lname'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
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
                <div class="col-8">
                    <label for="service">บริการ</label>
                    <select id="service" class="form-control">
                        <option value="">-- เลือกบริการ --</option>
                        <?php foreach ($services as $service) { ?>
                            <option value="<?= $service['ser_id'] ?>" data-price="<?= $service['ser_price1'] ?>">
                                <?= $service['ser_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col">
                    <label for="package">แพ็กเกจที่ใช้งานได้</label>
                    <select id="package" class="form-control">
                        <option value="-1">-- เลือกแพ็กเกจ --</option>
                        <?php foreach ($packages as $package) { ?>
                            <option value="<?= $package['pac_id'] ?>" data-price="<?= $package['pac_price1'] ?>">
                                <?= $package['pac_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="date">วัน/เดือน/ปี ที่จอง</label>
                    <input type="date" id="date" class="form-control">
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col">
                    <label for="hour">ชั่วโมง</label>
                    <input type="number" id="hour" class="form-control" min="1" value="1" oninput="if (this.value < 1) this.value = 1;">
                </div>
                <div class="col">
                    <label for="start_time">เวลาเริ่มต้น</label>
                    <input type="time" id="start_time" class="form-control"">
                </div>
            </div>


            <div class=" row mt-3 mb-3">
                    <div class="col">
                        <label for="notes">หมายเหตุเพิ่มเติม</label>
                        <input type="text" id="notes" class="form-control" onkeyup="checkNull();">
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
                            <span id="summary_service">-</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><b>ราคา/ชั่วโมง:</b></span>
                            <span id="service_price">0</span> บาท
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><b>แพ็กเกจ:</b></span>
                            <span id="summary_package">-</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span><b>ราคาแพ็กเกจ:</b></span>
                            <span id="package_price">0</span> บาท
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
</div>
</div>

<script>
    function checkNull() {
        let fields = ["addBooking-customer", "addBooking-employee", "package", "service", "date", "hour", "start_time"];
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
    ["hour", "service", "package", "addBooking-customer", "addBooking-employee", "date", "start_time", "notes"].forEach(id => {
        document.getElementById(id).addEventListener("change", () => {
            updatePrice();
            checkNull();
        });
    });
</script>