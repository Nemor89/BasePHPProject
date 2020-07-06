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
        <div class="errormsgblog">
         <span><?=$errorMsg?></span>
        </div>
        <form class="blogadd" action="blogadd.php" method="post" enctype="multipart/form-data">
          <?php
            if (isset ($_GET['edit'])) {
              blog_edit_view();
            }
          ?>
        </form>
      </div>
     </div>
   </main>
   <?php
    require_once "inc/footer.php";
   ?>
  </div>
 </body>
</html>