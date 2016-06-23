<?php
/**
 * A Special Page extension to rename users, runnable by staff members.
 * Based on the RenameUser MediaWiki extension by Arnfjörð Bjarmason and Aaron Schulz.
 *
 * REQUIRES THE FOLLOWING EXTENSIONS TO BE ENABLED:
 * StaffLog, TaskManager, Phalanx, SpecialPhalanx
 *
 * THIS EXTENSION IS DESIGNED TO BE ENABLED ONLY ON CLUSTER 1! BEWARE! ANY OTHER USE REQUIRES SOME CHANGES!
 *
 * @ingroup Wikia
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>, Władysław Bodzek <wladek@wikia-inc.com>
 * @copyright Copyright © 2010, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
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
$wgSpecialPages['UserRenameTool'] = 'SpecialRenameUser';
$wgSpecialPageGroups['UserRenameTool'] = 'users';

// internationalization files
$wgExtensionMessagesFiles['UserRenameTool'] = $dir . 'SpecialRenameUser.i18n.php';

// classes
$wgAutoloadClasses['SpecialRenameUser'] = $dir . 'SpecialRenameUser_body.php';
$wgAutoloadClasses['RenameUserHelper'] = $dir . 'RenameUserHelper.class.php';
$wgAutoloadClasses['RenameUserProcess'] = $dir . 'RenameUserProcess.class.php';
$wgAutoloadClasses['RenameUserLogFormatter'] = $dir . 'RenameUserLogFormatter.class.php';
$wgAutoloadClasses['UserRenameTask'] = $dir . 'UserRenameTask.class.php';

// log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders;
$wgLogTypes[] = 'renameuser';
$wgLogNames['renameuser'] = 'userrenametool-logpage';
$wgLogHeaders['renameuser'] = 'userrenametool-logpagetext';

// hooks
$wgHooks['StaffLog::formatRow'][] = 'UserRenameToolStaffLogFormatRow';

function UserRenameToolStaffLogFormatRow( $type, $row, $time, $linker, &$out ) {
	if ($type == "renameuser") {
		$out = "{$time} Rename - {$row->slog_comment}";
		return false;
	}

	return true;
}
