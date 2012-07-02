<?php
/**
* EditUser extension by Ryan Schmidt
*/

if(!defined('MEDIAWIKI')) {
	echo "This file is an extension to the MediaWiki software and is not a valid access point";
	die(1);
}

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'EditUser',
	'version'        => '1.7.0',
	'author'         => 'Ryan Schmidt',
	'descriptionmsg' => 'edituser-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:EditUser',
);

// Internationlization files
$wgExtensionMessagesFiles['EditUser'] = $dir . 'EditUser.i18n.php';
$wgExtensionMessagesFiles['EditUserAliases'] = $dir . 'EditUser.alias.php';
// Special page classes
$wgAutoloadClasses['EditUser'] = $dir . 'EditUser_body.php';
$wgSpecialPages['EditUser'] = 'EditUser';
$wgSpecialPageGroups['EditUser'] = 'users';

// Default group permissions
$wgAvailableRights[] = 'edituser';
$wgAvailableRights[] = 'edituser-exempt';
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;
