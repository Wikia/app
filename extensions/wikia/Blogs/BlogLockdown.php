<?php

/**
 * BlogLockdown extension - implements restrictions on blog namespaces
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author
 * @licence GNU General Public Licence 2.0 or later
 *
 *
 * Based on Lockdown extension from Daniel Kinzler, brightbyte.de
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgHooks['userCan'][] = 'BlogLockdown::userCan';

class BlogLockdown {

	public static function userCan( $title, $user, $action, &$result ) {

		$namespace = $title->getNamespace();

		/**
		 * here we only handle Blog articles, everyone can read it
		 */
		if( $namespace != NS_BLOG_ARTICLE || $action == "read" ) {
			$result = true;
			return true;
		}
		/**
		 * for other actions we demand that user has to be logged in
		 */
		Wikia::log( __METHOD__, "action", $action );
		Wikia::log( __METHOD__, "result", $result );
		if( $user->isAnon( ) ) {
			Wikia::log( __METHOD__, "user", "anonymous" );
			return true;
		}

		if( $title->isSubpage() ) {
			/**
			 * blog article page, split title for "/" and get second part
			 */
			list( $page, $post ) = explode( "/", $title->getText( ), 2 );
		}
		else {
			$page = $title->getText( );
		}
		$username = $user->getName();

		Wikia::log( __METHOD__, "user", $username );
		Wikia::log( __METHOD__, "title", $page );
		$result = ( $username == $page ) ? null : false;
		$return = ( $username == $page );

		return $return;
	}
}
