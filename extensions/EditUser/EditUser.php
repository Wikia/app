<?php
/**
* EditUser extension by Ryan Schmidt
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'EditUser',
	'version' => '1.4',
	'author' => 'Ryan Schmidt',
	'description' => 'Allows privileged users to edit other users\' preferences',
	'descriptionmsg' => 'edituser-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:EditUser',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['EditUser'] = $dir . 'EditUser.i18n.php';
$wgExtensionAliasesFiles['EditUser'] = $dir . 'EditUser.alias.php';
$wgAutoloadClasses['EditUser'] = $dir . 'EditUser_body.php';
$wgSpecialPages['EditUser'] = 'EditUser';
$wgAvailableRights[] = 'edituser';
$wgAvaliableRights[] = 'edituser-exempt';
$wgSpecialPageGroups['EditUser'] = 'users';

