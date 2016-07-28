<?php
/**
 * A Special Page extension to rename users, runnable by staff members.
 * Based on the RenameUser MediaWiki extension by Arnfjörð Bjarmason and Aaron Schulz.
 *
 * REQUIRES THE FOLLOWING EXTENSIONS TO BE ENABLED:
 * StaffLog, TaskManager, Phalanx, SpecialPhalanx
 */

// check for dependencies
if (!defined('MEDIAWIKI')) die("This is MediaWiki extension and cannot be used standalone.");

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UserRenameTool',
	'author' => array('Federico "Lox" Lucignano', 'Władysław Bodzek'),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserRenameTool',
	'description' => 'Renames a user (need \'\'renameuser\'\' right)',
	'descriptionmsg' => 'userrenametool-desc'
);

$dir = dirname(__FILE__) . '/';

// special pages
$wgSpecialPages['UserRenameTool'] = 'UserRenameToolController';
$wgSpecialPageGroups['UserRenameTool'] = 'users';

// internationalization files
$wgExtensionMessagesFiles['UserRenameTool'] = $dir . 'UserRenameTool.i18n.php';

// classes
$wgAutoloadClasses['UserRenameToolController'] = $dir . 'UserRenameToolController.class.php';
$wgAutoloadClasses['UserRenameToolHelper'] = $dir . 'UserRenameToolHelper.class.php';
$wgAutoloadClasses['UserRenameToolProcess'] = $dir . 'UserRenameToolProcess.class.php';
$wgAutoloadClasses['UserRenameToolProcessGlobal'] = $dir . 'UserRenameToolProcessGlobal.class.php';
$wgAutoloadClasses['UserRenameToolProcessLocal'] = $dir . 'UserRenameToolProcessLocal.class.php';
$wgAutoloadClasses['UserRenameToolTask'] = $dir . 'UserRenameToolTask.class.php';

// log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders;
$wgLogTypes[] = 'renameuser';
$wgLogNames['renameuser'] = 'userrenametool-logpage';
$wgLogHeaders['renameuser'] = 'userrenametool-logpagetext';

// hooks
$wgHooks['StaffLog::formatRow'][] = 'UserRenameToolStaffLogFormatRow';

function UserRenameToolStaffLogFormatRow( $type, $row, $time, $linker, &$out ) {
	if ( $type == "renameuser" ) {
		$out = "$time Rename - {$row->slog_comment}";
		return false;
	}

	return true;
}
