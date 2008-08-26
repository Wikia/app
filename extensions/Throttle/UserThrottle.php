<?php
/**
 * Copyright (C) 2005 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Extensions
 */

/**
 * Requires real memcached with proper expiration semantics
 */

$wgExtensionCredits['other'][] = array(
	'version'     => '0.2',
	'name' => 'Throttle',
	'author' => 'Brion Vibber',
	'description' => 'Throttle user creation',
	'descriptionmsg' => 'acct_creation_global_soft_throttle_hit-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Throttle',
);

$wgExtensionFunctions[] = 'throttleSetup';
$wgHooks['AbortNewAccount'][] = 'throttleGlobalHit';
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['AbortNewAccount'] = $dir . 'UserThrottle.i18n.php';

$wgGlobalAccountCreationThrottle = array(
	'min_interval' => 5,   // Hard minimum time between creations
	'soft_time'    => 300, // Timeout for rolling count
	'soft_limit'   => 10,  // 10 registrations in five minutes
);

function throttleSetup() {
	wfLoadExtensionMessages( 'AbortNewAccount' );
}

/**
 * Hook function
 * @param User $user
 * @return bool false aborts registration, true allows
 * @static
 */
function throttleGlobalHit( $user ) {
	global $wgMemc, $wgDBname, $wgGlobalAccountCreationThrottle;
	extract( $wgGlobalAccountCreationThrottle );

	if( $min_interval > 0 ) {
		$key = "$wgDBname:acctcreate:global:hard";
		$value = $wgMemc->incr( $key );
		if( !$value ) {
			$wgMemc->set( $key, 1, $min_interval );
		} else {
			// Key should have expired, or we're too close
			return throttleHardAbort( $min_interval );
		}
		throttleDebug( "hard limit ok (min_interval $min_interval)" );
	}

	if( $soft_limit > 0 ) {
		$key = "$wgDBname:acctcreate:global:soft";
		$value = $wgMemc->incr( $key );
		if( !$value ) {
			$wgMemc->set( $key, 1, $soft_time );
		} elseif( $value > $soft_limit ) {
			// All registrations block until the limit rolls out
			return throttleSoftAbort( $soft_time, $soft_limit );
		}
		throttleDebug( "soft passed! ($value of soft_limit $soft_limit in $soft_time)" );
	}

	// Go ahead...
	return true;
}

function throttleSoftAbort( $interval, $limit ) {
	global $wgOut;
	throttleDebug( "softAbort: hit soft_limit $limit in soft_time $interval", true );
	$wgOut->addWikiText( wfMsg( 'acct_creation_global_soft_throttle_hit', $interval, $limit ) );
	return false;
}

function throttleHardAbort( $interval ) {
	global $wgOut;
	throttleDebug( "hardAbort: hit min_interval $interval", true );
	$wgOut->addWikiText( wfMsg( 'acct_creation_global_hard_throttle_hit', $interval ) );
	return false;
}

function throttleDebug( $text, $full=false ) {
	$info = '[IP: ' . wfGetIP() . ']';
	if( function_exists( 'getallheaders' ) ) {
		$info .= '[headers: ' . implode( ' | ', array_map( 'urlencode', getallheaders() ) ) . ']';
	}
	wfDebugLog( 'UserThrottle', "UserThrottle: $text $info" );
}
