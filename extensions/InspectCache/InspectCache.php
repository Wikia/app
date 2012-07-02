<?php
/**
 * This is a simple debugging tool to inspect the contents of the shared cache
 * It is unrestricted and insecure, do not enable it on a public site.
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "InspectCache extension";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'version'        => '0.3',
	'name'           => 'InspectCache',
	'author'         => array( 'Tim Starling', 'Brion Vibber' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:InspectCache',
	'descriptionmsg' => 'inspectcache-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['InspectCache'] = $dir . 'InspectCache.i18n.php';
$wgExtensionMessagesFiles['InspectCacheAlias'] = $dir . 'InspectCache.alias.php';
$wgAutoloadClasses['SpecialInspectCache'] = $dir . 'InspectCache_body.php';

$wgSpecialPages['InspectCache'] = 'SpecialInspectCache';
$wgSpecialPageGroups['InspectCache'] = 'wiki';

$wgAvailableRights[] = 'inspectcache';
$wgGroupPermissions['sysop']['inspectcache'] = true;
