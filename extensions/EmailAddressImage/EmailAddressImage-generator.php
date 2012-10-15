<?php
// Code modified by Maarten (MediaWiki.org User:Thinkling) from example obtained here:
// http://www.tech-recipes.com/php_programming_tips1470.html

// usage:
//   Blah blah <img src="generate_text_image.php?str=name@domain.com"
//   style="vertical-align: text-top;"> blah blah.

Header ("Content-type: image/gif");

if (isset($_REQUEST['str'])) {
	$string = $_REQUEST['str'];
} else {
	$string = "[Invalid email address]";
}

$font  = 4;
$width  = ImageFontWidth($font)* strlen($string);
$height = ImageFontHeight($font); // + 5;
$im = ImageCreate($width,$height);

$x=imagesx($im)-$width ;
$y=imagesy($im)-$height; // + 2;

$background_color = imagecolorallocate ($im, 242, 242, 242); //white background
$text_color = imagecolorallocate ($im, 0, 0,0);//black text
$trans_color = $background_color;//transparent colour

imagecolortransparent($im, $trans_color);
imagestring ($im, $font, $x, $y,  $string, $text_color);

imagegif($im);
ImageDestroy($im);
