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

		if( $title->getNamespace() == NS_TOPLIST ) {
			//if this is a list item (subpage) then go to the list itself (parent article)
			if( $title->isSubpage() ) {
				$title = Title::newFromText( $title->getBaseText(), NS_TOPLIST );
			}

			$specialPageTitle = Title::newFromText( 'EditTopList', NS_SPECIAL );
			$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . $title->getDBkey() );
		}

		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * List editor utility function
	 */
	static public function clearSessionItemsErrors() {
		if ( !empty( $_SESSION[ 'toplists_failed_data' ] ) ) {
			unset( $_SESSION[ 'toplists_failed_data' ] );
		}
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * List editor utility function
	 */
	static public function getSessionItemsErrors() {
		return ( !empty( $_SESSION[ 'toplists_failed_data' ] ) ) ? $_SESSION[ 'toplists_failed_data' ] : array( null, null, null );
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * List editor utility function
	 */
	static public function setSessionItemsErrors( $listName, $itemNames, $errors ) {
		$_SESSION[ 'toplists_failed_data' ] = array(
			$listName,
			$itemNames,
			$errors
		);
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