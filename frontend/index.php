<?php
include "includes/head.php";
include "includes/conn.php";

session_start();
require 'includes/LineLogin.php';

// Check if user needs to be redirected after login
$redirect_after_login = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : '';

// If user is not logged in, redirect to LINE login
if (!isset($_SESSION['profile'])) {
    $line = new LineLogin();
    $link = $line->getLink();
    header("Location: " . $link);
    exit();
}

// อัพเดทข้อมูลผู้ใช้ใน session
if (isset($_SESSION['customer'])) {
    $stmt = $conn->prepare("SELECT * FROM customers WHERE cus_lineID = ?");
    $stmt->bind_param("s", $_SESSION['profile']->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $customerData = $result->fetch_assoc();

    $_SESSION['customer'] = $customerData;
    $_SESSION['profile'] = (object) array_merge((array) $_SESSION['profile'], $customerData);
}

// If there's a redirect set after login, handle it
if (!empty($redirect_after_login)) {
    // Clear the redirect session variable
    unset($_SESSION['redirect_after_login']);

    // Redirect to the specified page
    header("Location: " . $redirect_after_login);
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<body class="home" id="app">
    <?php
    if ($page == 'home') {
        include "pages/home.php";
    } else if ($page == 'reserve') {
        include "pages/reserve.php";
    } else if ($page == 'user') {
        include "pages/user.php";
    } else if ($page == 'packages') {
        include "pages/package.php";
    } else {
        include "404.php";
    }
    ?>
    <nav>
        <?php include "includes/mobile-navbar.php"; ?>
    </nav>
</body>