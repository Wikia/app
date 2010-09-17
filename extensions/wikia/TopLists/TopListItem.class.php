<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListItem object implementation
 */

class TopListItem extends TopListBase {

	protected $mVotesCount = null;
	protected $mNewContent = null;
	protected $mVotesCountCacheTTL = 6; // in hours
	private $mList = null;

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method, usage of TopList::createItem is preferred
	 *
	 * @param string $name a string representation of the article title
	 *
	 * @return mixed a TopListItem instance, false in case $name represents a title not in the NS_TOPLIST namespace
	 */
	static public function newFromText( $name ) {
		$title = Title::newFromText( $name, NS_TOPLIST );

		if ( !( $title instanceof Title ) ) {
			return false;
		}

		return self::newFromTitle( $title );
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Factory method, usage of TopList::createItem is preferred
	 *
	 * @param Title $title a Title class instance for the article
	 *
	 * @return mixed a TopListItem instance, false in case $title is not in the NS_TOPLIST namespace
	 */
	static public function newFromTitle( Title $title ) {
		if ( $title->getNamespace() == NS_TOPLIST ) {
			$list = new self();
			$list->mTitle = $title;

			return $list;
		}

		return false;
	}

	/**
	 * Registers a new vote for the item
	 *
	 * @author ADi
	 * @author Federico "Lox" Lucignano
	 *
	 * @return boolean true if the vote has been processed correctly, false otherwise
	 */

	public function vote() {
		if( $this->exists() ) {
			$oFauxRequest = new FauxRequest(array( "action" => "insert", "list" => "wkvoteart", "wkpage" => $this->getArticle()->getId(), "wkvote" => 3 ));
			$oApi = new ApiMain($oFauxRequest);

			$oApi->execute();

			$this->mVotesCount = null;
			$aResult = $oApi->GetResultData();

			$success = !empty( $aResult );

			if( $success ) {
				// increment votes counter cache
				$this->incrCachedVotesCount();

				// invalidate cache
				$this->getList()->invalidateCache();

				// mark user as voted, to avoid api caching issues
				$this->getList()->setUserVoted();
			}

			return $success;
		}
	}

	/**
	 * Gets the total number of votes for the item
	 *
	 * @author ADi
	 * @param bool $forceUpdate force update flag
	 * @return integer a number representing the total amount of votes for this item
	 */
	public function getVotesCount( $forceUpdate = false ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		if( ( $this->mVotesCount == null ) || $forceUpdate ) {

			$cacheKey = $this->getVotesCountCacheKey();
			$cachedValue = $wgMemc->get( $cacheKey );
			if( !empty( $cachedValue ) ) {
				wfProfileOut( __METHOD__ );
				return $cachedValue;
			}

			$pageId = $this->getArticle()->getId();

			$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $pageId, "wkuservote" => 0 ));
			$oApi = new ApiMain($oFauxRequest);
			$oApi->execute();
			$aResult = $oApi->GetResultData();

			if( isset( $aResult['query']['wkvoteart'][$pageId]['votescount'] ) ) {
				$this->mVotesCount = $aResult['query']['wkvoteart'][$pageId]['votescount'];
			} else {
				$this->mVotesCount = 0;
			}
			$wgMemc->set( $cacheKey, intval( $this->mVotesCount ), ( $this->mVotesCountCacheTTL * 3600 ) );
		}

