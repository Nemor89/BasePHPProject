<?php
require_once 'functions/functions.php';
if (!empty ($_POST['submit'])) {
  $errorMsg = registr();
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="styles/styles.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('input[type="file"]').change(function(){
      var value = $("input[type='file']").val();
      $('.js-value').text(value);
      }); 
    });
    </script>
  <title>Регистрация</title>
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
        <div class="errormsg">
         <span><?=$errorMsg?></span>
        </div>
        <form class="regform" action="registr.php" method="post" enctype="multipart/form-data">
          <h1>Регистрация</h1>
          <input class="reg" type="text" name="login" placeholder="Логин">
          <input class="reg" type="email" name="email" placeholder="Email">
          <input class="reg" type="password" name="password" placeholder="Пароль">
          <input class="reg" type="password" name="confirm" placeholder="Повторите пароль">
          <div class="example-3">
              <label for="custom-file-upload" class="filupp">
              <span class="filupp-file-name js-value">Загрузить аватар</span>
              <input type="file" class="avatar" name="attachment-file" value="1" id="custom-file-upload" accept="image/jpeg,image/png">
              </label>
          </div>
          <input class="regbtn" type="submit" name="submit" value="Регистрация">
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