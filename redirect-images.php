<?php
/**
 * redirect old http://wikia/images to http://images/wikia/images
 * eloy@wikia.com
 */

$HeadURL = split('/', '$HeadURL$');
$wgReleaseNumber = ($HeadURL[4] === "trunk" ) ? "trunk" : $HeadURL[5]; // we generally use wgCacheBuster now instead.  can use that here instead of wgReleaseNumber if desired

$wgStylePath      = "http://images.wikia.com/common/__cb{$wgReleaseNumber}/skins";
$newUrl = "";
$age = 1200;

$imgUrl = "http://images.wikia.com/";
if( isset( $_GET["skinpath"] ) ) {
	$skinPath = $_GET["skinpath"];
	$newUrl = $wgStylePath . "/" . $skinPath;
	$age =  86000;
}
else {
	$imgFile = stripslashes($_GET["image"]);
	#--- we take first part of domain name
	if (!empty($_SERVER['SERVER_NAME'])) {
		$aDomainParts = explode(".", $_SERVER['SERVER_NAME']);
	}

	/**
	 * we have two kinds of domains:
	 * 1) three parts (wikia-name.wikia.com)
	 * 2) four parts (language.wikia-name.wikia.com)
	 *
	 * and ...
	 *
	 * 3) others as well but we so far handle only these two with some exceptions
	 */

	if( $_SERVER['SERVER_NAME'] === "uncyclopedia.org" ) {
		$newUrl = $imgUrl .  "uncyclopedia/images/" . $imgFile;
	}
	elseif( count($aDomainParts) == 3 ) {
		#--- first part should be wikia name
		$newUrl= $imgUrl . $aDomainParts[0] . "/images/" . $imgFile;
	}
	elseif ( count($aDomainParts) == 4 ) {
		#--- first part should be wikia name
		$newUrl = "{$imgUrl}{$aDomainParts[1]}/{$aDomainParts[0]}/images/{$imgFile}";
	}
}


header("Cache-Control: public, max-age={$age}", true);
header("Location: {$newUrl}", true, 301);
exit(0);
