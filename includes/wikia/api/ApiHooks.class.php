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

	public static function onWikiFactoryChanged( $cv_name , $city_id, $value ) {
		if ( $cv_name == NavigationModel::WIKIA_GLOBAL_VARIABLE ) {
			NavigationApiController::purgeMethod( 'getData' );
		}

		return true;
	}

	public static function onMessageCacheReplace( $title, $text ) {
		if ( self::isWikiNavMessage( Title::newFromText( $title, NS_MEDIAWIKI ) ) ) {
			NavigationApiController::purgeMethod( 'getData' );
		}

		return true;
	}

	public static function onArticleDeleteComplete( &$article, User &$user, $reason, $id ) {
		ArticlesApiController::purgeCache( $id );
		return true;
	}

	public static function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		ArticlesApiController::purgeCache( $article->getTitle()->getArticleID() );
		return true;
	}

	public static function onArticleRollbackComplete( &$article, $user, $revision, $current ) {
		ArticlesApiController::purgeCache( $article->getTitle()->getArticleID() );
		return true;
	}

	public static function ArticleCommentListPurgeComplete( Title $title ) {
		ArticlesApiController::purgeCache( $title->getArticleID() );
		return true;
	}
}