<?php
if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaWidget',
	'author' => 'Christian Williams',
	'description' => 'Create Wikia Widgets for use on external sites or for inclusion on your wiki',
	'version' => '1.0',
);
 
$dir = dirname(__FILE__) . '/';

/*
$wgAutoloadClasses['WikiaWidget'] = $dir . 'WikiaWidget_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['WikiaWidget'] = 'WikiaWidget'; # Let MediaWiki know about your new special page.
*/



/**
 * permissions
 */
$wgAvailableRights[] = 'wikiawidget';
$wgGroupPermissions['staff']['wikiawidget'] = true;
$wgGroupPermissions['sysop']['wikiawidget'] = true;
$wgGroupPermissions['wikiawidget']['wikiawidget'] = true;

extAddSpecialPage( dirname(__FILE__) . '/WikiaWidget_body.php', 'WikiaWidget', 'WikiaWidget' );
$wgSpecialPageGroups['WikiaWidget'] = 'wikia';
