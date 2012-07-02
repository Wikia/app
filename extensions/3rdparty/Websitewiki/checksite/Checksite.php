<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CheckSite.\n";
	exit(1) ;
}

$dir = dirname(__FILE__);
$wgAutoloadClasses['Checksite'] = $dir . '/Checksite.body.php';
$wgExtensionMessagesFiles['Checksite'] = $dir . '/Checksite.i18n.php';
$wgSpecialPages['Checksite'] = 'Checksite';