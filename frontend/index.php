<?php
include "includes/head.php";

session_start();
require_once('includes/LineLogin.php');

if (!isset($_SESSION['profile'])) {
    $line = new LineLogin();
    $link = $line->getLink();
    header("Location: " . $link);
    exit();
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}
?>

<body class="home">
    <?php
    if ($page == '' || $page == 'home') {
        include "pages/home.php";
    } else if ($page == 'reserve') {
        include "pages/reserve.php";
    } else if ($page == 'user') {
        include "pages/user.php";
    } else {
        include "404.php";
    }
    ?>
    <nav>
        <?php include "includes/mobile-navbar.php"; ?>
    </nav>
</body>