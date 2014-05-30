<?php
$im = imagecreate(340,400);
$bg = imagecolorallocate($im, 100, 100, 100);
$black=imagecolorallocate($im,255,255,255);

$Xcentro=imagesx($im)/2;
$Ycentro=imagesy($im)/2;

function linea($im,$x2,$y2,$color) {
  global $Xcentro,$Ycentro;
  $altezza=imagesy($im);
  $larghezza=imagesx($im);
  //DAL CENTRO
    //alto-dx
    imageline($im,$Xcentro,$Ycentro,$Xcentro+$x2,$Ycentro-$y2,$color);
    //alto-sx
    imageline($im,$Xcentro,$Ycentro,$Xcentro-$x2,$Ycentro-$y2,$color);
    //basso-dx
    imageline($im,$Xcentro,$Ycentro,$Xcentro+$x2,$Ycentro+$y2,$color);
    //basso-sx
    imageline($im,$Xcentro,$Ycentro,$Xcentro-$x2,$Ycentro+$y2,$color);
  //DA ALTO-SX
    $x2/=2;
    $y2/=2;
    //alto-sx
    imageline($im,0,0,$x2,$y2,$color);
    //alto-dx
    imageline($im,$larghezza,0,$larghezza-$x2,$y2,$color);
    //basso-dx
    imageline($im,$larghezza,$altezza,$larghezza-$x2,$altezza-$y2,$color);
    //basso-sx
    imageline($im,0,$altezza,$x2,$altezza-$y2,$color);
}

function arc($im,$x2,$y2,$color) {
  global $Xcentro,$Ycentro;
  $altezza=imagesy($im);
  $larghezza=imagesx($im);
  //DAL CENTRO
    //alto-dx
    $alfa=rand(-45,-90);$beta=rand(-45,45);
    imagearc($im,$Xcentro,$Ycentro,$Xcentro+$x2,$Ycentro-$y2,$alfa,$beta,$color);
    //alto-sx
    $alfa=rand(180,180-15);$beta=rand(-180,-90-35);
    imagearc($im,$Xcentro,$Ycentro,$Xcentro-$x2,$Ycentro-$y2,$alfa,$beta,$color);
    //basso-dx
    $alfa=rand(45,0);$beta=rand(45,90);
    imagearc($im,$Xcentro,$Ycentro,$Xcentro+$x2,$Ycentro+$y2,$alfa,$beta,$color);
    //basso-sx
    $alfa=rand(50,100);$beta=rand(135,190);
    imagearc($im,$Xcentro,$Ycentro,$Xcentro-$x2,$Ycentro+$y2,$alfa,$beta,$color);
  //DA ALTO-SX
    /*$x2/=2;
    $y2/=2;
    //alto-sx
    imagearc($im,0,0,$x2,$y2,$alfa,$beta,$color);
    //alto-dx
    imagearc($im,$larghezza,0,$larghezza-$x2,$y2,$alfa,$beta,$color);
    //basso-dx
    imagearc($im,$larghezza,$altezza,$larghezza-$x2,$altezza-$y2,$alfa,$beta,$color);
    //basso-sx
    imagearc($im,0,$altezza,$x2,$altezza-$y2,$alfa,$beta,$color);*/
}

$quante=rand(20,100);
for($i=0;$i<$quante;$i++) {
  linea($im,rand(10,$Xcentro),rand(10,$Ycentro),imagecolorallocate($im,rand(100,255),rand(100,255),rand(100,255)));
}

/* Draw a line of happy faces using imagesetbrush() with imagesetstyle */
/*$w   = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$style = array($w, $w, $w, $w, $w, $w, $w, $w, $w, $w, $w, $w, $red);
imagesetstyle($im, $style);
$brush = imagecreatefrompng("http://www.libpng.org/pub/png/images/smile.happy.png");
$w2 = imagecolorallocate($brush, 255, 255, 255);
imagecolortransparent($brush, $w2);
imagesetbrush($im, $brush);
imageline($im,0,0,100,200,IMG_COLOR_STYLEDBRUSHED);*/


/*$string = 'PHP';
$black = imagecolorallocate($im, 0, 0, 0);
imagestring($im, 1, 0, 0, $string, $black);*/

header('Content-type: image/png');
imagepng($im);
?>