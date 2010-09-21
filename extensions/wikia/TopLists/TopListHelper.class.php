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
	 * callback for UnwatchArticleComplete hook
	 *
	 * @author ADi
	 * @param $oUser
	 * @param $oArticle
	 */
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

		if( $oTitle->getNamespace() == NS_TOPLIST ) {
			$topList = TopListBase::newFromTitle( $oTitle );
			if( $topList instanceof TopListItem ) {
				// item page, do nothing
			}
			elseif ( $topList instanceof TopList ) {
				// list page, unwatch every item page
				foreach( $topList->getItems() as $item ) {
					if( $item->getTitle()->userIsWatching() ) {
						$watchedItem = WatchedItem::fromUserTitle( $oUser, $item->getTitle() );
						$watchedItem->removeWatch();
					}
				}
			}
			//invalidate user cache
			$oUser->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
	*/

	/**
	 * callback for WatchArticleComplete hook
	 *
	 * @author ADi
	 * @param $oUser
	 * @param $oArticle
	 */
	/*
	static public function onWatchArticleComplete( &$oUser, &$oArticle ) {
		wfProfileIn( __METHOD__ );

		if( $oTitle->getNamespace() == NS_TOPLIST ) {
			$topList = TopListBase::newFromTitle( $oTitle );
			if( $topList instanceof TopListItem ) {
				// item page, watch the list page as well
				$listTitle = $topList->getList()->getTitle();
				if( !$listTitle->userIsWatching() ) {
					$watchedItem = WatchedItem::fromUserTitle( $oUser, $listTitle );
					$watchedItem->addWatch();
				}
			}
			elseif ( $topList instanceof TopList ) {
				// list page, watch every item page
				foreach( $topList->getItems() as $item ) {
					if( $item->getTitle()->userIsWatching() ) {
						$watchedItem = WatchedItem::fromUserTitle( $oUser, $item->getTitle() );
						$watchedItem->addWatch();
					}
				}
			}
			//invalidate user cache
			$oUser->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
	*/

	static public function onComposeCommonSubjectMail( $title, &$keys, &$subject, $editor ) {
		wfProfileIn( __METHOD__ );

		if( ( $title instanceof Title )  && ( $title->getNamespace() == NS_TOPLIST ) ) {
			wfLoadExtensionMessages( 'TopLists' );
			$subject = wfMsg( 'toplists-email-subject' );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onComposeCommonBodyMail( $title, &$keys, &$body, $editor ) {
		wfProfileIn( __METHOD__ );

		if( ( $title instanceof Title )  && ( $title->getNamespace() == NS_TOPLIST ) ) {
			wfLoadExtensionMessages( 'TopLists' );
			$body = wfMsg( 'toplists-email-body', array( $title->getFullUrl(), $keys['$PAGESUMMARY'] ) );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

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
	 * formats a timespan in a seconds/minutes/hours/days/weeks count string
	 *
	 * @author Federico "Lox" Lucignano
	 *
	 * @param int $seconds
	 * @return string
	 */
	public static function formatTimeSpan( $seconds ) {
		wfLoadExtensionMessages( 'TopLists' );

		if ( $seconds < 60 ) {
			return wfMsgExt( 'toplists-seconds', array( 'parsemag', 'content' ), round( $seconds ) );
		} elseif ( $seconds < 3600 ) {
			return wfMsgExt( 'toplists-minutes', array( 'parsemag', 'content' ), round( $seconds / 60 ) );
		} elseif ( $seconds < ( 3600 * 24 ) ) {
			return wfMsgExt( 'toplists-hours', array( 'parsemag', 'content' ), round( $seconds / 3600 ) );
		} elseif ( $seconds < ( 3600 * 24 * 7 ) ) {
			return wfMsgExt( 'toplists-days', array( 'parsemag', 'content' ), round( $seconds / ( 3600 * 24 ) ) );
		} else {
			return wfMsgExt( 'toplists-weeks', array( 'parsemag', 'content' ), round( $seconds / ( 3600 * 24  * 7 ) ) );
		}
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

			if( $item instanceof TopListItem && $item->getList()->exists() && $item->getList()->userCanVote()) {
				$result['result'] = $item->vote();
				$result['listBody'] = TopListParser::parse( $item->getList() );
			}
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	/**
	 * check status of the list (vote/edit permissions)
	 */
	public static function checkListStatus() {
		global $wgRequest;

		$result = array(
			'result' => true,
			'canVote' => false,
			/*'canEdit' => false*/
		);

		$titleText = $wgRequest->getVal( 'title' );

		if( !empty( $titleText ) ) {
			$list = TopList::newFromText( $titleText );

			if( $list instanceof TopList ) {
				$result['canVote'] = $list->userCanVote();
				//$result['canEdit'] = false; // TODO: implement, dropped for the moment
			}
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	public static function addItem() {
		global $wgRequest, $wgUser, $wgScript;
		wfLoadExtensionMessages( 'TopLists' );

		$result = array( 'result' => false );
		$errors = array();

		$listText = $wgRequest->getVal( 'list' );
		$itemText = trim( $wgRequest->getVal( 'text' ) );

		if( !empty( $listText ) && !empty( $itemText ) ) {

			$list = TopList::newFromText( $listText );

			if( $wgUser->isAllowed( 'toplists-create-item' ) ) {
				if( !empty( $list ) && $list->exists() ) {
					//check for duplicated
					foreach( $list->getItems() as $item ) {
						if( strtolower( $item->getArticle()->getContent() ) == strtolower( $itemText ) ) {
							$errors[] = wfMsg( 'toplists-error-duplicated-entry' );
							break;
						}
					}

					if( empty( $errors ) ) {
						$newItem = $list->createItem();
						$newItem->setNewContent( $itemText );

						$saveResult = $newItem->save( TOPLISTS_SAVE_CREATE );

						if ( $saveResult !== true ) {
							foreach ( $saveResult as $errorTuple ) {
								$errors[] =  wfMsg( $errorTuple[ 'msg' ], $errorTuple[ 'params' ] );
							}
						} else {
							//invalidate caches and trigger save event for the list article
							$newItem->getTitle()->invalidateCache();
							$list->save( TOPLISTS_SAVE_UPDATE );
							$list->invalidateCache();

							$result['result'] = true;
							$result['listBody'] = TopListParser::parse( TopList::newFromText( $listText ) );
						}
					}
				} else {
					$errors[] = wfMsg( 'toplists-error-add-item-list-not-exists', $listText );
				}
			} else {
				if( $wgUser->isAnon() ) {
					$loginURL = SpecialPage::getTitleFor( 'Signup' )->getLocalURL() . '?returnto=' . $list->getTitle()->getPrefixedDBkey();
					$errors[] = wfMsg(
						'toplists-error-add-item-anon',
						array(
							 "{$loginURL}&type=login",
							"{$loginURL}&type=signup"
						)
					);
				} else {
					$errors[] = wfMsg( 'toplists-error-add-item-permission' );
				}
			}
		} else {
			$errors[] = wfMsg( 'toplists-error-empty-item-name' );
		}

		if( !empty( $errors ) ) {
			$result[ 'errors' ] = $errors;
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}
}

