<?php
if ( ! defined( 'MEDIAWIKI' ) ) {
   echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
   die( - 1 );
}
/**
 * Extension: UserPageEditProtection.php
 * Created: 6 December 2007
 * Author: Lisa Ridley, Eric Gingell
 * Version: 2.0
 * Copyright (C) 2007 Lisa Ridley
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
 * You can find a copy of the GNU General Public License at http://www.gnu.org/copyleft/gpl.html
 * A paper copy can be obtained by writing to:  Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * User Page Edit Protection
 *
 * Provides User Page Edit Protection to limit user page edits to User and to sysops.
 *
 *
 * Usage:
 * Save this file in your extensions folder of your MediaWiki installation.
 * Add the following lines to LocalSettings.php:
 *    require_once('extensions/UserPageEditProtection.php');
 *    //turn on user page protection
 *    $wgOnlyUserEditUserPage = true;
 **/
  
/* register extension */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'UserPageEditProtection',
	'author' => array( 'Lisa Ridley', 'Eric Gingell' ),
	'version' => '2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UserPageEditProtection',
	'descriptionmsg' => 'userpageeditprotection-desc',
);

# Internationalisation file
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UserPageEditProtection'] = $dir . 'UserPageEditProtection.i18n.php';

# Define the new user right
$wgAvailableRights[] = 'editalluserpages';
$wgGroupPermissions['sysop']['editalluserpages'] = true;

/* use the userCan hook to check user page edit permissions */
$wgHooks['userCan'][] = 'fnUserPageEditProtection';

function fnUserPageEditProtection( $title, $user, $action, &$result ) {
	global $wgOnlyUserEditUserPage;
	$lTitle = explode( '/', $title->getText() );
	if ( !( $action == 'edit' || $action == 'move' ) ) {
		$result = null;
	return true;
        }
	if ( $title->mNamespace !== NS_USER ) {
		$result = null;
		return true;
	}
	if ( $wgOnlyUserEditUserPage ) {
		if ( $user->isAllowed( 'editalluserpages' ) || ( $user->getname() == $lTitle[0] ) ) {
			$result = null;
			return true;
		} else {
			$result = false;
			return false;
		}
	}
	$result = null;
	return true;
}

