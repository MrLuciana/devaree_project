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
         if ($page == '' || $page == 'home') {
            include "home.php";
         } else if ($page == 'profile') {
            include "profile.php";
         } else {
            include "notfound.php";
         }
         ?>
         <?php include "includes/footer.php"; ?>
      </div>
   </div>
</body>

</html>
<?php include "includes/scripts.php"; ?>