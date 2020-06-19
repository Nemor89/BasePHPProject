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
              <th>id</th>
              <th>дата</th>
              <th>автор</th>
              <th>описание</th>
              <th>редактировать</th>
              <th>удалить</th>
            </tr>
            <tr>
              <td>1</td>
              <td>20.05.29</td>
              <td>Nemor89</td>
              <td>описанописаниеописаниеиописаниее</td>
              <td>редактировать</td>
              <td>удалить</td>
            </tr>
          </table>
      </div>
     </div>
   </main>
   <?php
    require_once "inc/footer.php";
   ?>
  </div>
 </body>
</html>