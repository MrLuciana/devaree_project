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

    // เพิ่มบริการ 
    function serviceAdd() {
        var name = $('#name').val();
        var price = $('#price').val();
        var catagory = $('#catagory').val();
        var description = $('#description').val();
        $.ajax({
            url: "./services/service-add.php",
            type: 'POST',
            data: {
                name: name,
                price: price,
                catagory: catagory,
                description: description,
            },
            success: function(data) {
                alert("เพิ่มบริการสำเร็จ!"); // แจ้งเตือนเมื่อเพิ่มข้อมูลสำเร็จ
                window.location.href = "index.php?page=service"; // โหลดหน้า service.php ใหม่
            },
            error: function() {
                alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");
            }
        });
    }
</script>