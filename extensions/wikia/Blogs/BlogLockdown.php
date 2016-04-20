<?php

/**
 * BlogLockdown extension - implements restrictions on blog namespaces
 *
 * @file
 * @ingroup Extensions
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * @copyright Copyright © 2008 Krzysztof Krzyżaniak, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 *
 * Based on Lockdown extension from Daniel Kinzler, brightbyte.de
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgHooks['userCan'][] = 'BlogLockdown::userCan';

class BlogLockdown {

	/**
	 * @static
	 * @param Title $title
	 * @param User $user
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	public static function userCan( $title, $user, $action, &$result ) {

		$namespace = $title->getNamespace();
		/**
		 * here we only handle Blog articles, everyone can read it
		 */
		if ( $namespace != NS_BLOG_ARTICLE && $namespace != NS_BLOG_ARTICLE_TALK ) {
			$result = null;
			return true;
		}

		/**
		 * check if default blog post was passed (BugId:8331)
		 */
		if ( $namespace == NS_BLOG_ARTICLE && $title->mTextform == '' ) {
			return true;
		}

		$username = $user->getName();
		if ( $namespace == NS_BLOG_ARTICLE_TALK && class_exists( 'ArticleComment' ) ) {
			$oComment = ArticleComment::newFromTitle( $title );
			$canEdit = $oComment->canEdit();
			$isOwner = (bool) ( $canEdit && !in_array( $action, array( 'watch', 'protect' ) ) );
			$isArticle = false; // if this is TALK it is not article
		}
		else {
			$owner = BlogArticle::getOwner( $title );
			$isOwner = (bool)( $username == $owner );
			$isArticle = (bool)( $namespace == NS_BLOG_ARTICLE );
		}

		/**
		 * returned values
		 */
		$result = array();
		$return = false;

		switch( $action ) {
			case "move":
			case "move-target":
				if ( $isArticle && ( $user->isAllowed( "blog-articles-move" ) || $isOwner ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "read":
				$result = true;
				$return = true;
				break;

			/**
			 * creating permissions:
			 * 	-- article can be created only by blog owner
			 *	-- comment can be created by everyone
			 */
			case "create":
				if ( $isArticle ) {
					$return = ( $username == $owner );
					$result = ( $username == $owner );
				}
				else {
					$result = true;
					$return = true;
				}
				break;

			/**
			 * edit permissions -- owner of blog and one who has
			 *	 "blog-articles-edit" permission
			 */
			case "edit":
				if ( $isArticle && ( $user->isAllowed( "blog-articles-edit" ) || $isOwner ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "delete":
			case "undelete":
				if ( !$isArticle && $user->isAllowed( "blog-comments-delete" ) ) {
					// this is a blog page and user have right to delete/undelete a comment let's move on
					$result = true;
				}
				if ( $user->isAllowed( $action ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "protect":
				if ( $isArticle && $user->isAllowed( "blog-articles-protect" ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "autopatrol":
			case "patrol":
				$result = true;
				$return = true;
				break;

			default:
				/**
				 * for other actions we demand that user has to be logged in
				 */
				if ( $user->isAnon( ) ) {
					$result = array( "{$action} is forbidden for anon user" );
					$return = false;
				}
				else {
					if ( isset( $owner ) && ( $username != $owner ) ) {
						$result = array();
					}
					$return = ( isset( $owner ) && ( $username == $owner ) );
				}
		}

		return $return;
	}

	/**
	 * Checks permission before delete action on blog articles
	 *
	 * @param Article $article
	 * @param Title $title
	 * @param User $user
	 * @param array $permission_errors
	 *
	 * @return boolean because it's a hook
	 */
	public static function onBeforeDeletePermissionErrors( &$article, &$title, &$user, &$permission_errors ) {
		// Only users with delete permission can delete a blog article

		$accessErrorKey = 'badaccess-group0';
		if ( $title->getNamespace() == NS_BLOG_ARTICLE && !$user->isAllowed( 'delete' ) ) {
			$errorExists = false;
			foreach ( $permission_errors as $errors ) {
				if ( in_array( $accessErrorKey, $errors ) ) {
					$errorExists = true;
					break;
				}
			}

			if ( !$errorExists ) {
				$permission_errors[] = [ $accessErrorKey ];
			}
		}

		return true;
	}
}
