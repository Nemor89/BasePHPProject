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
        <div class="blogaddbtn">
          <a id="blogadd" href="blogadd.php">Добавить блог</a>
        </div>
          <table class="adminblogs" border="1" cellpadding="5" cellspacing="0">
            <tr>
              <th>ID</th>
              <th>Дата</th>
              <th>Автор</th>
              <th>Описание</th>
              <th>Редактировать</th>
              <th>Удалить</th>
            </tr>
              <?php
                blog_view_admin();
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