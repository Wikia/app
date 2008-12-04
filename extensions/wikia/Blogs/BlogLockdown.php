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
		if( $namespace != NS_BLOG_ARTICLE && $namespace != NS_BLOG_ARTICLE_TALK ) {
			Wikia::log( __METHOD__, "namespace", "not valid namespace: {$namespace}"  );
			$result = true;
			return true;
		}

		if( $action == "read" ) {
			Wikia::log( __METHOD__, "action", "action: {$action}"  );
			$result = true;
			return true;
		}

		if( $action == "move" ) {
			Wikia::log( __METHOD__, "move", "action: {$action}"  );
			$result = array();
			return false;
		}

		/**
		 * staff & sysops can do anything
		 */
		if (in_array('staff',($user->getGroups())) || in_array('sysop',($user->getGroups()))) {
			Wikia::log( __METHOD__, "user", "staff or sysop: " . implode( ",", $user->getGroups() ) );
			return true;
		}

		/**
		 * for other actions we demand that user has to be logged in
		 */
		if( $user->isAnon( ) ) {
			Wikia::log( __METHOD__, "user", "anonymous" );
			return false;
		}

		$owner = $title->getBaseText();
		$username = $user->getName();

		Wikia::log( __METHOD__, "user", "user: {$username}, owner: {$owne}" );

		if( $username != $owner ) $result = array();
		$return = ( $username == $owner );

		Wikia::log( __METHOD__, "result", "action: {$action}, result: {$result}, return: {$return}" );

		return $return;
	}
}
