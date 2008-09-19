<?php
/**
 * rewrite /robots.txt to proper file
 * eloy@wikia.com
 */ 
$sBasePath = "/images/wikia_robots/";
$sFallback = "/images/wikia_robots/www.wikia.com.robots.txt";

/**
 * array with exceptions, is used for replacing
 */
$aExceptions = array(
	"wikia.com"	=> "www.wikia.com",
);

#--- drop www from server name
if (!empty($_SERVER['SERVER_NAME'])) {
	#--- faster than regexp
	$aDomain = explode(".", strtolower($_SERVER['SERVER_NAME']));
	if ($aDomain[0] == "www") {
		array_shift($aDomain);
	}
	$sDomain = implode(".", $aDomain);
	if (!empty($aExceptions[$sDomain])) {
		$sDomain = $aExceptions[$sDomain];
	}
	$sRobots = $sBasePath.$sDomain.".robots.txt";	
}

header("Content-type: text/plain");
if (file_exists($sRobots)) {
	@readfile($sRobots);
}
else {
	@readfile($sFallback);
}
exit(0);
?>