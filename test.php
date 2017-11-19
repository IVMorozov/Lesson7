<!DOCTYPE html>
<html lang="ru">
  <head>
	  <meta charset="utf-8">
	  <title>Тестирование</title>
  	<link rel="stylesheet" href="styles.css">
  </head>
    <body>

      <section class="bgrnd-main">
        <nav>
          <a class="navigation" href="admin.php">Загрузка теста</a>
          <a class="navigation" href="list.php">Выбор тестов</a>
          <a class="navigation active" href="test.php">Тестирование</a>
        </nav>
        
          
      <?php
      error_reporting(0);
            
      $pieces = explode("item=", $_SERVER['REQUEST_URI']);
      If (isset($pieces[1])) {
          $test_path = __DIR__  .  DIRECTORY_SEPARATOR  . Tests .  DIRECTORY_SEPARATOR  . $pieces[1];
          
          if (!file_exists($test_path)) {
            header('HTTP/1.1 404 Not Found');
            exit;
          }
          $tmp_path = file_get_contents($test_path);
          $test_json = json_decode($tmp_path, true);
      ?>
          <section class="testblock">
          <form class="list" action="test.php" method="POST">
            <?php
              $Test_index = count($test_json)-2;
              $Test_number;
              $item;
              $break='vs';
              $index;
              $Ansers_checked;
              $Test_count = count($test_json)-1;
      
              echo'<h1 >Ответьте на вопросы теста:</h1>';
              for ($Test_number = 0; $Test_number <= $Test_index; $Test_number++) {
                echo'<div class="test-part">';
                $Correct_answer[$Test_number]=$test_json[$Test_number]['correct_answer'];
                echo'<h1 class="test-header">'. $test_json[$Test_number]['question'].'</h1>';
                  foreach ($test_json[$Test_number]['answers'] as $index => $item) {
                    echo '<input class="item" type="radio" name="Answers['.$Test_number.']" value='.$item.$break.$test_json[$Test_number]['correct_answer'].$break.$Test_count.'>'.$item;}
                echo'</div>' ;   
              }    
            ?>
            <p><input class="testchoice" type="submit" value="Ответить"></p>
          </form>
        
      <?php
      }
      else {
        if (count($_POST) == 0 ) {
          echo'<p class="final">Вы не выбрали ни один вариант, начните заново с выбора теста (вкладка "выбор тестов")</p>';
          exit;
        }
        $Ansers_checked=$_POST;
        $Result;
        $Test_count;
        $Result_count;
        $All_Test_count;
        $Final_result;
        $Missed_Count;

        foreach ($Ansers_checked['Answers'] as $index => $answer) {
          $Chek=explode('vs', $answer);
          If ($Chek[0]==$Chek[1]) {
             $Result[$answer]=1;
             $All_Test_count=$Chek[2];
          } 
            else {
              $Result[$answer]=0;
              $All_Test_count=$Chek[2];
            }
          $Result_count=$Result_count+$Result[$answer];
        }

        $Test_count=count($Result);
        $Missed_Count=$All_Test_count-$Test_count;
        IF ($Missed_Count==0) {unset($Missed_Count);} else {$Missed_Count= '<br> Проигнорировали вопросов - '.$Missed_Count;}
        if ($Result_count>0) { 
          $Final_result= 'Вы ответили правильно на '.$Result_count.' из '.$All_Test_count.' вопросов!';
          echo'<p class="final">'.$Final_result.$Missed_Count.'</p>';
          Session_start();
          $Mark = $Result_count/$All_Test_count*100;
          $_SESSION['mark']=$Mark;
          ?>
          <form action="sertificate.php" method="POST">
            <label class="final">Введите Ваше имя</label>
            <p><input type="text" name="username"></p>
            <br>
            <input type="submit" value="Далее">
          </form>
        <?php
        } 
          else { 
            $Final_result='Вы не ответили правильно ни на один вопрос!';
            echo'<p class="final">'.$Final_result.$Missed_Count.'</p>';
          }
    }
    ?>
    </section>
  </body>
</html>