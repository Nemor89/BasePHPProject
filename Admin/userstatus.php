<?php
require_once '../functions/functions.php';
if (!empty ($_POST['statusupdate'])) {
  $errorMsg = user_status_update();
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('input[type="file"]').change(function(){
      var value = $("input[type='file']").val();
      $('.js-value').text(value);
      }); 
    });
  </script>
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
        <h1 id='stat'>Выберите статус пользователя:</h1>
        <form class="blogadd" method="post" enctype="multipart/form-data">
          <?php
            if (!empty ($_GET['status'])) {
              user_status();
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