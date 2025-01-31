<script>
    var page;
    $(document).ready(function() {
        packageList(page);
    })

    $("#keyWord").keyup(function(event) {
        if (event.keyCode === 13) {
            packageList(page);
        }
    });

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        packageList(page);
    });
    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        packageList();
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
        packageList(page);
    }

    //=========== Modal Function ===========//
    // ฟอร์มแพ็กเกจ
    function packageModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./packages/package-form.php",
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
    function packageModalDetail(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./packages/package-detail.php",
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

    // ฟอร์มแก้ไขแพ็กเกจ
    function packageModalEdit(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./packages/package-edit.php",
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

    // ฟังก์ชันลบแพ็กเกจ
    function packageModalDelete(id) {
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
                    url: "./packages/package-delete.php",
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
                                packageList(); // รีโหลดหน้า
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
    function packageList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./packages/package-fetch.php",
            success: (data, res) => {
                $('#packageTables').html(data);
            }
        })
    }

    // ฟังก์ชันเพิ่มแพ็กเกจ
    function packageAdd() {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var price1 = $('#price1').is(':disabled') ? null : $('#price1').val().trim();
        var price2 = $('#price2').is(':disabled') ? null : $('#price2').val().trim();
        var price3 = $('#price3').is(':disabled') ? null : $('#price3').val().trim();
        var cat_id = $('#cat_id').val();
        var description = $('#description').val().trim();

        $.ajax({
            url: "./packages/package-add.php",
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
                        timer: 500 // เพิ่มเวลาให้นานขึ้น
                    }).then(() => {
                        if (typeof packageList === 'function') {
                            packageList(); // ตรวจสอบว่าฟังก์ชันมีอยู่จริง
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


    // ฟังก์ชันแก้ไขแพ็กเกจ
    function packageUpdate(id) {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var price1 = $('#price1').val().trim();
        var price2 = $('#price2').val().trim();
        var price3 = $('#price3').val().trim();
        var cat_id = $('#cat_id').val();
        var description = $('#description').val().trim();
        $.ajax({
            url: "./packages/package-update.php",
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
                        packageList(); // โหลดข้อมูลใหม่
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

    // ฟังก์ชัน Toggle สถานะ
    function toggleActive(pac_id, currentStatus) {
        let newStatus = (currentStatus === 'yes') ? 'no' : 'yes'; // สลับค่า

        // ส่งค่าไปอัปเดตในฐานข้อมูลผ่าน AJAX
        fetch('packages/package-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `pac_id=${pac_id}&pac_active=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let button = document.getElementById(`activeButton${pac_id}`);
                    button.className = `btn btn-${newStatus === 'yes' ? 'success' : 'danger'} btn-sm`;
                    button.innerHTML = (newStatus === 'yes') ? 'เปิด' : 'ปิด';
                    button.setAttribute("onclick", `toggleActive(${pac_id}, '${newStatus}')`);
                } else {
                    alert("เกิดข้อผิดพลาดในการอัปเดต");
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>