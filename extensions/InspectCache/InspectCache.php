<?php
/*
 * This is a simple debugging tool to inspect the contents of the shared cache
 * It is unrestricted and insecure, do not enable it on a public site.
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "InspectCache extension";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'version'        => '0.2',
	'name'           => 'InspectCache',
	'author'         => 'Tim Starling, Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:InspectCache',
	'description'    => 'A simple debugging tool to inspect the contents of the shared cache',
	'descriptionmsg' => 'inspectcache-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['InspectCache'] = $dir . 'InspectCache.i18n.php';
require_once( $dir . '../ExtensionFunctions.php' );
extAddSpecialPage( $dir . 'InspectCache_body.php', 'InspectCache', 'InspectCache' );
