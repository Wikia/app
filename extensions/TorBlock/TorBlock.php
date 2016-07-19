<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Prevents Tor exit nodes from editing a wiki.
 * Requires
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:TorBlock Documentation
 *
 *
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$dir = dirname(__FILE__);
$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path'           => __FILE__,
	'name'           => 'TorBlock',
	'author'         => 'Andrew Garrett',
	'descriptionmsg' => 'torblock-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:TorBlock',
);

$wgExtensionMessagesFiles['TorBlock'] =  "$dir/TorBlock.i18n.php";
$wgAutoloadClasses[ 'TorBlock' ] = "$dir/TorBlock.class.php";

$wgHooks['getUserPermissionsErrorsExpensive'][] = 'TorBlock::onGetUserPermissionsErrorsExpensive';
$wgHooks['AbortAutoblock'][] = 'TorBlock::onAbortAutoblock';
$wgHooks['GetAutoPromoteGroups'][] = 'TorBlock::onGetAutoPromoteGroups';
$wgHooks['GetBlockedStatus'][] = 'TorBlock::onGetBlockedStatus';
$wgHooks['AutopromoteCondition'][] = 'TorBlock::onAutopromoteCondition';
$wgHooks['RecentChange_save'][] = 'TorBlock::onRecentChangeSave';
$wgHooks['ListDefinedTags'][] = 'TorBlock::onListDefinedTags';
$wgHooks['AbuseFilter-filterAction'][] = 'TorBlock::onAbuseFilterFilterAction';
$wgHooks['AbuseFilter-builder'][] = 'TorBlock::onAbuseFilterBuilder';
$wgHooks['EmailUserPermissionsErrors'][] = 'TorBlock::onEmailUserPermissionsErrors';
$wgHooks['OtherBlockLogLink'][] = 'TorBlock::getTorBlockStatus';

// Define new autopromote condition
define('APCOND_TOR', 'tor'); // Numbers won't work, we'll get collisions

/**
 * Permission keys that bypass Tor blocks.
 * Array of permission keys.
 */
$wgTorBypassPermissions = array( 'torunblocked', /*'autoconfirmed', 'proxyunbannable'*/ );

/**
 * Whether to load Tor blocks if they aren't stored in memcached.
 * Set to false on high-load sites, and use a cron job with the included
 * maintenance script
 */
$wgTorLoadNodes = true;

/**
 * Actions tor users are allowed to do.
 * E.g. to allow account creation, add createaccount.
 */
$wgTorAllowedActions = array('read');

/**
 * Autoconfirm limits for tor users.
 * Both regular limits, AND Tor limits must be passed.
 */
$wgTorAutoConfirmAge = 0;
$wgTorAutoConfirmCount = 0;

/**
 * IPs to check for tor exits to.
 * (i.e. all IPs which can be used to access the site.
 */
$wgTorIPs = array( '208.80.152.2' );

/**
 * Disable existing blocks of Tor nodes
 */
$wgTorDisableAdminBlocks = true;

/** Mark tor edits as such */
$wgTorTagChanges = true;
