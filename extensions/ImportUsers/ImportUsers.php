<?php
/**
 * ImportUsers extension -- allows to import users in bulk from a CSV file
 *
 * @file
 * @ingroup Extensions
 * @version 1.2
 * @author Rouslan Zenetl
 * @author Yuriy Ilkiv
 * @license You are free to use this extension for any reason and mutilate it to your heart's liking.
 * @link http://www.mediawiki.org/wiki/Extension:ImportUsers Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Import Users',
	'version' => '1.2',
	'author' => array( 'Yuriy Ilkiv', 'Rouslan Zenetl' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:ImportUsers',
	'descriptionmsg' => 'importusers-desc',
);

// New user right, required to access and use Special:ImportUsers
$wgAvailableRights[] = 'import_users';
$wgGroupPermissions['bureaucrat']['import_users'] = true;

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgSpecialPages['ImportUsers'] = 'SpecialImportUsers';
$wgSpecialPageGroups['ImportUsers'] = 'users';
$wgAutoloadClasses['SpecialImportUsers'] = $dir . 'ImportUsers_body.php';
$wgExtensionMessagesFiles['ImportUsers'] = $dir . 'ImportUsers.i18n.php';
$wgExtensionMessagesFiles['ImportUsersAlias'] = $dir . 'ImportUsers.alias.php';
