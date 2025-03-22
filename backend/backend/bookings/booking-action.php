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
        const serviceHours = $('#service_hours').val().trim();
        const packageHours = $('#package_hours').text().trim();
        const bookingAmount = $('#total_price').text().trim();
        const bookingDate = $('#reserve_date').val().trim();
        const reserveTime = $('#reserve_time').val().trim();
        const notes = $('#notes').val().trim();
        const method = $('#method').val().trim();

        // ตรวจสอบข้อมูลก่อนส่ง (Validation)
        if (!customer || !employee || !(service || package) || !bookingDate || !reserveTime || !method) {
            Swal.fire({
                icon: "warning",
                title: "ข้อมูลไม่ครบ!",
                text: "กรุณากรอกข้อมูลให้ครบถ้วน",
            });
            return;
        }
        // ✅ LOG ข้อมูลที่ส่งไปยัง AJAX
        const requestData = {
            cus_id: customer,
            emp_id: employee,
            ser_id: service,
            pac_id: package,
            boo_ser_hours: serviceHours,
            boo_pac_hours: packageHours,
            boo_amount: bookingAmount,
            boo_date: bookingDate,
            boo_res_time: reserveTime,
            boo_notes: notes,
            boo_method: method
        };

        console.log("📌 ข้อมูลที่กำลังส่งไปยังเซิร์ฟเวอร์:", requestData);

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
                boo_ser_hours: serviceHours,
                boo_pac_hours: packageHours,
                boo_amount: bookingAmount,
                boo_date: bookingDate,
                boo_res_time: reserveTime,
                boo_notes: notes,
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
                    text: `ไม่สามารถบันทึกข้อมูลได้ (${xhr.status}: ${xhr.statusText})`,
                    confirmButtonText: "ตกลง"
                });
            }
        });

    }

    // ฟังก์ชันแก้ไขการจอง
    function bookingUpdate(id) {
        console.log("Updating booking with ID: " + id);
        var boo_date = $('#reserve_date').val()
        var boo_res_time = $('#reserve_time').val()
        var boo_notes = $('#notes').val()
        var boo_method = $('#method').val()

        // ตรวจสอบข้อมูลก่อนส่ง (Validation)
        if (!boo_date || !boo_res_time || !boo_method) {
            Swal.fire({
                icon: "warning",
                title: "ข้อมูลไม่ครบ!",
                text: "กรุณากรอกข้อมูลให้ครบถ้วน",
            });
            return;
        }
        // console.log("📌 ข้อมูลที่กำลังส่งไปยังเซิร์ฟเวอร์:", {
        //     boo_date,
        //     boo_res_time,
        //     boo_notes,
        //     boo_method
        // });
        
        $.ajax({
            url: "./bookings/booking-update.php",
            type: 'POST',
            data: {
                boo_id: id,
                boo_date: boo_date,
                boo_res_time: boo_res_time,
                boo_notes: boo_notes,
                boo_method: boo_method
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