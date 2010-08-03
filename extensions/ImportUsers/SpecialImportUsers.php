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
	'name' => 'Import Users',
	'author' => array('Yuriy Ilkiv', 'Rouslan Zenetl'),
	'svn-date' => '$LastChangedDate: 2009-01-25 21:00:55 +0100 (ndz, 25 sty 2009) $',
	'svn-revision' => '$LastChangedRevision: 46219 $',
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
