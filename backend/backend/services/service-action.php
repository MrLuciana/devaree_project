<script>
    // ฟอร์มบริการ
    function serviceModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;

        $.ajax({
            url: "./services/service-form.php",
            type: "GET",
            success: function(data) {
                $('#addRowModal .modal-body').html(data);
                $('#addRowModal').modal('show');
            },
            error: function() {
                alert("เกิดข้อผิดพลาดในการโหลดข้อมูล");
            }
        });
    }

    // ฟังก์ชันเพิ่มบริการ
    function serviceAdd() {
        var name = $('#name').val().trim();
        var price = $('#price').val().trim();
        var scat_id = $('#scat_id').val();
        var description = $('#description').val().trim();

        // ตรวจสอบว่ากรอกข้อมูลครบหรือไม่
        if (name === "" || price === "" || scat_id === "" || description === "") {
            Swal.fire({
                icon: "warning",
                title: "กรุณากรอกข้อมูลให้ครบ!",
                text: "กรุณากรอกข้อมูลให้ครบทุกช่องก่อนบันทึก",
                confirmButtonText: "ตกลง"
            });
            return;
        }

        $.ajax({
            url: "./services/service-add.php",
            type: 'POST',
            data: {
                name: name,
                price: price,
                scat_id: scat_id,
                description: description,
            },
            dataType: "json", // บอกว่าเราคาดหวัง JSON กลับมา
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "สำเร็จ!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload(); // รีโหลดหน้า
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

    // ฟังก์ชันลบบริการ
    function serviceModalDelete(id) {
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
                    url: "./services/service-delete.php",
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
                                timer: 2000
                            }).then(() => {
                                location.reload(); // รีโหลดหน้า
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

    // // ฟังก์ชัน Toggle สถานะ
    // function toggleStatus(id) {
    //     var button = document.getElementById('statusButton-' + id);

    //     // ตรวจสอบสถานะปัจจุบันของปุ่ม
    //     var currentStatus = button.getAttribute('data-status'); // ดึงค่าปัจจุบันจาก data-status
    //     var status = currentStatus === 'active' ? 'inactive' : 'active'; // สลับสถานะ

    //     // ส่งคำสั่ง AJAX ไปยัง PHP เพื่ออัปเดตสถานะ
    //     $.ajax({
    //         url: './services/service-status.php',
    //         type: 'POST',
    //         dataType: 'json', // ให้ jQuery แปลง JSON อัตโนมัติ
    //         data: {
    //             id: id,
    //             status: status
    //         },
    //         success: function(response) {
    //             console.log(response);
    //             if (response.status === 'active') {
    //                 button.innerHTML = 'เปิด'; // เปลี่ยนข้อความปุ่ม
    //                 button.setAttribute('data-status', 'active'); // อัปเดต data-status
    //                 button.classList.remove('btn-danger'); // ลบคลาส btn-danger
    //                 button.classList.add('btn-success'); // เพิ่มคลาส btn-success
    //             } else if (response.status === 'inactive') {
    //                 button.innerHTML = 'ปิด'; // เปลี่ยนข้อความปุ่ม
    //                 button.setAttribute('data-status', 'inactive'); // อัปเดต data-status
    //                 button.classList.remove('btn-success'); // ลบคลาส btn-success
    //                 button.classList.add('btn-danger'); // เพิ่มคลาส btn-danger
    //             } else {
    //                 alert('เกิดข้อผิดพลาด: ' + response.message); // แสดงข้อความผิดพลาด
    //             }
    //         },
    //         error: function() {
    //             alert('ไม่สามารถอัปเดตสถานะได้'); // แจ้งเตือนเมื่อมีข้อผิดพลาด
    //         }
    //     });
    // }

    function toggleStatus(serviceId, newStatus) {
        fetch('./services/service-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `service_id=${serviceId}&status=${newStatus ? 1 : 0}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                } else {
                    console.log(data.message);
                    const button = document.getElementById(`statusButton${serviceId}`);
                    button.textContent = newStatus ? 'เปิด' : 'ปิด';
                    button.className = `btn btn-${newStatus ? 'success' : 'danger'} btn-sm`;
                    button.setAttribute('onclick', `toggleStatus(${serviceId}, ${!newStatus})`);
                }
            });
    }
</script>