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

// check for dependencies
if ( !defined( 'MEDIAWIKI' ) ) die( "This is MediaWiki extension and cannot be used standalone." );

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
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserRenameTool',
	'description'    => 'Renames a user (need \'\'renameuser\'\' right)',
	'descriptionmsg' => 'userrenametool-desc',
);

$dir = dirname( __FILE__ ) . '/';

// special pages
$wgSpecialPages['UserRenameTool'] = 'SpecialRenameuser';
$wgSpecialPageGroups['UserRenameTool'] = 'users';


// internationalization files
$wgExtensionMessagesFiles['UserRenameTool'] = $dir . 'SpecialRenameuser.i18n.php';
$wgExtensionMessagesFiles['UserRenameToolAliases'] = $dir . 'SpecialRenameuser.alias.php';

// classes
$wgAutoloadClasses['SpecialRenameuser'] = dirname( __FILE__ ) . '/SpecialRenameuser_body.php';
$wgAutoloadClasses['RenameUserProcess'] = dirname( __FILE__ ) . '/RenameUserProcess.class.php';
$wgAutoloadClasses['RenameUserLogFormatter'] = dirname( __FILE__ ) . '/RenameUserLogFormatter.class.php';

// Resource Loader modules
$userRenameResourceTemplate = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/UserRenameTool/modules'
);
$wgResourceModules['ext.renameuser.modal'] = $userRenameResourceTemplate + array(
	'scripts' => 'ext.renameuser.modal.js',
	'dependencies' => array(
		'mediawiki.util'
	),
	'messages' => array(
		'renameuser',
		'userrenametool-new',
		'userrenametool-confirm',
		'userrenametool-confirm-intro',
		'userrenametool-confirm-yes',
		'userrenametool-confirm-no'
	)
);

// constants
define( 'USERRENAME_ROWS_PER_LOOP', 500 );
define( 'USERRENAME_LOOP_PAUSE', 5 );
define( 'COMMUNITY_CENTRAL_CITY_ID', 177 );// city_id for community.wikia.com

// log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                          = 'renameuser';
$wgLogNames['renameuser']              = 'userrenametool-logpage';
$wgLogHeaders['renameuser']            = 'userrenametool-logpagetext';

// hooks
$wgHooks['StaffLog::formatRow'][] = 'UserRenameToolStaffLogFormatRow';

function UserRenameToolStaffLogFormatRow( $type, $row, $time, &$out ) {
	if ( $type == "renameuser" ) {
		$out = "{$time} Rename - {$row->slog_comment}";
		return false;
	}
	return true;
}
