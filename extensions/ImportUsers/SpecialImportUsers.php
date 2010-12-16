<?php
/**
 *
 * @subpackage Extensions
 *
 * @author Rouslan Zenetl
 * @author Yuriy Ilkiv
 * @license You are free to use this extension for any reason and mutilate it to your heart's liking.
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Import Users',
	'author' => array('Yuriy Ilkiv', 'Rouslan Zenetl'),
	'url' => 'http://www.mediawiki.org/wiki/Extension:ImportUsers',
	'description' => 'Imports users in bulk from CSV-file; encoding: UTF-8',
	'descriptionmsg' => 'importusers-desc',
);

$wgAvailableRights[] = 'import_users';
$wgGroupPermissions['bureaucrat']['import_users'] = true;

$dir = dirname(__FILE__) . '/';
$wgSpecialPages['ImportUsers'] = 'SpecialImportUsers';
$wgSpecialPageGroups['ImportUsers'] = 'users';
$wgAutoloadClasses['SpecialImportUsers'] = $dir . 'SpecialImportUsers_body.php';
$wgExtensionMessagesFiles['ImportUsers'] = $dir . 'SpecialImportUsers.i18n.php';
$wgExtensionAliasesFiles['ImportUsers'] = $dir . 'SpecialImportUsers.alias.php';
