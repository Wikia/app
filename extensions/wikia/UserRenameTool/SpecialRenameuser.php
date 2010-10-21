<?php
/**
 * A Special Page extension to rename users, runnable by staff members.
 * Based on the RenameUser MediaWiki extension by Arnfjörð Bjarmason and Aaron Schulz.
 * 
 * @ingroup Wikia
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>, Władysław Bodzek <wladek@wikia-inc.com>
 * @copyright Copyright © 2010, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

//check for dependencies
if(!defined('MEDIAWIKI')) die("This is MediaWiki extension and cannot be used standalone.");

/**
 * REQUIRES THE FOLLOWING EXTENSIONS TO BE ENABLED:
 * StaffLog, TaskManager, Phalanx, SpecialPhalanx
 *
 * THIS EXTENSION IS DESIGNED TO BE ENABLED ONLY ON CLUSTER 1! BEWARE! ANY OTHER USE REQUIRES SOME CHANGES!
 **/

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UserRenameTool',
	'author'         => array( 'Federico "Lox" Lucignano', 'Władysław Bodzek' ),
	'url'            => '',
	'description'    => 'Renames a user (need \'\'renameuser\'\' right)',
	'descriptionmsg' => 'userrenametool-desc',
);

$dir = dirname(__FILE__) . '/';

//special pages
$wgSpecialPages['UserRenameTool'] = 'SpecialRenameuser';
$wgSpecialPageGroups['UserRenameTool'] = 'users';

//rights
$wgAvailableRights[] = 'renameuser';
$wgGroupPermissions['*']['renameuser'] = false;
$wgGroupPermissions['staff']['renameuser'] = true;


//internationalization files
$wgExtensionMessagesFiles['UserRenameTool'] = $dir . 'SpecialRenameuser.i18n.php';
$wgExtensionAliasesFiles['UserRenameTool'] = $dir . 'SpecialRenameuser.alias.php';

//classes
$wgAutoloadClasses['SpecialRenameuser'] = dirname( __FILE__ ) . '/SpecialRenameuser_body.php';
$wgAutoloadClasses['RenameUserHelper'] = dirname( __FILE__ ) . '/RenameUserHelper.class.php';
$wgAutoloadClasses['RenameUserProcess'] = dirname( __FILE__ ) . '/RenameUserProcess.class.php';
$wgAutoloadClasses['RenameUserLogFormatter'] = dirname( __FILE__ ) . '/RenameUserLogFormatter.class.php';

//constants
//define('ENV_DEVBOX', true);//TODO: used for some debug switches, comment out as soon as the code hits production!
define('USERRENAME_ROWS_PER_LOOP', 500);
define('USERRENAME_LOOP_PAUSE', 5);
define('COMMUNITY_CENTRAL_CITY_ID', 177);//city_id for community.wikia.com

//log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                          = 'renameuser';
$wgLogNames['renameuser']              = 'userrenametool-logpage';
$wgLogHeaders['renameuser']            = 'userrenametool-logpagetext';

//task types
if(function_exists( "extAddBatchTask" ) ) {
	extAddBatchTask(dirname(__FILE__)."/UserRenameLocalTask.php", "renameuser_local", "UserRenameLocalTask");
	extAddBatchTask(dirname(__FILE__)."/UserRenameGlobalTask.php", "renameuser_global", "UserRenameGlobalTask");
}
else
	die('The User Rename Tool extension requires the Task Manager extension to be enabled.');

//hooks
$wgHooks['StaffLog::formatRow'][] = 'UserRenameToolStaffLogFormatRow';

function UserRenameToolStaffLogFormatRow( $type, $row, $time, $linker, &$out ) {
	if ($type == "renameuser") {
		$out = "{$time} Rename - {$row->slog_comment}";
		return false;
	}
	return true;
}