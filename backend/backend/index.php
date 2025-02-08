<?php
session_start();
include "includes/conn.php";

$page = $_GET['page'];
$act = $_GET['act'];

if (!isset($_SESSION['user_id'])) {
   header('location: ../login/login.php');
}

?>
<!doctype html>
<html lang="en">

<?php include "includes/header.php"; ?>

<body>
   <div class="wrapper">
      <?php include "includes/sidebar.php"; ?>
      <div class="main-panel">
         <div class="main-header">
            <?php include "includes/navbar.php"; ?>
         </div>
         <?php
         if ($page == '' || $page == 'home') {
            include "home.php";
         } else if ($page == 'service') {
            include "service.php";
         } else if ($page == 'package') {
            include "package.php";
         } else if ($page == 'categories') {
            include "categories.php";
         } else if ($page == 'customer') {
            include "customer.php";
         } else if ($page == 'employee') {
            include "employee.php";
         } else if ($page == 'booking') {
            include "booking.php";
         } else if ($page == 'payment') {
            include "payment.php";
         } else if ($page == '404') {
            include "404.php";
         }
         ?>
         <?php include "includes/footer.php"; ?>
      </div>
   </div>
</body>

</html>
<?php include "includes/modal.php"; ?>
<?php include "includes/scripts.php"; ?>