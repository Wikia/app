<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'GroupsSidebar',
	'author' => 'Church of emacs',
	'url' => 'http://www.mediawiki.org/wiki/Extension:GroupsSidebar',
	'description' => 'Add sidebar element for specific user groups',
	'descriptionmsg' => 'groupssidebar-desc',
	'version' => '0.1',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['GroupsSidebar'] = $dir . 'GroupsSidebar.body.php'; # Tell MediaWiki to load the extension body.
$wgHooks['SkinBuildSidebar'][] = array(new GroupsSidebar(), 'efHideSidebar');
$wgExtensionMessagesFiles['GroupsSidebar'] = $dir . 'GroupsSidebar.i18n.php';
$wgGroupsSidebar = array();
