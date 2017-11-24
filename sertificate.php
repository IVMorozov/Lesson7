<?php
header("Content-type: image/png");
if (!$_POST['username']) {
  $name = 'Неизвестный пользователь';
  $size=30;
}
 else {
   $name = $_POST['username'];
   $size=50;
 }
$font = (__DIR__. DIRECTORY_SEPARATOR  .'times.ttf');

$sert = imagecreatetruecolor(800, 600);
$textColor = imagecolorallocate($sert, 120, 220, 100);
$bgrndColor=0;
imagefill($sert, 0, 0, $bgrndColor);
$sertPNG = imagecreatefrompng(__DIR__. DIRECTORY_SEPARATOR  .'sertificate.png');
imagecopy($sert, $sertPNG, 0, 0, 0, 0, 800, 600);

$sert_text = imagecreate(700, 500);
$textColor = imagecolorallocate($sert, 255, 255, 255);
Session_start();
imagettftext($sert, 50, 0, 180, 120, $textColor, $font, "СЕРТИФИКАТ");
imagettftext($sert, 25, 0, 250, 200, $textColor, $font, "выдан пользователю");
imagettftext($sert, $size, 0, 180, 320, $textColor, $font, $name);
imagettftext($sert, 20, 0, 180, 420, $textColor, $font, "Результат прохождения теста - ".$_SESSION['mark']."%");
imagePNG($sert);
imageDestroy($sert);
