<?php

/**
 * Extension allows wiki administrators to make a special page unavailable
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionCredits['other'][] = array( 'name' => 'Disable Special Pages', 'author' => 'Rob Church' );
	
	if( version_compare( $wgVersion, '1.7.0' ) ) {
		# Use the new hooks in 1.7+
		$wgHooks['SpecialPage_initList'][] = 'efDspHook';
	} else {
		# Fall back to the older method
		require_once( 'SpecialPage.php' );
		$wgExtensionFunctions[] = 'efDspOldMethod';
	}
	
	/**
	 * Titles of special pages to disable; Special:Userlogin, Special:Userlogout
	 * and Special:Search cannot be disabled via this interface
	 */
	$wgDisabledSpecialPages = array();
	
	function efDspHook( &$list ) {
		global $wgDisabledSpecialPages;
		foreach( $wgDisabledSpecialPages as $page ) {
			$title = efDspMakeTitle( $page );
			if( $title && !efDspWhitelisted( $title ) && isset( $list[ $title->getText() ] ) )
				unset( $list[ $title->getText() ] );
		}
		return true;
	}

	function efDspOldMethod() {
		global $wgDisabledSpecialPages, $wgSpecialPages;
		foreach( $wgDisabledSpecialPages as $page ) {
			$title = efDspMakeTitle( $page );
			if( $title && !efDspWhitelisted( $title ) && isset( $wgSpecialPages[ $title->getText() ] ) )
				SpecialPage::removePage( $title->getText() );
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
	
	function efDspWhitelisted( &$title ) {
		$whitelist = array( 'Search', 'Userlogin', 'Userlogout' );
		return in_array( $title->getText(), $whitelist );
	}
	
} else {
	echo( "This file is an extension to the MediaWiki software, and cannot be used standalone.\n" );
	die( 1 );
}

