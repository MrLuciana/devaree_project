<?php
session_start();
include("../backend/includes/conn.php");
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adm_username = trim($_POST['username']);
    $adm_password = trim($_POST['password']);

    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT adm_id, adm_username, adm_password FROM db_admin WHERE adm_username = ?");
    $stmt->bind_param("s", $adm_username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // ตรวจสอบว่ามีผู้ใช้งานในฐานข้อมูลหรือไม่    
    if ($user && password_verify($adm_password, $user['adm_password'])) {
        // ✅ แก้ไขตัวแปร session ให้ถูกต้อง
        $_SESSION['user_id'] = $user['adm_id'];
        $_SESSION['user_username'] = $user['adm_username'];

        // ✅ ปิด statement และ connection
        $stmt->close();
        $conn->close();
        echo '<script type="text/javascript">
        Swal.fire({
              icon: "success",
              title: "กำลังเข้าสู่ระบบ",
              text: "กรุณารอสักครู่..",
              showConfirmButton: false,
              timer: 1500
        });
        </script>';
        echo '<meta http-equiv="refresh" content="2;url=../backend/" />';

    } else {
        echo '<script type="text/javascript">
        Swal.fire({
              icon: "error",
              title: "เข้าสู่ระบบไม่สำเร็จ",
              text: "Username หรือ Password ไม่ถูกต้อง!",
              showConfirmButton: false,
              timer: 1500
        });
        </script>';
    }

    // ✅ ปิด statement และ connection เมื่อมีข้อผิดพลาด
    $stmt->close();
    $conn->close();
}
?>