<?php
require_once 'functions/functions.php';
if (!empty ($_POST['comment'] && !empty ($_POST['commentsubmit']))) {
  comment_add();
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="styles/styles.css">
  <title>Главная страница</title>
 </head>
 <body>
  <div class="main">
    <?php
    require_once "inc/header.php";
    ?>
   <main>
     <div class="maincontent-art">
      <?php
        require_once "inc/leftmenu.php";
      ?>
      <div class="content">
        <?php
          if (!empty ($_GET['id'])) {
            article_view($_GET['id']);
            comments_view();
        }
          if ($_SESSION['auth']) {
        ?>
          <br><br><br><br><br><br><br>
          <p class="attention">Оставьте комментарий!</p>
          <form method="POST">
          <textarea class="commentarea" name="comment"></textarea>
          <input class="reviewsubmit" type="submit" name="commentsubmit">
          </form>
        <?php
          } else {
        ?>
          <br><br><br><br><br><br><br>
          <p class="attention">Авторизуйтесь, чтобы оставить комментарий!</p>
        <?php
          }
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