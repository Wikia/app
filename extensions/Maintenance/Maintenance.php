<?php
// web interface for various maintenance scripts

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Maintenance',
	'description'    => '[[Special:Maintenance|Web interface]] for various maintenance scripts',
	'descriptionmsg' => 'maintenance-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Maintenance',
	'author'         => 'Ryan Schmidt',
	'version'        => '1.0',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Maintenance'] = $dir . 'Maintenance.i18n.php';
$wgExtensionAliasesFiles['Maintenance'] = $dir . 'Maintenance.alias.php';
$wgAutoloadClasses['Maintenance'] = $dir . 'Maintenance_body.php';
$wgSpecialPages['Maintenance'] = 'Maintenance';
$wgAvailableRights[] = 'maintenance';
