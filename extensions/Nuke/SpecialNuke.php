<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['Nuke'] = $dir . 'SpecialNuke.i18n.php';
$wgExtensionAliasesFiles['Nuke'] = $dir . 'SpecialNuke.alias.php';

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Nuke',
	'description'    => 'Gives sysops the ability to mass delete pages',
	'descriptionmsg' => 'nuke-desc',
	'author'         => 'Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Nuke'
);

$wgGroupPermissions['sysop']['nuke'] = true;
$wgAvailableRights[] = 'nuke';

$wgAutoloadClasses['SpecialNuke'] = $dir . 'SpecialNuke_body.php';
$wgSpecialPages['Nuke'] = 'SpecialNuke';
$wgSpecialPageGroups['Nuke'] = 'pagetools';
