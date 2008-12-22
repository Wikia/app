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

		if( $namespace == NS_BLOG_ARTICLE_TALK && $action == "create" ) {
			Wikia::log( __METHOD__, "action", "action: {$action} allowed for comments."  );
			$result = true;
			return true;
		}

		if( $namespace == NS_BLOG_ARTICLE_TALK && $action == "delete" && $user->isAllowed("blog-comments-delete")) {
			Wikia::log( __METHOD__, "action", "action: {$action} allowed for certain groups."  );
			$result = true;
			return true;
		}

		/**
		 * staff & sysops can do anything
		 */
		if( in_array('staff',($user->getGroups())) || in_array('sysop',($user->getGroups()))) {
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

		$owner = BlogArticle::getOwner( $title );
		$username = $user->getName();
		Wikia::log( __METHOD__, "user", "user: {$username}, owner: {$owner}" );

		/**
		 * only creator of comment cant edit comment
		 */
		if( $namespace == NS_BLOG_ARTICLE_TALK && $action == "edit" ) {
			/**
			 * get article creator
			 */
			$revId = $title->getLatestRevID( GAID_FOR_UPDATE );
			Wikia::log( __METHOD__, "edit", "revision id: {$revId}" );
			return false;
		}

		if( $username != $owner ) $result = array();
		$return = ( $username == $owner );

		Wikia::log( __METHOD__, "result", "action: {$action}, result: {$result}, return: {$return}" );

		return $return;
	}
}
