<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Provides a way to block an IP Address over multiple wikis sharing a database.
 * Requires
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:GlobalBlocking Documentation
 *
 *
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$dir = dirname(__FILE__);
$wgExtensionCredits['other'][] = array(
	'name'           => 'GlobalBlocking',
	'author'         => 'Andrew Garrett',
	'svn-date' => '$LastChangedDate: 2009-03-04 02:33:52 +0100 (śro, 04 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48005 $',
	'description'    => 'Allows IP addresses to be blocked across multiple wikis',
	'descriptionmsg' => 'globalblocking-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GlobalBlocking',
);

$wgExtensionMessagesFiles['GlobalBlocking'] =  "$dir/GlobalBlocking.i18n.php";
$wgExtensionAliasesFiles['GlobalBlocking'] = "$dir/GlobalBlocking.alias.php";
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'GlobalBlocking::getUserPermissionsErrors';
$wgHooks['UserIsBlockedGlobally'][] = 'GlobalBlocking::isBlockedGlobally';

$wgAutoloadClasses['SpecialGlobalBlock'] = "$dir/SpecialGlobalBlock.php";
$wgSpecialPages['GlobalBlock'] = 'SpecialGlobalBlock';
$wgAutoloadClasses['SpecialGlobalBlockList'] = "$dir/SpecialGlobalBlockList.php";
$wgSpecialPages['GlobalBlockList'] = 'SpecialGlobalBlockList';
$wgAutoloadClasses['SpecialGlobalBlockStatus'] = "$dir/SpecialGlobalBlockStatus.php";
$wgSpecialPages['GlobalBlockStatus'] = 'SpecialGlobalBlockStatus';
$wgAutoloadClasses['SpecialRemoveGlobalBlock'] = "$dir/SpecialRemoveGlobalBlock.php";
$wgSpecialPages['RemoveGlobalBlock'] = 'SpecialRemoveGlobalBlock';
$wgAutoloadClasses['ApiQueryGlobalBlocks'] = "$dir/ApiQueryGlobalBlocks.php";
$wgAPIListModules['globalblocks'] = 'ApiQueryGlobalBlocks';

$wgAutoloadClasses['GlobalBlocking'] = "$dir/GlobalBlocking.class.php";

$wgSpecialPageGroups['GlobalBlock'] = 'users';
$wgSpecialPageGroups['GlobalBlockList'] = 'users';
$wgSpecialPageGroups['GlobalBlockStatus'] = 'users';
$wgSpecialPageGroups['RemoveGlobalBlock'] = 'users';

## Add global block log
$wgLogTypes[] = 'gblblock';
$wgLogNames['gblblock'] = 'globalblocking-logpage';
$wgLogHeaders['gblblock'] = 'globalblocking-logpagetext';
$wgLogActions['gblblock/gblock'] = 'globalblocking-block-logentry';
$wgLogActions['gblblock/gblock2'] = 'globalblocking-block2-logentry';
$wgLogActions['gblblock/gunblock'] = 'globalblocking-unblock-logentry';
$wgLogActions['gblblock/whitelist'] = 'globalblocking-whitelist-logentry';
$wgLogActions['gblblock/dwhitelist'] = 'globalblocking-dewhitelist-logentry'; // Stupid logging table doesn't like >16 chars
$wgLogActions['gblblock/modify'] = 'globalblocking-modify-logentry';

## Permissions
$wgGroupPermissions['steward']['globalblock'] = true;
$wgGroupPermissions['steward']['globalunblock'] = true;
$wgGroupPermissions['sysop']['globalblock-whitelist'] = true;
$wgAvailableRights[] = 'globalblock';
$wgAvailableRights[] = 'globalunblock';
$wgAvailableRights[] = 'globalblock-whitelist';

## CONFIGURATION
/**
 * Database name you keep global blocking data in.
 *
 * If this is not on the primary database connection, don't forget
 * to also set up $wgDBservers to have an entry with a groupLoads
 * setting for the 'GlobalBlocking' group.
 */
$wgGlobalBlockingDatabase = 'globalblocking';

/**
 * Whether to respect global blocks on this wiki. This is used so that
 * global blocks can be set one one wiki, but not actually applied there
 * (i.e. so people can contest them on that wiki.
 */
$wgApplyGlobalBlocks = true;

