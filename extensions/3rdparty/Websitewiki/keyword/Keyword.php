<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named Keyword.\n";
	exit(1) ;
}

$dir = dirname(__FILE__);
$wgAutoloadClasses['Keyword'] = $dir . '/Keyword.body.php';
$wgExtensionMessagesFiles['Keyword'] = $dir . '/Keyword.i18n.php';
$wgSpecialPages['Keyword'] = 'Keyword';