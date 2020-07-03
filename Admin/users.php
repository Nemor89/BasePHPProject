<?php
require_once '../functions/functions.php';
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
  <title>Пользователи</title>
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
          <h1 id='stat'>Список пользователей:</h1>
          <table class="adminblogs" border="1" cellpadding="5" cellspacing="0">
            <tr>
              <th>ID</th>
              <th>Никнейм</th>
              <th>Статус</th>
              <th>Удалить</th>
              <th>Забанить</th>
            </tr>
            <?php
              users_view();
            ?>
          </table>
            <?php
              blog_buttons_admin();
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