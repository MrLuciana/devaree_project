<script>
    var page;
    $(document).ready(function() {
        bookingList(page);
    })

    $("#keyWord").keyup(function(event) {
        if (event.keyCode === 13) {
            bookingList(page);
        }
    });

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        bookingList(page);
    });
    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        bookingList();
    })

    function checkKeyWord() {
        var keyword = document.getElementById('keyWord').value;
        if (keyword) {
            document.getElementById('btnClear').hidden = false;

        } else {
            document.getElementById('btnClear').hidden = true;
        }
    }

    function clearSearch() {
        document.getElementById('btnClear').hidden = true;
        document.getElementById('keyWord').value = "";
        bookingList(page);
    }

    //=========== Modal Function ===========//
    // ฟอร์มการจอง
    function bookingModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./bookings/booking-form.php",
            type: "GET",
            success: function(data) {
                $('#IModal .modal-body').html(data);
                $('#IModal').modal('show');
            },
            error: function() {
                alert("เกิดข้อผิดพลาดในการโหลดข้อมูล");
            }
        });
    }

    // ฟอร์มดูรายละเอียด
    function bookingModalDetail(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./bookings/booking-detail.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#IModal .modal-body').html(data);
                $('#IModal').modal('show');
            }
        });
    }

    // ฟอร์มแก้ไขการจอง
    function bookingModalEdit(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./bookings/booking-edit.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#IModal .modal-body').html(data);
                $('#IModal').modal('show');
            }
        });
    }

    // ฟังก์ชันลบการจอง
    function bookingModalDelete(id) {
        Swal.fire({
            text: "ยืนยันการลบรายการนี้",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "./bookings/booking-delete.php",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: "json", // บอกว่าเราคาดหวัง JSON กลับมา
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "สำเร็จ!",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 500
                            }).then(() => {
                                bookingList(); // รีโหลดหน้า
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "เกิดข้อผิดพลาด!",
                                text: response.message,
                                confirmButtonText: "ตกลง"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด!",
                            text: "ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                            confirmButtonText: "ตกลง"
                        });
                    }
                });
            }
        });
    }
    //=========== End Modal Function ===========//

    // ฟังก์ชันดึงข้อมูล
    function bookingList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./bookings/booking-fetch.php",
            success: (data, res) => {
                $('#bookingTables').html(data);
            }
        })
    }

    // ฟังก์ชันเพิ่มการจอง 
    function bookingAdd() {
        // ดึงค่าจากฟอร์ม
        const customer = $('#addBooking-customer').val().trim();
        const employee = $('#addBooking-employee').val().trim();
        const service = $('#service').val().trim();
        const package = $('#package').val().trim();
        const bookingDate = $('#date').val().trim();
        const hours = $('#hour').val().trim();
        const startTime = $('#start_time').val().trim();
        const notes = $('#notes').val().trim();
        const method = $('#method').val().trim();

        console.log(customer, employee, service, package, bookingDate, hours, startTime, notes, method);
        // คำนวณราคา
        const servicePricePerHour = parseFloat(document.getElementById("service").selectedOptions[0]?.getAttribute("data-price")) || 0;
        const packagePrice = parseFloat(document.getElementById("package").selectedOptions[0]?.getAttribute("data-price")) || 0;
        const totalPrice = (servicePricePerHour * hours) + packagePrice;

        // ตรวจสอบข้อมูลก่อนส่ง (Validation)
        if (!customer || !employee || !service || !package || !bookingDate || !hours || !startTime || !method) {
            alert("กรุณากรอกข้อมูลให้ครบถ้วน!");
            return;
        }

        // ส่งข้อมูลด้วย AJAX
        $.ajax({
            url: "./bookings/booking-add.php",
            type: 'POST',
            contentType: 'application/json', // ✅ เพิ่ม Content-Type เป็น JSON
            data: JSON.stringify({ // ✅ แปลงข้อมูลเป็น JSON
                cus_id: customer,
                emp_id: employee,
                ser_id: service,
                pac_id: package,
                boo_date: bookingDate,
                boo_hours: hours,
                boo_start_time: startTime,
                boo_notes: notes,
                boo_amount: totalPrice,
                boo_method: method
            }),
            dataType: "json",
            success: function(response) {
                if (response.success) { // ✅ ตรวจสอบ key 'success'
                    Swal.fire({
                        icon: "success",
                        title: "สำเร็จ!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        if (typeof bookingList === 'function') {
                            bookingList();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด!",
                        text: response.message,
                        confirmButtonText: "ตกลง"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด!",
                    text: `ไม่สามารถบันทึกข้อมูลได้ (${xhr.status}: ${xhr.statusText})`,
                    confirmButtonText: "ตกลง"
                });
            }
        });

    }

    // ฟังก์ชันแก้ไขการจอง
    function bookingUpdate(id) {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var price1 = $('#price1').val().trim();
        var price2 = $('#price2').val().trim();
        var price3 = $('#price3').val().trim();
        var cat_id = $('#cat_id').val();
        var description = $('#description').val().trim();
        $.ajax({
            url: "./bookings/booking-update.php",
            type: 'POST',
            data: {
                id: id,
                code: code,
                name: name,
                price1: price1,
                price2: price2,
                price3: price3,
                cat_id: cat_id,
                description: description,
            },
            dataType: "json", // ระบุว่ารับค่า JSON กลับมา
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "อัปเดตสำเร็จ!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 500
                    }).then(() => {
                        bookingList(); // โหลดข้อมูลใหม่
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด!",
                        text: response.message,
                        confirmButtonText: "ตกลง"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "เกิดข้อผิดพลาด!",
                    text: `ไม่สามารถอัปเดตข้อมูลได้ (${xhr.status}: ${xhr.statusText})`,
                    confirmButtonText: "ตกลง"
                });
            }
        });

    }

    // Event Listener สำหรับตรวจจับการเปลี่ยนสถานะ
    $(document).on('change', 'select[name="boo_status"]', function() {
        var boo_id = $(this).data('boo_id');
        var new_status = $(this).val();

        updateBookingStatus(boo_id, new_status);
    });

    function updateBookingStatus(boo_id, new_status) {
        $.ajax({
            url: './bookings/booking-status.php',
            type: 'POST',
            data: {
                boo_id: boo_id,
                new_status: new_status
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    let message = (new_status === 'confirmed') ?
                        'สร้างรายการชำระเงินเรียบร้อยแล้ว ✅' :
                        (new_status === 'pending') ?
                        'ลบรายการชำระเงินเรียบร้อยแล้ว ❌' :
                        'อัพเดตสถานะสำเร็จ';

                    Swal.fire({
                        icon: 'success',
                        title: '✅ สำเร็จ!',
                        text: message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '⚠️ ไม่สำเร็จ!',
                        text: response.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.error('❌ AJAX Error:', textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: '❌ เกิดข้อผิดพลาด!',
                    html: `<strong>สถานะ:</strong> ${textStatus}<br><strong>รายละเอียด:</strong> ${errorThrown}`,
                    confirmButtonText: 'ปิด'
                });
            }
        });
    }
</script>