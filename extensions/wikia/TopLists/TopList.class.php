<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopList object implementation
 */

class TopList extends TopListBase {
	const ITEM_TITLE_PREFIX = 'toplist-item-';
	protected $mRelatedArticle = null;
	protected $mPicture = null;
	protected $mItems = array();
	protected $mUserCanVote = null;

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method
	 *
	 * @param string $name a string representation of the article title
	 *
	 * @return mixed a TopList instance, false in case $name represents a title not in the NS_TOPLIST namespace
	 */
	static public function newFromText( $name ) {
		$title = Title::newFromText( $name, NS_TOPLIST );

		if ( !( $title instanceof Title ) || ( !empty( $title ) && $title->isSubpage() ) ) {
			return false;
		}

		return self::newFromTitle( $title );
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method
	 *
	 * @param Title $title a Title class instance for the article
	 *
	 * @return mixed a TopList instance, false in case $title is not in the NS_TOPLIST namespace
	 */
	static public function newFromTitle( Title $title ) {
		global $wgMemc;

		if ( $title->getNamespace() == NS_TOPLIST && !$title->isSubpage() ) {
			$list = new self();
			$list->mTitle = $title;

			//needed to let getItems fetch fresh data when instantiating more tha once with the same title object
			$wgMemc->set( $list->_getNeedRefreshCacheKey(), true );

			return $list;
		}

		return false;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::_loadData
	 */
	protected function _loadData( $forceReload = false ) {
		parent::_loadData( $forceReload );

		if( !$this->mDataLoaded || $forceReload ) {
			if( $this->exists() ) {
				TopListParser::parse( $this );

				$relatedArticle = TopListParser::getAttribute( TOPLIST_ATTRIBUTE_RELATED );
				if( !empty( $relatedArticle ) ) {
					$relatedArticle =  Title::newFromText( $relatedArticle );
				}

				$this->setRelatedArticle( $relatedArticle );

				$picture = TopListParser::getAttribute( TOPLIST_ATTRIBUTE_PICTURE );

				if( !empty( $picture ) ) {
					$picture =  Title::newFromText( $picture );
				}

				$this->setPicture( $picture );
			}

			$this->mDataLoaded = true;
		}
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns a Title instance referencing an article related to this list's contents
	 *
	 * @param bool $forceReload if set to true the local cache will be refreshed
	 *
	 * @return Title a Title instance, null if none is set for this list
	 */
	public function getRelatedArticle( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mRelatedArticle;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Adds a reference to an article related to this list's contents
	 *
	 * @param Title $relatedArticle a Title instance for the article to reference
	 *
	 * @return mixed true in case of success, otherwise a multidimensional array of error messages in this form: array( array( 'msg' => MESSAGE_KEY, 'params' => array() ) )
	 */
	public function setRelatedArticle( Title $relatedArticle = null ) {
		if( !empty( $relatedArticle ) ) {
			if( !$relatedArticle->exists() ) {
				$errors[] = array(
					'msg' => 'toplists-error-article-not-exists',
					'params' => array(
						$relatedArticle->getText(),
						$relatedArticle->getEditURL()
					)
				);

				return $errors;
			}
		}

		$this->mRelatedArticle = $relatedArticle;
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Returns a Title instance referencing an image file in the NS_FILE namespace related to this list
	 *
	 * @param bool $forceReload if set to true the local cache will be refreshed
	 *
	 * @return boolean a Title instance, null if none is set for this list
	 */
	public function getPicture( $forceReload = false ) {
		$this->_loadData( $forceReload );
		return $this->mPicture;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Adds a reference to an article related to this list's contents
	 *
	 * @param Title $relatedArticle a Title instance for the article to reference
	 *
	 * @return mixed true in case of success, otherwise a multidimensional array of error messages in this form: array( array( 'msg' => MESSAGE_KEY, 'params' => array() ) )
	 */
	public function setPicture( Title $picture = null ) {
		if( !empty( $picture ) ) {
			if( !$picture->exists() || $picture->getNamespace() != NS_FILE ) {
				$pictureName = $picture->getText();
				$errors[] = array(
					'msg' => 'toplists-error-picture-not-exists',
					'params' => array(
						$pictureName,
						Skin::makeSpecialUrl( "Upload", array( 'wpDestFile' => $pictureName ) )
					)
				);
			}
		}

		$this->mPicture = $picture;
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Creates and returns a new TopListItem for this list (saving the item is done per item, see TopListItem::save)
	 *
	 * @return mixed an instance of the TopListItem class representing the new item, false in case of errors
	 */
	public function createItem() {
		if( !empty( $this->mTitle ) ) {
			$item = TopListItem::newFromText( $this->mTitle->getText() . '/' . uniqid( self::ITEM_TITLE_PREFIX ) );

			if( !empty( $item ) ) {
				$this->mItems[] = $item;
				return $item;
			}
		}

		return false;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Fetches lists's items
	 *
	 * @param bool $forceReload if set to true the local cache will be refreshed
	 *
	 * @return Array an array of TopListItem instances
	 */
	public function getItems( $forceReload = false ) {
			global $wgMemc;
		//not using _loadData since it invokes the parser

			$cacheKey = $this->_getNeedRefreshCacheKey();
			$needRefresh = $wgMemc->get( $cacheKey );

		if( $this->exists() && ( empty( $this->mItems ) || $forceReload || $needRefresh ) ) {
			$this->mItems = array();


			if( $needRefresh ) {
				$db = DB_MASTER;
				$wgMemc->delete( $cacheKey );
			}
			else {
				$db = DB_SLAVE;
			}

			$subPages = $this->mTitle->getSubpages( -1, $db );

			if( !empty ($subPages)  && $subPages->count() ) {
				$items = array();
				$itemVotes = array();
				$this->mUserCanVote = true;

				foreach( $subPages as $title ) {
					//check for list item prefix, avoid listing comments as items
					if( strpos( $title->getSubpageText(), self::ITEM_TITLE_PREFIX ) === 0 ) {
						$item = TopListItem::newFromTitle( $title );
						if( !$item->userCanVote() ) {
							$this->mUserCanVote = false;
						}

						$items[$item->getArticle()->getId()] = $item;
						$itemVotes[$item->getArticle()->getId()] = $item->getVotesCount();
					}
				}

				$itemVotes = array_reverse( $itemVotes, true);
				arsort( $itemVotes, SORT_NUMERIC );

				foreach( $itemVotes as $id => $value ) {
					$this->mItems[] = $items[$id];
				}
			}
		}

		return $this->mItems;
	}

	/**
	 * @author ADi
	 */
	public function removeItems() {
		foreach( $this->mTitle->getSubpages() as $subpageTitle ) {
			$item = TopListItem::newFromTitle( $subpageTitle );
			$item ->remove();
		}
	}

	/**
	 * get removed list itmes from archive (copy&paste from ArticleComments..;)
	 *
	 * @author ADi
	 * @return array
	 */
	private function _getRemovedItems() {
		wfProfileIn( __METHOD__ );

		$pages = array();

		if ($this->mTitle instanceof Title) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'archive' ),
				array( 'ar_page_id', 'ar_title' ),
				array(
					'ar_namespace' => $this->mTitle->getNamespace(),
					"ar_title LIKE '" . $dbr->escapeLike($this->mTitle->getDBkey()) . "/" . self::ITEM_TITLE_PREFIX . "%'"
				),
				__METHOD__,
				array( 'ORDER BY' => 'ar_page_id ASC' )
			);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->ar_page_id ] = array(
					'title' => $row->ar_title,
					'nspace' => $this->mTitle->getNamespace()
				);
			}
			$dbr->freeResult( $res );
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * @author ADi
	 */
	public function restoreItems() {
		global $wgRC2UDPEnabled;
		wfProfileIn( __METHOD__ );

		if ( $this->mTitle instanceof Title ) {
			$itemsToRecover = $this->_getRemovedItems();
			if ( count( $itemsToRecover ) > 0 ) {
				wfLoadExtensionMessages( 'TopLists' );
				$ircBackup = $wgRC2UDPEnabled; //backup
				$wgRC2UDPEnabled = false; //turn off
				foreach ($itemsToRecover as $pageId => $pageData) {
					$itemTitle = Title::makeTitleSafe( $pageData['nspace'], $pageData['title'] );
					if ($itemTitle instanceof Title) {
						$archive = new PageArchive( $itemTitle );
						$result = $archive->undelete( '', wfMsg( 'toplists-item-restored', $this->mTitle->getArticleId() ) );

						if ( !is_array($result) ) {
							Wikia::log( __METHOD__, 'error', "cannot restore list item: {$pageData['title']} (id: {$pageId})" );
						}
					}
				}
				$wgRC2UDPEnabled = $ircBackup; //restore to whatever it was
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::save
	 */
	public function save( $mode = TOPLISTS_SAVE_AUTODETECT ) {
		global $wgMemc;
		$errors = array();
		$mode = $this->_detectProcessingMode( $mode );
		$checkResult = $this->checkForProcessing( $mode );

		if( $checkResult === true ) {
			$contentText = '';

			if ( !empty( $this->mRelatedArticle ) ) {
				$contentText .= ' ' . TOPLIST_ATTRIBUTE_RELATED . '="' . htmlspecialchars( $this->mRelatedArticle->getText() ) . '"';
			}

			if ( !empty( $this->mPicture ) ) {
				$contentText .= ' ' . TOPLIST_ATTRIBUTE_PICTURE . '="' . htmlspecialchars( $this->mPicture->getText() ) . '"';
			}

			$contentText .= ' ' . TOPLIST_ATTRIBUTE_LASTUPDATE . '="' . wfTimestampNow() . '"';

			$summaryMsg = null;
			$editMode = null;

			if ( $mode == TOPLISTS_SAVE_CREATE ) {
				//$summaryMsg = 'toplists-list-creation-summary';
				$editMode = EDIT_NEW;
			} else {
				//$summaryMsg = 'toplists-list-update-summary';
				$editMode = EDIT_UPDATE;
			}

			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$status = $article->doEdit( '<' . TOPLIST_TAG . "{$contentText} />", $this->_getItemsSummaryStatusMsg(), $editMode );

			if( $editMode == EDIT_NEW ) {
				$article->doWatch();
			}

			if ( !$status->isOK() ) {
				foreach ( $status->getErrorsArray() as $msg ) {
					$errors[] = array(
						'msg' => $msg,
						'params' => null
					);
				}
			}
			else {
				//reset vote counters for each items, to avoid caching issues
				/*
				foreach( $this->getItems() as $item ) {
					$item->resetVotesCount();
				}
				*/

				$wgMemc->set( $this->_getNeedRefreshCacheKey(), true );
			}

		} else {
			$errors = array_merge( $errors, $checkResult);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * build summary message based on item's statuses
	 *
	 * @author ADi
	 * @return string
	 */
	private function _getItemsSummaryStatusMsg() {
		$statusMsg = '';
		$itemsRemoved = 0;
		$itemsCreated = 0;
		$itemsUpdated = 0;
		foreach( $this->getItems() as $item ) {
			switch( $item->getStatus() ) {
				case TOPLISTS_ITEM_CREATED:
					$itemsCreated++;
					break;
				case TOPLISTS_ITEM_UPDATED:
					$itemsUpdated++;
					break;
				case TOPLISTS_ITEM_REMOVED:
					$itemsRemoved++;
					break;
			}
		}

		if( $itemsCreated ) {
			$statusMsg = wfMsgExt( 'toplists-items-created', array( 'parsemag', 'content' ), array( $itemsCreated ) );
		}

		if( $itemsRemoved ) {
			$statusMsg .= ( !empty( $statusMsg ) ? ', ' : '' ) . wfMsgExt( 'toplists-items-removed', array( 'parsemag', 'content' ), array( $itemsRemoved ) );
		}

		if( $itemsUpdated ) {
			$statusMsg .= ( !empty( $statusMsg ) ? ', ' : '' ) . wfMsgExt( 'toplists-items-updated', array( 'parsemag', 'content' ), array( $itemsUpdated ) );
		}

		return !empty( $statusMsg ) ? $statusMsg : wfMsgForContent( 'toplists-items-nochange' );
	}

	/**
	 * invalidates list cache
	 *
	 * @author ADi
	 */
	public function invalidateCache() {
		$this->getTitle()->invalidateCache();
		$this->mTitle->purgeSquid();
		$this->getArticle()->doPurge();
		$this->mDataLoaded = false;
		$this->mItems = array();
	}

	/**
	 * check whether the $wgUser can still vote on list items
	 *
	 * @author ADi
	 * @return bool
	 */
	public function userCanVote() {
		if( $this->mUserCanVote == null ) {
			$this->getItems();
		}

		return $this->mUserCanVote;
	}

	public function setUserVoted() {
		$this->mUserCanVote = false;
	}

	private function _getNeedRefreshCacheKey() {
		return wfMemcKey( $this->getTitle()->getDBkey(), 'updated' );
	}

}
