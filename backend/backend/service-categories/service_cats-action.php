<script>
    var page;
    $(document).ready(function() {
        service_catsList(page);
    })

    $("#keyWord").keyup(function(event) {
        if (event.keyCode === 13) {
            service_catsList(page);
        }
    });

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        service_catsList(page);
    });
    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        service_catsList();
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
        service_catsList(page);
    }

    //=========== Modal Function ===========//
    // ฟอร์มบริการ
    function service_catsModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./service-categories/service_cats-form.php",
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
    function service_catsModalEdit(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./service-categories/service_cats-edit.php",
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
    function service_catsModalDelete(id) {
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
                    url: "./service-categories/service_cats-delete.php",
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
                                service_catsList(); // รีโหลดหน้า
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
    function service_catsList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./service-categories/service_cats-fetch.php",
            success: (data, res) => {
                $('#service_catsTables').html(data);
            }
        })
    }

    // ฟังก์ชันเพิ่มบริการ
    function service_catsAdd() {
        var name = $('#name').val().trim();
        var description = $('#description').val().trim();
        $.ajax({
            url: "./service-categories/service_cats-add.php",
            type: 'POST',
            data: {
                name: name,
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
                        service_catsList();
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

    // ฟังก์ชันแก้ไขบริการ
    function service_catsUpdate(id) {
        var name = $('#name').val().trim();
        var description = $('#description').val().trim();
        $.ajax({
            url: "./service-categories/service_cats-update.php",
            type: 'POST',
            data: {
                id: id,
                name: name,
                description: description,
            },
            success: function(response) {
                service_catsList();
            }
        });
    }

    // ฟังก์ชัน Toggle สถานะ
    function toggleStatus(service_catsId, newStatus) {
        fetch('./service-categories/service_cats-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `service_cats_id=${service_catsId}&status=${newStatus ? 1 : 0}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                } else {
                    console.log(data.message);
                    const button = document.getElementById(`statusButton${service_catsId}`);
                    button.textContent = newStatus ? 'เปิด' : 'ปิด';
                    button.className = `btn btn-${newStatus ? 'success' : 'danger'} btn-sm`;
                    button.setAttribute('onclick', `toggleStatus(${service_catsId}, ${!newStatus})`);
                }
            });
    }
</script>