		wfProfileOut( __METHOD__ );
		return $this->mVotesCount;
	}

	/**
	 * increment cached value of votes no. (if exists)
	 *
	 * @author ADi
	 */
	private function incrCachedVotesCount() {
		global $wgMemc;
		$wgMemc->incr( $this->getVotesCountCacheKey() );
	}

	private function getVotesCountCacheKey() {
		return wfMemcKey( $this->getTitleText(), 'votesCount' );
	}

	/**
	 * Get the user name of item creator
	 *
	 * @author Adrian 'ADi' Wieczorek
	 * @return string
	 */
	public function getCreatorUserName() {
		return $this->mTitle->getFirstRevision()->getUserText();
	}

	public function getTitleText() {
		return $this->getTitle()->getText();
	}

	/**
	 * get list title text for current item
	 *
	 * @author ADi
	 * @return string
	 */
	public function getListTitleText() {
		$titleParts = explode('/', $this->getTitle()->getText());
		return ( isset( $titleParts[count($titleParts) - 2] ) ? $titleParts[count($titleParts) - 2] : '' );
	}

	/**
	 * get list object for current item
	 *
	 * @author ADi
	 * @return TopList
	 */
	public function getList() {
		if( $this->mList == null ) {
			$this->mList = TopList::newFromText( $this->getListTitleText() );
		}
		return $this->mList;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Sets the new content for the item
	 *
	 * @param string $content the string containing the wikitext to store in the list item article
	 */
	public function setNewContent( $content ) {
		$this->mNewContent = ( string ) $content;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Gets the new content for the item previosly set through setNewContent, for existing content use the Artilce instance accessible through getArticle()
	 *
	 * @return string the new content for the item
	 */
	public function getNewContent() {
		return $this->mNewContent;
	}

	/**
	 * Checks if the user has already casted a vote
	 *
	 * @author ADi
	 * @return boolean true if no vote has been recorded for the user, false otherwise
	 */
	public function userCanVote() {
		$pageId = $this->getArticle()->getId();
		$result = true;

		$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $pageId, "wkuservote" => 1 ));
		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult = $oApi->GetResultData();

		if( isset( $aResult['query']['wkvoteart'][$pageId]['uservote'] ) ) {
			$result = false;
		} else {
			$result = true;
		}

		return $result;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::checkForProcessing
	 */
	public function checkForProcessing( $mode = TOPLISTS_SAVE_AUTODETECT, User $user = null, $listMode = TOPLISTS_SAVE_UPDATE ) {
		$errors = parent::checkForProcessing( $mode, $user );

		if( $errors === true ) {
			$errors = array();
		}

		$title = Title::newFromText( $this->mTitle->getBaseText(), NS_TOPLIST );

		if( !( ( $title instanceof Title ) && $title->exists() ) && $listMode == TOPLISTS_SAVE_UPDATE ) {
			$errors [] = array(
				'msg' => 'toplists-error-article-not-exists',
				'params' => array(
					$title->getSubpageText(),
					$title->getEditURL()
				)
			);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * overrides TopListBase::save
	 * remember to invalidate the list (parent) article cache to update
	 * the page's contents if you add items programmatically
	 */
	public function save( $mode = TOPLISTS_SAVE_AUTODETECT ) {
		$errors = array();
		$mode = $this->_detectProcessingMode( $mode );
		$checkResult = $this->checkForProcessing( $mode );

		if ( $checkResult === true ) {
			$summaryMsg = null;
			$editMode = null;

			if ( $mode == TOPLISTS_SAVE_CREATE ) {
				$summaryMsg = 'toplists-item-creation-summary';
				$editMode = EDIT_NEW;
			} else {
				$summaryMsg = 'toplists-item-update-summary';
				$editMode = EDIT_UPDATE;
			}

			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$status = $article->doEdit( $this->mNewContent , wfMsgForContent( $summaryMsg ), $editMode );

			if ( !$status->isOK() ) {
				foreach ( $status->getErrorsArray() as $msg ) {
					$errors[] = array(
						'msg' => $msg,
						'params' => null
					);
				}
			}
		} else {
			$errors = array_merge( $errors, $checkResult );
		}

		return ( empty( $errors ) ) ? true : $errors;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 *
	 * Removes an item article
	 * remember to invalidate the list (parent) article cache to update
	 * the page's contents if you add items programmatically
	 */
	public function remove() {
		$errors = array();

		if ( $this->exists() ) {
			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$success = $article->doDeleteArticle( wfMsgForContent( 'toplists-item-remove-summary' ) );

			if ( !$success ) {
				$errors[] = array(
						'msg' => 'toplists-item-cannot-delete',
						'params' => null
				);
			}
		} else {
			$errors [] = array(
				'msg' => 'toplists-error-article-not-exists',
				'params' => array(
					$this->mTitle->getSubpageText(),
					$this->mTitle->getEditURL()
				)
			);
		}

		return ( empty( $errors ) ) ? true : $errors;
	}
}