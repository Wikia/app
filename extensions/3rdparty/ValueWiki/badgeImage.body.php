<?php 

if (!defined('DIR_SEP')) {
    define('DIR_SEP', DIRECTORY_SEPARATOR);
}

class BadgeImage extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'BadgeImage'/*class*/ );
	}

	function LoadPNG($imgname) {
		try {
			$im = imagecreatefrompng($imgname); /* Attempt to open */
			if (!$im) { /* See if it failed */
				$im  = imagecreatetruecolor(150, 30); /* Create a blank image */
				$bgc = imagecolorallocate($im, 255, 255, 255);
				$tc  = imagecolorallocate($im, 0, 0, 0);
				imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
				/* Output an errmsg */
				imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
			}
		} catch (Exception $e) {
			echo 'LoadPNG Exception: ' . $e->getMessage();
		}
		return $im;
	}

	function align_right($string, $fontfile, $imgwidth, $fontsize) {
		$spacing = 0;
		$line = array("linespacing" => $spacing);
		list($lx,$ly,$rx,$ry) = imageftbbox($fontsize,0,$fontfile,$string,$line);
		$textwidth = $rx - $lx;
		$imw = ($imgwidth-5-$textwidth);
		return $imw;
	}

	function getCacheURL($symbol) {
		global $wgMemc, $wgUploadPath;

		$key = wfMemcKey( 'badge', $symbol );
		$cache = $wgMemc->get( $key );

		if ( !empty( $cache ) ) {
			return $cache;
		}

		$this->makeBadge($symbol);

		$directory	= substr($symbol, 1, 1);
		if ($directory== FALSE) {
			$directory = '0';
		}

		$url = "$wgUploadPath/badges/$directory/$symbol.png";

		$wgMemc->set( $key, $url, 60 * 60 * 24 );

		return $url;
	}

	function makeBadge($symbol) {
		global $wgUploadDirectory;

		try {
			$flag	= "sl1c1";
			$size 	= 20;
			$font	= "/usr/share/fonts/dejavu-fonts/DejaVuSans-Bold.ttf";
			$font2	= "/usr/share/fonts/dejavu-fonts/DejaVuSans.ttf";
			$directory	= substr($symbol, 1, 1);

			if ($directory == FALSE) {
				$directory = '0';
			}

			$username="wikiuser";
			$password="wikiuser!!";
			$database="wiki";

			$sqlsymbol = $symbol;
			$sqlsymbol = str_ireplace('colon', ':', $sqlsymbol);
			$sqlsymbol = str_ireplace('dot', '.', $sqlsymbol);

			$imgsymbol	= $symbol;
			$myImage 	= $this->LoadPNG("$wgUploadDirectory/badge_bg.png");
			$black 		= imagecolorallocate($myImage,0,0,0);
			$green		= imagecolorallocate($myImage, 0, 150, 0);
			$red		= imagecolorallocate($myImage, 150, 0, 0);
			$url 		= "http://finance.yahoo.com/d/quotes.csv?e=csv&s=" . $symbol . "&f=" . $flag;
			if (stripos($imgsymbol, '.')) {
				$imgsymbol	= substr($imgsymbol, 0, stripos($imgsymbol, '.'));
			}

			global $wgHTTPProxy;
			$ch = curl_init();    // Starts the curl handler
			curl_setopt($c, CURLOPT_URL, $url); // Sets the paypal address for curlcurl_setopt($c, CURLOPT_FAILONERROR, 1);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // Returns result to a variable instead of echoing
			curl_setopt($c, CURLOPT_TIMEOUT, 3); // Sets a time limit for curl in seconds (do not set too low)
			curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy); // set HTTP proxy
			$info = curl_exec($c); // run the curl process (and return the result to $result
			curl_close($ch);

			$info		= str_ireplace('"', '', $info);
			$info 		= explode(',', $info);

			$price 	= 'n/a';
			$change	= 'n/a';

			if (isset($info[1])) {
				$price 	= '$' . $info[1];
			}
			if (isset($info[2])) {
				$change	= str_replace('+', '+ $', $info[2]);
			}
			$color 	= $black;

			if (strstr($change, '+')) {
				$color = $green;
			} elseif (strstr($change, '-')) {
				$color = $red;
			}

			$right 	= $this->align_right($price, $font2, 160, 9);
			$right2 = $this->align_right($change, $font2, 160, 9);
			imagefttext($myImage, $size, 0, 5, 26, $black, $font, $imgsymbol);
			imagefttext($myImage, 9, 0, $right, 14, $black, $font2, $price);
			imagefttext($myImage, 9, 0, $right2, 28, $color, $font2, $change);

			$path = $wgUploadDirectory . '/badges/' . $directory . '/' . $symbol . '.png';

			imagepng($myImage, $path);

		} catch (Exception $e) {
			echo 'Badge Exception: ' . $e->getMessage();
		}
	}

	function execute( $symbol ) {
		try {
			$url = $this->getCacheURL($symbol);

			header("Location: $url"); 

		} catch (Exception $e) {
			echo 'Body exception: ' . $e->getMessage() . "\n";
		}

	}

}
