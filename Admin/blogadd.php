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
        <form class="blogadd" action="blogadd.php" method="post" enctype="multipart/form-data">
            <p class="categoryp">Выберите категории:</p>
            <div class="categoryadddiv">
            <?php
              categories();
            ?>
          </div>
          <p class="categoryp">Введите описание блога:</p>
          <textarea class="blogadddesc" name="blogdesc"><?=$_POST['blogdesc']?></textarea>
          <p class="categoryp">Введите текст блога:</p>
          <textarea class="blogaddtext" name="blogtext"><?=$_POST['blogtext']?></textarea>
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