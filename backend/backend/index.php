<?php
$page = $_GET['page'];
$act = $_GET['act'];

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
            if($page == '' || $page=='home'){
               include "home.php";
            }else if($page == 'booking'){
               include "booking.php";
            }else if($page == 'calendar'){
               include "calendar.php";
            }else if($page == ''){
               include ".php";
            }else if($page == ''){
               include ".php";
            }else if($page == 'all-customer'){
               include "all-customer.php";
            }else if($page == '404'){
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