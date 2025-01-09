<script>
    $(document).ready(function() {
        serviceList();
    })

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
    
    // ฟังก์ชันดึงข้อมูล
    function serviceList(page) {
        var keyword = 1
        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,

            },
            url: "./services/service-fetch.php",
            success: (data, res) => {
                $('#Bdatatables').html(data);
            }
        })
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
                        timer: 500
                    }).then(() => {
                        serviceList();
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
                                timer: 500
                            }).then(() => {
                                serviceList(); // รีโหลดหน้า
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