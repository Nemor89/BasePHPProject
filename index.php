<?php
require_once 'functions/functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="Styles/styles.css">
  <title>Главная страница</title>
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
      <div class="blogs">
          <?php
          blog_view();
          ?>
      </div>
     </div>
   </main>
   <?php
    require_once "inc/footer.php";
   ?>
  </div>
 </body>
</html>