<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, version 2
of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page extension to manage contractor access white lists
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Paul Grinberg <gri6507@yahoo.com>
 * @author Mike Sullivan <ms-mediawiki@umich.edu>
 * @copyright Copyright © 2008, Paul Grinberg, Mike Sullivan
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'WhiteListEdit',
	'version'        => 'v0.11.2',
	'author'         => array('Paul Grinberg', 'Mike Sullivan'),
	'email'          => 'gri6507 at yahoo dot com, ms-mediawiki AT umich DOT edu',
	'description'    => 'Edit the access permissions of restricted users',
	'descriptionmsg' => 'whitelist-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:WhiteList',
);

# these are the groups and the rights used within this extension
if ( !isset( $wgWhiteListRestrictedGroup ) )
	$wgWhiteListRestrictedGroup = 'restricted';
if ( !isset( $wgWhiteListManagerGroup ) )
	$wgWhiteListManagerGroup = 'manager';

# Define groups and rights
if ( !isset( $wgGroupPermissions['*']['usewhitelist'] ) )
	$wgGroupPermissions['*']['usewhitelist'] = false;
if ( !isset( $wgGroupPermissions[$wgWhiteListRestrictedGroup]['edit'] ) )
	$wgGroupPermissions[$wgWhiteListRestrictedGroup]['edit'] = true;
if ( !isset( $wgGroupPermissions[$wgWhiteListRestrictedGroup]['restricttowhitelist'] ) )
	$wgGroupPermissions[$wgWhiteListRestrictedGroup]['restricttowhitelist'] = true;
if ( !isset( $wgGroupPermissions['*']['editwhitelist'] ) )
	$wgGroupPermissions['*']['editwhitelist'] = false;
if ( !isset( $wgGroupPermissions[$wgWhiteListManagerGroup]['editwhitelist'] ) )
	$wgGroupPermissions[$wgWhiteListManagerGroup]['editwhitelist'] = true;

$wgAvailableRights[] = 'editwhitelist';
$wgAvailableRights[] = 'restricttowhitelist';

# Define default global overrides
if ( !isset( $wgWhiteListOverride['always']['read'] ) )
	$wgWhiteListOverride['always']['read'] = array(
		"Special:WhiteList",       # needed so that restricted users can see their "my pages" list
		"Special:Preferences",     # needed so that restricted users can set their preferences
		"Special:Userlogout",      # needed so that restricted users can logout
		"Special:Userlogin",       # needed so that restricted users can login
		"MediaWiki:%",             # needed so that restricted users can view properly formatted content
		"Help:%",                  # needed so that restricted users can see help pages
);
if ( !isset( $wgWhiteListOverride['always']['edit'] ) )
	$wgWhiteListOverride['always']['edit'] = array();
if ( !isset( $wgWhiteListOverride['never']['read'] ) )
	$wgWhiteListOverride['never']['read'] = array();
if ( !isset( $wgWhiteListOverride['never']['edit'] ) )
	$wgWhiteListOverride['never']['edit'] = array();

# Define default case insensitivity setting
if ( !isset( $wgWhiteListWildCardInsensitive ) )
	$wgWhiteListWildCardInsensitive = true;

# Define default user page setting
if ( !isset( $wgWhiteListAllowUserPages ) )
	$wgWhiteListAllowUserPages = true;

# If you want the pretty calendar feature, you must install the Extension:Usage_Statistics.
# If you do not want that feature, then set the following variable to false.
# NOTE: you do not actually need the gnuplot extension for the functionality needed by this extension
if ( !isset( $wgWhiteListUsePrettyCalendar ) )
	$wgWhiteListUsePrettyCalendar = true;

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['WhiteListEdit'] = $dir . 'WhiteListEdit.i18n.php';
$wgExtensionMessagesFiles['WhiteList']     = $dir . 'WhiteListEdit.i18n.php';
$wgExtensionAliasesFiles['WhiteList']      = $dir . 'WhiteListEdit.alias.php';
$wgAutoloadClasses['WhiteListEdit']        = $dir . 'WhiteListEdit_body.php';
$wgAutoloadClasses['WhiteList']            = $dir . 'WhiteListEdit_body.php';
$wgAutoloadClasses['WhiteListExec']        = $dir . 'WhiteListAuth.php';
$wgAutoloadClasses['WhiteListHooks']       = $dir . 'WhiteListAuth.php';
$wgSpecialPages['WhiteListEdit']           = 'WhiteListEdit';
$wgSpecialPages['WhiteList']               = 'WhiteList';
$wgSpecialPageGroups['WhiteListEdit'] = 'users';
$wgSpecialPageGroups['WhiteList'] = 'users';

# this is a compatability workaround for MW versions 1.9.3 and earlier.
function WL_doCheckWhiteList(&$title, &$uwUser, $action, &$result) {
	return WhiteListExec::CheckWhiteList($title, $uwUser, $action, $result);
}

function WL_doAddRestrictedPagesTab(&$personal_urls, $wgTitle) {
	return WhiteListHooks::AddRestrictedPagesTab($personal_urls, $wgTitle);
}

// TODO - this is missing from Siebrand's changes
function WL_doCheckSchema() {
	return WhiteListHooks::CheckSchema();
}

$wgHooks['PersonalUrls'][] = 'WL_doAddRestrictedPagesTab';
$wgHooks['userCan'][] = 'WL_doCheckWhiteList';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'WL_doCheckSchema';
