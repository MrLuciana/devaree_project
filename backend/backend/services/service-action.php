<script>
    // เพิ่มบริการ
    function serviceModalForm(title) {
        document.getElementById('ModalTitle').innerHTML = title;

        $.ajax({
            url: "services/service-form.php",
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
</script>