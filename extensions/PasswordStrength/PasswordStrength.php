<?php

/**
 * PasswordStrength
 *   Perform additional security checks on a password via regular
 *   expressions
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

$wgExtensionCredits['other'][] = array(
	'name'           	=> 'PasswordStrength',
	'author'         	=> 'Chad Horohoe',
	'url'				=> 'http://www.mediawiki.org/wiki/Extension:PasswordStrength',
	'description'		=> 'Perform additional security checks on passwords.',
	'version'			=> '0.3',
);

$wgPasswordStrengthCheck = array ();
$wgPasswordStrengthCheck[] = '/^\d+$/';

$wgHooks['isValidPassword'][] = 'psCheckRegex';

function psCheckRegex( $password, &$result, $userObj ) {
	global $wgPasswordStrengthCheck;
	if ( is_array( $wgPasswordStrengthCheck ) ) {
		foreach ( $wgPasswordStrengthCheck as $regex ) {
			if ( preg_match( $regex, $password ) ) {
				$result = false;
				return false;
			}
		}
	}
	$result = true;
	return true;
}
