<?php

// Trick other code ;-)
define('MEDIAWIKI',1);

// Declare global variables to prevent warnings
$wgExtensionCredits = array();
$wgSpecialPages = array();
$wgSpecialPageGroups = array();
$wgAvailableRights= array();
$wgGroupPermissions = array();
$wgExtensionMessagesFiles = array();
$wgAutoloadClasses = array();

// Register autoload handler
function jtr_autoload( $class ) {
	global $wgAutoloadClasses;
	$filename = @$wgAutoloadClasses[$class];
	if (empty($filename))
		foreach ($wgAutoloadClasses as $k => $v)
			if ( strtolower($k) == $classLower ) {
				$filename = $v;
				break;
			}
	if (empty($filename))
		return false;
	
	require_once $filename;
	return true;
}
if ( function_exists( 'spl_autoload_register' ) ) {
	spl_autoload_register( 'jtr_autoload' );
} else {
	function __autoload( $class ) {
		jtr_autoload( $class );
	}
}

// Get cache buster
require_once "{$IP}/includes/wikia/wgCacheBuster.php";

// Include the mocks files
require_once dirname(__FILE__)."/standalone_mocks.php";

// Include the setup file
require_once dirname(__FILE__)."/JavascriptTestRunner.php";


$wgOut->addScript(sprintf("<script type=\"text/javascript\" src=\"%s\"></script>",
	AssetsManager::getInstance()->getGroupLocalURL("oasis_jquery")));
$page = new SpecialJavascriptTestRunner();
$page->execute();

$wgOut->flush();