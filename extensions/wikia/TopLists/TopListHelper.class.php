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

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Callback for the CreatePage::FetchOptions hook
	 */
	static public function onCreatePageFetchOptions( &$options ) {
		global $wgCdnStylePath, $wgExtensionsPath, $wgScript;
		
		wfLoadExtensionMessages( 'TopLists' );
		
		$specialPageTitle = Title::newFromText( 'CreateTopList', NS_SPECIAL );
		$url = $specialPageTitle->getFullUrl();

		$options[ 'toplist' ] = array(
			'namespace' => NS_TOPLIST,
			'label' => wfMsg( 'toplists-createpage-dialog-label' ),
			//'icon' => "{$wgCdnStylePath}{$wgExtensionsPath}/wikia/TopLists/images/thumbnail_toplist.png"
			'icon' => "{$wgExtensionsPath}/wikia/TopLists/images/thumbnail_toplist.png",
			'trackingId' => 'toplist',
			'submitUrl' => "{$url}/$1"
		);

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

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * List editor utility function
	 */
	static public function renderImageBrowser() {
		global $wgRequest;
		wfLoadExtensionMessages( 'TopLists' );

		$titleText = $wgRequest->getText( 'title' );
		$selectedImageTitle = $wgRequest->getText( 'selected' );
		$images = array();
		$selectedImage = null;


		if( !empty( $titleText ) ) {
			$title = Title::newFromText( $titleText );

			if( !empty( $title ) && $title->exists() ) {
				$articleId = $title->getArticleId();

				$source = new imageServing(
					array( $articleId ),
					120,
					array(
						"w" => 3,
						"h" => 2
					)
				);

				$result = $source->getImages( 7 );

				if( !empty( $result[ $articleId ] ) ) {
					$images = $result[ $articleId ];
				}
			}
		}

		if( !empty( $selectedImageTitle ) ) {
			$source = new imageServing(
				null,
				120,
				array(
					"w" => 3,
					"h" => 2
				)
			);

			$thumbs = $source->getThumbnails( array( $selectedImageTitle ) );

			if( !empty( $thumbs[ $selectedImageTitle ] ) ) {
				$selectedImage = $thumbs[ $selectedImageTitle ];
			}

		}

		$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );

		$tpl->set_vars(
			array(
				'selectedImage' => $selectedImage,
				'images' => $images
			)
		);

		$text = $tpl->execute('image_browser');

		$response = new AjaxResponse( $text );
		$response->setContentType('text/plain; charset=utf-8');

		return $response;
	}

	static public function uploadImage() {
		global $wgRequest;

		if ( $wgRequest->wasPosted() ) {
			wfLoadExtensionMessages( 'TopLists' );
			wfLoadExtensionMessages( 'WikiaPhotoGallery' );
			$ret = WikiaPhotoGalleryUpload::uploadImage();

			if ( !empty( $ret[ 'conflict' ] ) ) {
				$ret['message'] = wfMsg( 'toplists-error-image-already-exists' );
			} elseif ( !empty ( $ret[ 'success' ] ) && !empty( $ret[ 'name' ] ) ) {
				$source = new imageServing(
					null,
					120,
					array(
						"w" => 3,
						"h" => 2
					)
				);

				$thumbs = $source->getThumbnails( array( $ret[ 'name' ] ) );

				$pictureName = $ret[ 'name' ];

				if( !empty( $thumbs[ $ret[ 'name' ] ] ) ) {
					$ret[ 'name' ] = $thumbs[ $pictureName ][ 'name' ];
					$ret[ 'url' ] = $thumbs[ $pictureName ][ 'url' ];
				}
			}

			$response = new AjaxResponse('<script type="text/javascript">window.document.responseContent = ' . json_encode( $ret ) . ';</script>');
			$response->setContentType('text/html; charset=utf-8');
			return $response;
		}
	}

	/**
	 * Add a vote for the item
	 *
	 * @author ADi
	 *
	 */
	public static function voteItem() {
		global $wgRequest;

		$result = array( 'result' => false );

		$titleText = $wgRequest->getVal( 'title' );

		if( !empty( $titleText ) ) {
			$item = TopListItem::newFromText( $titleText );

			if( $item instanceof TopListItem ) {

				$result['result'] = $item->vote();
				$result['listBody'] = TopListParser::parse( $item->getList() );
			}
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}
}
?>
