<header>
  <div class="header">
    <div>
      <img class="logo" src="img/php_PNG5.png">
    </div>
    <div class="descriptionhead">
      <h4><?echo visitor_name()?><br><?echo my_daytime()?><br>Опробуйте доступный функционал сайта и оставь отзыв о его работе!</h4>
    </div>
    <?php
    echo avatar_view();
    ?>
    <div>
     <?php
     echo header_menu();
     ?>
    </div>
  </div>
</header>