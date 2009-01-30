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

		$owner = BlogArticle::getOwner( $title );
		$username = $user->getName();
		$isOwner =  (bool)( $username == $owner );
		$result = array();
		$return = false;

		switch( $action ) {
			case "move":
				$result = array();
				$return = false;
				break;

			case "read":
				$result = true;
				$return = true;
				break;

			case "create":
				/**
				 * commenting
				 */
				if( $namespace == NS_BLOG_ARTICLE_TALK ) {
					$result = true;
					$return = true;
				}
				if( $namespace == NS_BLOG_ARTICLE ) {
					$return = ( $username == $owner );
					$result = ( $username == $owner );
				}
				break;

			/**
			 * edit permissions -- owner of blog and one who has
			 *	 "blog-articles-edit" permission
			 */
			case "edit":
				if( $namespace == NS_BLOG_ARTICLE && ( $user->isAllowed( "blog-articles-edit" ) || $isOwner ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "delete":
				if( $namespace == NS_BLOG_ARTICLE_TALK && $user->isAllowed( "blog-comments-delete" ) ) {
					$result = true;
					$return = true;
				}
				if( $user->isAllowed( 'delete' ) ) {
					$result = true;
					$return = true;
				}
				break;

			default:
				/**
				 * for other actions we demand that user has to be logged in
				 */
				if( $user->isAnon( ) ) {
					$result = array( "{$action} is forbidden for anon user" );
					$return = false;
				}
				else {
					if( $username != $owner ) $result = array();
					$return = ( $username == $owner );
				}
		}
		Wikia::log( __METHOD__, $action, "result: {$result}; return: {$return}");
		return $return;
	}
}
