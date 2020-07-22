<?php
require_once '../functions/functions.php';
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
  <title>Блоги</title>
 </head>
 <body>
  <div class="main">
    <?php
    require_once "inc/header.php";
    ?>
   <main>
     <div class="maincontent">
      <?php
        require_once "inc/leftmenu.php";
      ?>
       <div class="content">
        <?php
        review_read($_GET['readrev']);
        ?>
        <a href="../admin/reviews.php" id="reviewmain">Назад</a>
      </div>
     </div>
   </main>
   <?php
    require_once "inc/footer.php";
   ?>
  </div>
 </body>
</html>