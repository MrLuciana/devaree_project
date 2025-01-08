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
</script>