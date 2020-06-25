<?php
require_once '../functions/functions.php';
if (!empty ($_POST['blogadd'])) {
  $errorMsg = blog_add();
}
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
            <p class="categoryp">Выберите категории:</p>
            <div class="categoryadddiv">
              <input type="checkbox" id="category" name="category[]" value="1" multiple> WEB
              <input type="checkbox" id="category" name="category[]" value="2" multiple> PHP
              <input type="checkbox" id="category" name="category[]" value="3" multiple> HTML\CSS
              <input type="checkbox" id="category" name="category[]" value="4" multiple> Спорт
              <input type="checkbox" id="category" name="category[]" value="5" multiple> Политика
              <input type="checkbox" id="category" name="category[]" value="6" multiple> Разное
          </div>
          <p class="categoryp">Введите описание блога:</p>
          <textarea class="blogadddesc" name="blogdesc"></textarea>
          <p class="categoryp">Введите текст блога:</p>
          <textarea class="blogaddtext" name="blogtext"></textarea>
          <div class="example-2">
            <label for="custom-file-upload" class="filupp"><span class="filupp-file-name js-value">Загрузить картинку</span>
              <input type="file" class="avatar" name="attachment-file" value="1" id="custom-file-upload" accept="image/jpeg,image/png">
            </label>
          </div>
          <input class="regbtn" type="submit" name="blogadd" value="Добавить">
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