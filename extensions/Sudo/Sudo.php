<?php
/**
 * Sudo
 *
 * @file
 * @ingroup Extensions
 * @version 0.2
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:Sudo Documentation
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Sudo',
	'version' => '0.2.1',
	'author' => '[http://www.mediawiki.org/wiki/User:Dantman Daniel Friesen] [mailto:Daniel%20Friesen%20%3Cmediawiki@danielfriesen.name%3E <mediawiki@danielfriesen.name>]',
	'descriptionmsg' => 'sudo-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Sudo',
);

// Set up i18n and the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Sudo'] = $dir . 'Sudo.i18n.php';
$wgExtensionMessagesFiles['SudoAlias'] = $dir . 'Sudo.alias.php';
$wgAutoloadClasses['SpecialSudo'] = $dir . 'SpecialSudo.php';
$wgSpecialPages['Sudo']           = 'SpecialSudo';
$wgSpecialPageGroups['Sudo']      = 'users';

// New user right, required to use Special:Sudo
$wgAvailableRights[] = 'sudo';

// New log type, all sudo actions are logged to this log (Special:Log/sudo)
$wgLogTypes[] = 'sudo';
$wgLogNames['sudo'] = 'sudo-logpagename';
$wgLogHeaders['sudo'] = 'sudo-logpagetext';
$wgLogActions['sudo/sudo'] = 'sudo-logentry';

// Hooked functions
$wgHooks['UserLogoutComplete'][] = 'wfSudoLogout';
$wgHooks['PersonalUrls'][] = 'wfSudoPersonalUrls';

function wfSudoLogout( &$user, &$inject_html ) {
	// Unset wsSudoId when we logout.
	// We don't want to be in a sudo login while logged out.
	unset( $_SESSION['wsSudoId'] );
	return true;
}

function wfSudoPersonalUrls( &$personal_urls, &$wgTitle ) {
	// Replace logout link with a unsudo link while in a sudo login.
	if( isset( $_SESSION['wsSudoId'] ) && $_SESSION['wsSudoId'] > 0 ) {
		$personal_urls['logout'] = array(
			'text' => wfMsg( 'sudo-personal-unsudo' ),
			'href' => Skin::makeSpecialUrl( 'Sudo', 'mode=unsudo' ),
			'active' => false
		);
	}
	return true;
}
