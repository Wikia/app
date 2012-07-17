<?php
	
function replaceColorInImage ($image, $new_r, $new_g, $new_b)
{
	imagefilter($image, IMG_FILTER_COLORIZE, $new_r, $new_g, $new_b);
    return $image;
}

$baseDir = dirname( __FILE__ ) . '/';


$path = realpath($baseDir . $_GET['file']); 

if(strpos($path, $baseDir) !== 0 ) {
	die('Invalid Path'); 
	exit;
}

$img1 = imagecreateFrompng($path); 
imagealphablending($img1, true); // setting alpha blending on
imagesavealpha($img1, true); 
//$black = imagecolorallocate($im, 255, 0, 0);
//imagecolortransparent($img1, $black);


$img2 = replaceColorInImage($img1, $_GET['r'], $_GET['g'], $_GET['b']);
 
header("Content-type: image/png");
imagepng($img2);

//imagedestroy($img2);
imagedestroy($img1);

?>