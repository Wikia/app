<?php

class SkinSchulenburg extends Skin {
	var $out;

	function getMainCss() {
		return "{$this->path}/main.css";
	}

	function getMainJs() {
		return "{$this->path}/main.js";
	}

	function outputPage( $out ) {
		global $wgContLang, $wgSchulenburgSkinPath, $wgScriptPath;
		$lang = $wgContLang->getCode();
		$this->path = $wgSchulenburgSkinPath ? $wgSchulenburgSkinPath : "{$wgScriptPath}/extensions/skins/Schulenburg";
		$this->out = $out;
		$bodyText = $out->getHTML();
		$bodyText = preg_replace( '!(<img[^>]*src=")schstock/!', "$1{$this->path}/images/", $bodyText );
		$bodyText = preg_replace( '!(<[^>]*style="[^"]*url\()schstock/!', "$1{$this->path}/images/", $bodyText );
		$bodyText = preg_replace( '!(<input[^>]*src=")schstock/!', "$1{$this->path}/images/", $bodyText );
		$query = 'usemsgcache=yes&action=raw&ctype=text/css&smaxage=2678400';
		$siteCss = Title::newFromText( 'MediaWiki:Schulenburg.css' )->getLocalUrl( $query );
		$siteJs = Title::newFromText( 'MediaWiki:Schulenburg.js' )->getLocalUrl( $query );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Language" content="<?php echo htmlspecialchars( $lang ) ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo htmlspecialchars( $out->getPageTitle() )?> </title>
		<link rel="stylesheet" href="<?php echo htmlspecialchars( $this->getMainCss() ); ?>" type="text/css"/>
		<script type="text/javascript" src="<?php echo htmlspecialchars( $this->getMainJs() ); ?>"></script>
		<link rel="stylesheet" href="<?php echo htmlspecialchars( $siteCss ); ?>" type="text/css"/>
		<script type="text/javascript" src="<?php echo htmlspecialchars( $siteJs ); ?>"></script>
		<style type="text/css">
			body {
				margin: 0px;
				padding: 0px;
				background-image:url(<?php echo htmlspecialchars( "{$this->path}/images/background.gif" ) ; ?> ); background-repeat:repeat-y;
				background-position:center;
				background-color:#006699; 
				font-family: Verdana, Arial, Sans-Serif;
				font-size: 10pt;
			}
		</style>
	</head>

	<body>
		<div align="center">
			<?php echo $bodyText ?>
		</div>
	</body>
</html>

<?php
	}
}

