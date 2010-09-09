<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * Utility class for TopLists extension
 */

class TopListHelper {

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Main setup function for the TopLists extension
	 */
	public static function setup(){

	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Callback for the ArticleFromTitle hook
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		if ( $title->getNamespace() == NS_TOPLIST ) {
			wfLoadExtensionMessages( 'TopLists' );
		}
		
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Callback for the AlternateEdit hook
	 */
	public static function onAlternateEdit( &$editPage ) {
		global $wgOut;

		$title = $editPage->getArticle()->getTitle();

		//TODO: check if is a subpage (list item) and redirect to the list holder (parent article) edit form
		if( $title->getNamespace() == NS_TOPLIST ) {
			$specialPageTitle = Title::newFromText( 'EditTopList', NS_SPECIAL );
			$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . urlencode( $title->getText() ) );
		}
		
		return true;
	}

	/*
	static public function onUnwatchArticleComplete( &$oUser, &$oArticle ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$oUser instanceof User ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$oArticle instanceof Article ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oTitle = $oArticle->getTitle();
		if ( !$oTitle instanceof Title ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$list = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'watchlist',
			'*',
			array(
				'wl_user' => $oUser->getId(),
				'wl_namespace' => NS_BLOG_ARTICLE_TALK,
				"wl_title LIKE '" . $dbr->escapeLike( $oTitle->getDBkey() ) . "/%'",
			),
			__METHOD__
		);
		if( $res->numRows() > 0 ) {
			while( $row = $res->fetchObject() ) {
				$oCommentTitle = Title::makeTitleSafe( $row->wl_namespace, $row->wl_title );
				if ( $oCommentTitle instanceof Title )
					$list[] = $oCommentTitle;
			}
			$dbr->freeResult( $res );
		}

		if ( !empty($list) ) {
			foreach ( $list as $oCommentTitle ) {
				$oWItem = WatchedItem::fromUserTitle( $oUser, $oCommentTitle );
				$oWItem->removeWatch();
			}
			$oUser->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
	*/
}
?>