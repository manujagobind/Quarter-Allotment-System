<?php
//Adapted from The Art of Web: www.the-art-of-web.com

$image = imagecreatetruecolor(120, 30) or die('Cannot initialize new GD image stream');

$background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$line_color = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
$text_color = imagecolorallocate($image, 0x33, 0x33, 0x33);

imagefill($image, 0, 0, $background);

//add random lines
for($i=0; $i<6; $i++){
  imagesetthickness($image, rand(1, 3));
  imageline($image, 0, rand(0, 30), 120, rand(0, 30), $line_color);
}

session_start();

//add random digits
$digit = '';
for($x=15;$x<=95;$x+=20){
  $digit .= ($num = rand(0, 9));
  imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $text_color);
}

$_SESSION['digit'] = $digit;
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);

?>
