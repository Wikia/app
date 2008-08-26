<?php
/**
 * @version 1.1.1
 * @version 1.1.7
 *          added static function for message loading
 */
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install DynamicPageList as a special page, put the following line in LocalSettings.php:
require_once( "$IP/extensions/DynamicPageList/DynamicPageListSP.php" );
EOT;
        exit( 1 );
}

$wgAutoloadClasses['DynamicPageListSP'] = dirname(__FILE__) . '/DynamicPageListSP_body.php';
$wgSpecialPages['DynamicPageListSP'] 	= 'DynamicPageListSP';
// obviously LoadAllMessages needs a static function as a callback
$wgHooks['LoadAllMessages'][] 			= 'wfDynamicPageListSPloadMessages';

function wfDynamicPageListSPloadMessages() {
	DynamicPageListSP::loadMessages();
}
?>