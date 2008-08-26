<?php

/**
 * NoMoveUserpages - prevent the moving of user pages unless
 *   a user has been given the 'move-userpages' right.
 *
 * Copyright (C) 2008 Chad Horohoe <innocentkiller@gmail.com>
 * http://www.mediawiki.org/wiki/Extension:PasswordStrength
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

// Hook
$wgHooks['getUserPermissionsErrors'][] = 'wfNoMoveUserpages';

// Language for the error
$wgExtensionMessagesFiles['NoMoveUserpages'] = dirname(__FILE__) . '/' . 'NoMoveUserpages.i18n.php';

// Block it for everyone
$wgGroupPermissions['*']['move-userpages'] = false;
$wgGroupPermissions['sysop']['move-userpages'] = false;

// Tooting my own horn
$wgExtensionCredits['other'][] = array(
        'name'				=> 'NoMoveUserpages',
        'description'		=> 'Blocks users from moving userpages unless they have the "move-userpages" right',
		'descriptionmsg'	=> 'nomoveuserpages-desc',
        'author'			=> '[mailto:innocentkiller@gmail.com Chad Horohoe]',
);

function wfNoMoveUserpages( $title, $user, $act, $result ) {
	
	if ( $act == 'move' && $title->getNamespace() == NS_USER && !$title->isSubpage()
			&& !$user->isAllowed('move-userpages') ) {
		wfLoadExtensionMessages('NoMoveUserpages');
		$result[] = wfMsg('nomoveuserpages-error');
		return false;
	}
	else {
		return true;
	}
}
