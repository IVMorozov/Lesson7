<!DOCTYPE html>
<html lang="ru">
  <head>
	  <meta charset="utf-8">
	  <title>Выбор теста</title>
  	<link rel="stylesheet" href="styles.css">
  </head>
  <body>

    <section class="bgrnd-main">
      <nav>
        <a class="navigation" href="admin.php">Загрузка теста</a>
        <a class="navigation active" href="list.php">Выбор тестов</a>
        <a class="navigation" href="test.php">Тестирование</a>
      </nav>
      
        <p class="help-block">Выберете тест</p>
    </section>
    <?php
      error_reporting(0);
      $dir = (__DIR__  .  DIRECTORY_SEPARATOR  . Tests);
      $files = scandir($dir);
      foreach ($files as $index => $filetype) {
        If  (strrpos($filetype, 'json')) {$Testlist[]= $filetype;}
      }    
    ?>

    <section class="bgrnd-test">
      <div class="testarea">
        <form class="list" action="test.php" method="GET" >
          <?php            
            foreach ($Testlist as $index => $file) {
              echo '<input class="item" type="radio" name="item" value='.$file.'>'.$file.'<Br>';}
          ?>
          <p><input class="testchoice" type="submit" value="Выбрать тест"></p>
        </form>
      </div>
    </section>
  </body>
</html>