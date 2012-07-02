<?php
/**
 * SpecialLastUserLogin MediaWiki extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.2.1
 * @author Justin G. Cramer
 * @author Danila Ulyanov
 * @author Thomas Klein
 * @link http://www.mediawiki.org/wiki/Extension:SpecialLastUserLoginEx Documentation
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or 
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}
 
// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'LastUserLogin',
	'version' => '1.2.1',
	'author' => array( 'Justin G. Cramer', 'Danila Ulyanov', 'Thomas Klein' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:SpecialLastUserLoginEx',
	'descriptionmsg' => 'lastuserlogin-desc',
);
 
// New user right
$wgAvailableRights[] = 'lastlogin';
$wgGroupPermissions['sysop']['lastlogin'] = true;

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['LastUserLogin'] = $dir . 'LastUserLogin_body.php';
$wgExtensionMessagesFiles['LastUserLogin'] = $dir . 'LastUserLogin.i18n.php';
$wgExtensionMessagesFiles['LastUserLoginAlias'] = $dir . 'LastUserLogin.alias.php';
$wgSpecialPages['LastUserLogin'] = 'LastUserLogin';
$wgSpecialPageGroups['LastUserLogin'] = 'users';

// Function that updates the database when a user logs in
$wgExtensionFunctions[] = 'wfUpdateUserTouched';
 
function wfUpdateUserTouched() {
	global $wgOut, $wgCookiePrefix;
 
	if ( isset( $_COOKIE ) && isset( $_COOKIE["{$wgCookiePrefix}UserID"] ) ) {
		$dbw = wfGetDB( DB_MASTER );
		$query = "UPDATE " . $dbw->tableName( 'user' ) . " SET user_touched = '" . $dbw->timestamp() . "' WHERE user_id = " . intval( $_COOKIE["{$wgCookiePrefix}UserID"] );
		$dbw->query( $query );
	}
}

