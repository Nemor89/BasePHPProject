<?php
require_once '../functions/functions.php';
if ($_SESSION['status'] != 3){
  header('Location: ../index.php');
} else {
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
  <title>Админка</title>
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
          <h1 id='stat'>СТАТИСТИКА САЙТА:</h1>
          <?php
          statistics();
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
<?php
}
?>