<?php

/**
 * Extension allows wiki administrators to make a special page unavailable
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Disable Special Pages',
	'author' => 'Rob Church',
	'description' => 'Allow wiki administrators to make a special page unavailable'
);

$wgHooks['SpecialPage_initList'][] = 'efDspHook';

/**
 * Titles of special pages to disable; Special:Userlogin, Special:Userlogout
 * and Special:Search cannot be disabled via this interface
 */
$wgDisabledSpecialPages = array();

function efDspHook( &$list ) {
	global $wgDisabledSpecialPages;
	foreach( $wgDisabledSpecialPages as $page ) {
		$title = efDspMakeTitle( $page );
		if ( !$title )
			continue;
		$canonicalName = SpecialPage::resolveAlias( $title->getDBkey() );
		if( !efDspWhitelisted( $canonicalName ) && isset( $list[$canonicalName] ) )
			unset( $list[$canonicalName] );
	}
	return true;
}

function efDspMakeTitle( $page ) {
	$title = Title::newFromText( $page );
	if( is_object( $title ) ) {
		return $title->getNamespace() == NS_SPECIAL ? $title : Title::makeTitle( NS_SPECIAL, $title->getText() );
	} else {
		return false;
	}
}

function efDspWhitelisted( $title ) {
	static $whitelist = array( 'Search', 'Userlogin', 'Userlogout' );
	return in_array( $title, $whitelist );
}