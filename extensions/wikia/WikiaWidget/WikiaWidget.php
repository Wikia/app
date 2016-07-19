<?php
if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaWidget',
	'author' => 'Christian Williams',
	'descriptionmsg' => 'wikiawidget-desc',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaWidget'
);
 
$dir = dirname(__FILE__);

/*
$wgAutoloadClasses['WikiaWidget'] = $dir . 'WikiaWidget_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['WikiaWidget'] = 'WikiaWidget'; # Let MediaWiki know about your new special page.
*/

$wgExtensionMessagesFiles['WikiaWidget'] = $dir . '/WikiaWidget.i18n.php';



extAddSpecialPage( dirname(__FILE__) . '/WikiaWidget_body.php', 'WikiaWidget', 'WikiaWidget' );
$wgSpecialPageGroups['WikiaWidget'] = 'wikia';
