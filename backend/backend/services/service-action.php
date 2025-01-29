<script>
    var page;
    $(document).ready(function() {
        serviceList(page);
    })

    $("#keyWord").keyup(function(event) {
        if (event.keyCode === 13) {
            serviceList(page);
        }
    });

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        serviceList(page);
    });
    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        serviceList();
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
        serviceList(page);
    }

    //=========== Modal Function ===========//
    // ฟอร์มบริการ
    function serviceModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./services/service-form.php",
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

    // ฟอร์มแก้ไขบริการ
    function serviceModalEdit(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./services/service-edit.php",
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
    //=========== End Modal Function ===========//

    // ฟังก์ชันดึงข้อมูล
    function serviceList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./services/service-fetch.php",
            success: (data, res) => {
                $('#serviceTables').html(data);
            }
        })
    }

    // ฟังก์ชันเพิ่มบริการ
    function serviceAdd() {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var price1 = $('#price1').is(':disabled') ? null : $('#price1').val().trim();
        var price2 = $('#price2').is(':disabled') ? null : $('#price2').val().trim();
        var price3 = $('#price3').is(':disabled') ? null : $('#price3').val().trim();
        var cat_id = $('#cat_id').val();
        var description = $('#description').val().trim();

        $.ajax({
            url: "./services/service-add.php",
            type: 'POST',
            data: {
                code: code,
                name: name,
                price1: price1,
                price2: price2,
                price3: price3,
                cat_id: cat_id,
                description: description,
            },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "สำเร็จ!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500 // เพิ่มเวลาให้นานขึ้น
                    }).then(() => {
                        if (typeof serviceList === 'function') {
                            serviceList(); // ตรวจสอบว่าฟังก์ชันมีอยู่จริง
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


    // ฟังก์ชันแก้ไขบริการ
    function serviceUpdate(id) {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var price1 = $('#price1').val().trim();
        var price2 = $('#price2').val().trim();
        var price3 = $('#price3').val().trim();
        var cat_id = $('#cat_id').val();
        var description = $('#description').val().trim();
        $.ajax({
            url: "./services/service-update.php",
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
            success: function(response) {
                serviceList();
            }
        });
    }

    // ฟังก์ชัน Toggle สถานะ
    function toggleActive(ser_id, currentStatus) {
        let newStatus = (currentStatus === 'yes') ? 'no' : 'yes'; // สลับค่า

        // ส่งค่าไปอัปเดตในฐานข้อมูลผ่าน AJAX
        fetch('services/service-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `ser_id=${ser_id}&ser_active=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let button = document.getElementById(`activeButton${ser_id}`);
                    button.className = `btn btn-${newStatus === 'yes' ? 'success' : 'danger'} btn-sm`;
                    button.innerHTML = (newStatus === 'yes') ? 'เปิด' : 'ปิด';
                    button.setAttribute("onclick", `toggleActive(${ser_id}, '${newStatus}')`);
                } else {
                    alert("เกิดข้อผิดพลาดในการอัปเดต");
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>