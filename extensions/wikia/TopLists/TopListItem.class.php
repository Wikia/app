<?php
/**
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * TopListItem object implementation
 */

class TopListItem extends TopListBase {

	protected $mVotesCount = null;
	protected $mVotesTimestamps = null;
	protected $mNewContent = null;
	protected $mVotesCacheTTL = 6; // in hours
	protected $mStatus = null;
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
			$this->mVotesTimestamps = null;

			$aResult = $oApi->GetResultData();

			$success = !empty( $aResult );

			if( $success ) {
				// increment votes counter cache
				$this->_increaseCachedVotesCount();
				$this->_addCachedVotesTimestamp();

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

			$cacheKey = $this->_getVotesCountCacheKey();
			$cachedValue = $wgMemc->get( $cacheKey );

			if( !empty( $cachedValue ) ) {
				$this->mVotesCount = $cachedValue;

				wfProfileOut( __METHOD__ );
				return $cachedValue;
			}

			$this->_queryVotesApi();
			$wgMemc->set( $cacheKey, intval( $this->mVotesCount ), ( $this->mVotesCacheTTL * 3600 ) );
		}

		wfProfileOut( __METHOD__ );
		return $this->mVotesCount;
	}

	/**
	 * Gets an array of timestamps, one per vote casted on the item
	 *
	 * @author Federico "Lox" Lucignano
	 * @param bool $forceUpdate force update flag
	 * @return Array an array of integer timestamps
	 */
	public function getVotesTimestamps( $forceUpdate = false ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		if( ( $this->mVotesTimestamps == null ) || $forceUpdate ) {

			$cacheKey = $this->_getVotesTimestampsCacheKey();
			$cachedValue = $wgMemc->get( $cacheKey );

			if( !empty( $cachedValue ) ) {
				$this->mVotesTimestamps = $cachedValue;

				wfProfileOut( __METHOD__ );
				return $cachedValue;
			}

			$this->_queryVotesApi();
			$wgMemc->set( $cacheKey, $this->mVotesTimestamps, ( $this->mVotesCacheTTL * 3600 ) );
		}

		wfProfileOut( __METHOD__ );
		return $this->mVotesTimestamps;
	}

	/**
	 * Fetches useful information about article votes for this item
	 *
	 * @author Federico "Lox" Lucignano
	 */
	private function _queryVotesApi() {
		$pageId = $this->getArticle()->getId();

		$oFauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $pageId, "wkuservote" => 0, "wktimestamps" => 1 ));
		$oApi = new ApiMain($oFauxRequest);
		$oApi->execute();
		$aResult = $oApi->GetResultData();

		if( isset( $aResult['query']['wkvoteart'][$pageId]['votescount'] ) ) {
			$this->mVotesCount = $aResult['query']['wkvoteart'][$pageId]['votescount'];
		} else {
			$this->mVotesCount = 0;
		}

		if( !empty( $aResult['query']['wkvoteart'][$pageId]['timestamps'] ) ) {
			$this->mVotesTimestamps = $aResult['query']['wkvoteart'][$pageId]['timestamps'];
		} else {
			$this->mVotesTimestamps = array();
		}
	}

	/**
	 * increment cached value of votes no. (if exists)
	 *
	 * @author ADi
	 */
	private function _increaseCachedVotesCount() {
		global $wgMemc;

		$this->mVotesCount = null;
		$wgMemc->incr( $this->_getVotesCountCacheKey() );
	}


	/**
	 * adds a timestamp to the collection of votes' timestamps
	 *
	 * @author ADi
	 */
	private function _addCachedVotesTimestamp() {
		global $wgMemc;

		$cacheKey = $this->_getVotesTimestampsCacheKey();

		$this->mVotesTimestamps = $wgMemc->get( $cacheKey );
		$this->mVotesTimestamps[] = time();

		$wgMemc->set( $cacheKey, $this->mVotesTimestamps, ( $this->mVotesCacheTTL * 3600 ) );
	}

	private function _getVotesCountCacheKey() {
		return wfMemcKey( $this->getTitle()->getDBkey(), 'votesCount' );
	}

	private function _getVotesTimestampsCacheKey() {
		return wfMemcKey( $this->getTitle()->getDBkey(), 'timestamps' );
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
	 * @author Federico "Lox" Lucignano
	 *
	 * @return string The parsed content of the article referenced by this item
	 */
	public function getParsedContent() {
		global $wgParser;

		if( $this->exists() ) {
			$parserOptions = new ParserOptions();
			return $wgParser->parse($this->getArticle()->getContent(), $this->getTitle(), $parserOptions)->getText();
		}

		return null;
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
				$this->mStatus = TOPLISTS_ITEM_CREATED;
				$editMode = EDIT_NEW;
			} else {
				$summaryMsg = 'toplists-item-update-summary';
				$this->mStatus = TOPLISTS_ITEM_UPDATED;
				$editMode = EDIT_UPDATE;
			}

			wfLoadExtensionMessages( 'TopLists' );
			$article = $this->getArticle();

			$status = $article->doEdit( $this->mNewContent , wfMsgForContent( $summaryMsg ), $editMode );

			if ( !$status->isOK() ) {
				$this->mStatus = null;
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
			else {
				$this->mStatus = TOPLISTS_ITEM_REMOVED;
			}
		}
		else {
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

	public function getStatus() {
		return $this->mStatus;
	}
}