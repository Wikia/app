<?php
/**
 *
 * Api needs hooks as well
 * this is great place for them
 *
 * @author: jolek
 */

class ApiHooks {

	/**
	 * Check if given title refers to wiki nav messages
	 */
	private static function isWikiNavMessage(Title $title) {
		return ($title->getNamespace() == NS_MEDIAWIKI) && ($title->getText() == NavigationModel::WIKI_LOCAL_MESSAGE);
	}

	/**
	 * @param string $cv_name
	 * @param integer $city_id
	 * @param $value
	 * @return bool true
	 */
	public static function onWikiFactoryChanged( $cv_name , $city_id, $value ) {
		if ( $cv_name == NavigationModel::WIKIA_GLOBAL_VARIABLE ) {
			NavigationApiController::purgeMethod( 'getData' );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param string $text
	 * @return bool true
	 */
	public static function onMessageCacheReplace( $title, $text ) {
		if ( self::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			NavigationApiController::purgeMethod( 'getData' );
		}

		return true;
	}

	/**
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param string $reason
	 * @param integer $id
	 * @return bool true
	 */
	public static function onArticleDeleteComplete( WikiPage $wikiPage, User $user, $reason, $id ) {
		ArticlesApiController::purgeCache( $id );
		ArticlesApiController::purgeMethods( [
			[ 'getAsJson', ['id' => $id] ],
			[ 'getAsJson', ['title' => $wikiPage->getTitle()->getPartialURL()] ]
		] );
		return true;
	}

	/**
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param string $text
	 * @param string $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	public static function onArticleSaveComplete( WikiPage $wikiPage, User $user, $text, $summary, $minoredit,
												  $watchthis, $sectionanchor, &$flags, $revision, &$status,
												  $baseRevId ) {
		ArticlesApiController::purgeCache( $wikiPage->getTitle()->getArticleID() );
		ArticlesApiController::purgeMethods( [
			[ 'getAsJson', ['id' => $wikiPage->getId()] ],
			[ 'getAsJson', ['title' => $wikiPage->getTitle()->getPartialURL()] ]
		] );
		return true;
	}

	/**
	 * @param Article $article
	 * @param User $user
	 * @param Revision $revision
	 * @param $current
	 * @return bool
	 */
	public static function onArticleRollbackComplete( $article, $user, $revision, $current ) {
		ArticlesApiController::purgeCache( $article->getTitle()->getArticleID() );
		ArticlesApiController::purgeMethods( [
			[ 'getAsJson', ['id' => $article->getId()] ],
			[ 'getAsJson', ['title' => $article->getTitle()->getPartialURL()] ]
		] );
		return true;
	}

	/**
	 * @param Title $title
	 * @param Title $newtitle
	 * @param User $user
	 * @param $oldid
	 * @param $newid
	 * @return bool
	 */
	public static function onTitleMoveComplete( Title &$title, Title &$newtitle, User &$user, $oldid, $newid ) {
		ArticlesApiController::purgeCache( $newtitle->getArticleID() );
		ArticlesApiController::purgeMethods([
			[ 'getAsJson', ['id' => $title->getArticleID()] ],
			[ 'getAsJson', ['title' => $title->getPartialURL()] ]
		]);
		return true;
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
	public static function ArticleCommentListPurgeComplete( Title $title ) {
		ArticlesApiController::purgeCache( $title->getArticleID() );
		return true;
	}
}
