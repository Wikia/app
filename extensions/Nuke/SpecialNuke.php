<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['Nuke'] = $dir . 'SpecialNuke.i18n.php';
$wgExtensionAliasesFiles['Nuke'] = $dir . 'SpecialNuke.alias.php';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Nuke',
	'svn-date'       => '$LastChangedDate: 2008-07-10 07:28:42 +0000 (Thu, 10 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37469 $',
	'description'    => 'Gives sysops the ability to mass delete pages',
	'descriptionmsg' => 'nuke-desc',
	'author'         => 'Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Nuke'
);

$wgGroupPermissions['sysop']['nuke'] = true;
$wgAvailableRights[] = 'nuke';

$wgAutoloadClasses['SpecialNuke'] = $dir . 'SpecialNuke_body.php';
$wgSpecialPages['Nuke'] = 'SpecialNuke';
