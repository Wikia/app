<?php

/**
 * Extension:RemoveRedlinks - Hide all redlinks and turn them into
 * their static text.
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Chad Horohoe <innocentkiller@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
 
$wgExtensionCredits['other'][] = array(
	'path'			=> __FILE__,
	'name'			=> 'RemoveRedlinks',
	'url'			=> 'http://mediawiki.org/wiki/Extension:RemoveRedlinks',
	'description'	=> 'Removes all redlinks from page output',
	'author'		=> '[mailto:innocentkiller@gmail.com Chad Horohoe]',
);

// Restrict link removal to anons only
$wgRRAnonOnly = false;

// Hook Registering
$wgHooks['LinkBegin'][] = 'efRemoveRedlinks';

// And the function
function efRemoveRedlinks( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
	global $wgRRAnonOnly, $wgUser;
	
	// return possibly if we're not an anon
	if( $wgRRAnonOnly && $wgUser->isLoggedIn() ) {
		return true;
	}
	// return immediately if we know it's real
	if ( in_array( 'known', $options ) ) {
		return true; 
	}
	// or if we know it's broken
	if ( in_array( 'broken', $options ) ) {
		$ret = $text;
		return false;
	}
	// hopefully we don't have to do this, but here we'll check for existence.
	// dupes a bit of the logic in Linker::link(), but we have to know here
	if( $target->isKnown() ) {
		return true;
	} else {
		$ret = $text;
		return false;
	}
}
