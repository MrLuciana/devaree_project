<?php
session_start();
?>
<?php include "includes/header.php"; ?>
<body>
    <script>
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณต้องการออกจากระบบใช่หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ออกจากระบบ!",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กด "ใช่" ให้ไปที่ logout.php
                window.location.href = "logout_action.php";
            } else {
                // ถ้าผู้ใช้กด "ยกเลิก" ให้กลับไปหน้าก่อนหน้า
                window.history.back();
            }
        });
    </script>
</body>
