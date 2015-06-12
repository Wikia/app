<?php

/**
 * ArticleCommentList is a listing, basically it's an array of comments
 */
class ArticleCommentList {
	const CACHE_VERSION = 'v2';

	private $mTitle;
	private $mText;
	private $mCommentId = null;
	private $mComments = false;
	private $mCommentsAll = false;
	private $mCount = false;       // Count of comments actually loaded after paging rules are applied
	private $mCountNested = false;
	private $mCountAll = false;    // Count of all comments
	private $mCountAllNested = false;
	private $mMaxPerPage = false;
	private static $mArticlesToDelete;
	private static $mDeletionInProgress = false;

	static public function newFromTitle( Title $title ) {
		$comments = new ArticleCommentList();
		$comments->setTitle( $title );
		$comments->setText( $title->getDBkey( ) );

		return $comments;
	}

	static public function newFromText( $text, $namespace ) {
		$articlePage = Title::newFromText( $text, $namespace );
		if ( ! $articlePage ) {
			/**
			 * doesn't exist, lame
			 */
			return false;
		}

		$comments = new ArticleCommentList();
		$comments->setText( $articlePage->getDBkey() );
		$comments->setTitle( $articlePage );
		return $comments;
	}

	function __construct() {
		global $wgArticleCommentsMaxPerPage;
		$this->setMaxPerPage($wgArticleCommentsMaxPerPage);
	}

	public function setMaxPerPage( $val ) {
 		$this->mMaxPerPage = $val;
	}

	public function setText( $text ) {
		$this->mText = $text;
	}

	/**
	 * setId -- set mCommentId it will limit select to only this comment
	 */

	public function setId( $id ) {
		$this->mCommentId = $id;
	}

	/**
	 * setTitle -- standard accessor/setter
	 */
	public function setTitle( Title $title ) {
		$this->mTitle = $title;
	}

	/**
	 * getTitle -- standard accessor/getter
	 */
	public function getTitle( ) {
		return $this->mTitle;
	}

	/**
	 * getCountAll -- count 1st level comments
	 */
	public function getCountAll() {
		if ($this->mCountAll === false) {
			$this->getCommentList(false);
		}
		return $this->mCountAll;
	}

	/**
	 * getCountAllNested -- count all comments - including nested
	 */
	public function getCountAllNested() {
		if ($this->mCountAllNested === false) {
			$this->getCommentList(false);
		}
		return $this->mCountAllNested;
	}

	/**
	 * getCountPages -- get a count for the number of pages of article comments
	 */
	public function getCountPages() {
		return ceil( $this->getCountAll() / $this->mMaxPerPage );
	}

	/**
	 * getCommentPages -- get the article contents from the list of article pages
	 *
	 * pass false in page parameter to get ALL pages but
	 * try not to defeat the paging, getting ALL articles is expensive
	 */

	public function getCommentPages( $master = true, $page = 1) {
		global $wgRequest;

		//initialize list of comment ids if not done already
		if ($this->mCommentsAll === false) {
			$this->getCommentList( $master );
		}
		$showall = $wgRequest->getText( 'showall', false );

		//pagination
		if ($page !== false && ($showall != 1 || $this->getCountAllNested() > 200 /*see RT#64641*/)) {
			$this->mComments = array_slice($this->mCommentsAll, ($page - 1) * $this->mMaxPerPage, $this->mMaxPerPage, true);
		} else {
			$this->mComments = $this->mCommentsAll;
		}

		$this->mCount = count($this->mComments);
		$this->mCountNested = 0;

		// grab list of required article IDs
		$commentsQueue = array();
		foreach($this->mComments as $id => &$levels) {
			if(isset($levels['level1'])) {
				$commentsQueue[] = $id;
			}
			if(isset($levels['level2'])) {
				$commentsQueue = array_merge( $commentsQueue, array_keys( $levels['level2'] ) );
			}
		}

		$titles = Title::newFromIds( $commentsQueue );

		$comments = array();
		foreach ( $titles as $title ) {
			$comments[$title->getArticleID()] = ArticleComment::newFromTitle( $title );
		}

		// grab article contents for each comment
		foreach($this->mComments as $id => &$levels) {
			if(isset($levels['level1'])) {
				$levels['level1'] = $comments[$id];
				$this->mCountNested++;
			}
			if(isset($levels['level2'])) {
				foreach($levels['level2'] as $subid => &$sublevel) {
					$sublevel = $comments[$subid];
					$this->mCountNested++;
				}
			}
		}

		return $this->mComments;
	}

	/**
	 * getCommentList -- get the list of pages but NOT the article contents
	 *
	 * @access public
	 *
	 * @param string $master use master connection, skip cache
	 *
	 * @return array
	 */
	public function getCommentList( $master = true ) {
		global $wgRequest, $wgMemc, $wgArticleCommentsEnableVoting;

		wfProfileIn( __METHOD__ );

		$action = $wgRequest->getText( 'action', false );
        $title = $this->getTitle();
		$memckey = self::getCacheKey( $title );

		/**
		 * skip cache if purging or using master connection or in case of single comment
		 */
		if ( $action != 'purge' && !$master && empty($this->mCommentId) ) {
			$this->mCommentsAll = $wgMemc->get( $memckey );
		}

		if ( empty( $this->mCommentsAll ) ) {
			$pages = array();
			$subpages = array();
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			$table = array( 'page' );
			$vars = array( 'page_id', 'page_title' );
			$conds = $this->getQueryWhere($dbr);
			$options = array( 'ORDER BY' => 'page_id DESC' );
			$join_conds = array();

			if( !empty( $wgArticleCommentsEnableVoting ) ) {
				//add votes to the result set
				$table[] = 'page_vote';
				$vars[] = 'count(vote) as vote_cnt';
				$options['GROUP BY'] = 'page_id, page_title';
				$join_conds['page_vote'] = array( 'LEFT JOIN', 'page_id = article_id' );

				// a placeholder for 3 top voted answers
				$top3 = array();
			}
			$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options, $join_conds );

			$helperArray = array();
			while ( $row = $dbr->fetchObject( $res ) ) {
				$parts = ArticleComment::explode($row->page_title);
				$p0 = $parts['partsStripped'][0];

				if (count($parts['partsStripped']) == 2) {
					// push comment replies aside, we'll merge them later
					$subpages[$p0][$row->page_id] = $row->page_id;
				} else {
					// map title to page_id
					$helperArray[$p0] = $row->page_id;

					$pages[$row->page_id]['level1'] = $row->page_id;

					if( !empty( $wgArticleCommentsEnableVoting ) ) {
						// check if the answer is in top 3
						for( $i=0; $i<3; $i++ ) {
							if( !isset($top3[$i]) ) {
								$top3[$i] = array('id' => $row->page_id, 'votes' => $row->vote_cnt);
								break;
							}
							if( $top3[$i]['votes'] > $row->vote_cnt ) {
								continue;
							}
							if( $top3[$i]['votes'] == $row->vote_cnt && $top3[$i]['id'] > $row->page_id ) {
								continue;
							}
							$top3[$i+1] = $top3[$i];
							$top3[$i] = array('id' => $row->page_id, 'votes' => $row->vote_cnt);
							break;
						}
					}
				}
			}
			// attach replies to comments
			foreach( $subpages as $p0 => $level2 ) {
				if( !empty($helperArray[$p0]) ) {
					$idx = $helperArray[$p0];
					$pages[$idx]['level2'] = array_reverse( $level2, true );
				} else {
				//if its empty it's an error in our database
				//someone removed a parent and left its children
				//or someone removed parent and children and
				//restored children or a child without restoring parent
				//--nAndy
				}
			}

			if( !empty( $wgArticleCommentsEnableVoting ) ) {
				// move 3 most voted answers to the top
				$newPages = array();
				for( $i=0; $i<3; $i++ ) {
					if( isset( $top3[$i] ) ) {
						$newPages[$top3[$i]['id']] = $pages[$top3[$i]['id']];
						$pages[$top3[$i]['id']] = null;
					}
				}
				foreach( $pages as $id => $val ) {
					if( $val ) {
						$newPages[$id] = $val;
					}
				}
				$pages = $newPages;
			}

			$dbr->freeResult( $res );
			$this->mCommentsAll = $pages;

			if(empty($this->mCommentId)) {
				$wgMemc->set( $memckey, $this->mCommentsAll, 3600 );
			}
		}

		$this->mCountAll = count($this->mCommentsAll);
		// Set our nested count here RT#85503
		$this->mCountAllNested = 0;
		foreach ($this->mCommentsAll as $comment) {
			$this->mCountAllNested++;
			if (isset($comment['level2'])) {
				$this->mCountAllNested += count($comment['level2']);
			}
		}

		wfProfileOut( __METHOD__ );
		return $this->mCommentsAll;
	}

	/**
	 * getAllCommentPages -- get all comment pages to the article
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getAllCommentPages() {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			array( 'page' ),
			array( 'page_id', 'page_title' ),
			$this->getQueryWhere($dbr),
			__METHOD__
		);

		$pages = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$pages[$row->page_id] = ArticleComment::newFromId( $row->page_id );
		}

		$dbr->freeResult( $res );

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	public function getQueryWhere($dbr) {
		wfProfileIn( __METHOD__ );
		$like = "page_title" . $dbr->buildLike( sprintf( "%s/%s", $this->mText, ARTICLECOMMENT_PREFIX ), $dbr->anyString() );
		$namspace = MWNamespace::getTalk( $this->getTitle()->getNamespace() );

		if(empty($this->mCommentId)) {
			wfProfileOut( __METHOD__ );
			return array($like, 'page_namespace' => $namspace);
		}

		$ac = ArticleComment::newFromId($this->mCommentId);
		$parent = $ac->getTopParent();
		$title = $ac->getTitle();
		if(empty($parent) && (!empty($title))) {
			$parent = $title->getDBkey();
		}
		$like = "page_title" . $dbr->buildLike( $parent, $dbr->anyString() );
		wfProfileOut( __METHOD__ );
		return array($like, 'page_namespace' => $namspace);
	}

	//TODO: review - CruiseControl says this is unused.
	private function getRemovedCommentPages( $oTitle ) {
		wfProfileIn( __METHOD__ );

		$pages = array();

		if ($oTitle instanceof Title) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'archive' ),
				array( 'ar_page_id', 'ar_title' ),
				array(
					'ar_namespace' => MWNamespace::getTalk($this->getTitle()->getNamespace()),
					"ar_title" . $dbr->buildLike( sprintf( "%s/%s", $oTitle->getDBkey(), ARTICLECOMMENT_PREFIX ), $dbr->anyString() )
				),
				__METHOD__,
				array( 'ORDER BY' => 'ar_page_id ASC' )
			);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->ar_page_id ] = array(
					'title' => $row->ar_title,
					'nspace' => MWNamespace::getTalk($this->getTitle()->getNamespace())
				);
			}
			$dbr->freeResult( $res );
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * getData -- return raw data for displaying commentList
	 *
	 * @access public
	 *
	 * @return array data for comments list
	 */
	public function getData($page = 1) {
		global $wgUser, $wgStylePath;

		//$isSysop = in_array('sysop', $groups) || in_array('staff', $groups);
		$canEdit = $wgUser->isAllowed( 'edit' );
		$isBlocked = $wgUser->isBlocked();
		$isReadOnly = wfReadOnly();
		//$showall = $wgRequest->getText( 'showall', false );

		//default to using slave. comments are posted with ajax which hits master db
		//$commentList = $this->getCommentList(false);
		$countComments = $this->getCountAll();
		$countCommentsNested = $this->getCountAllNested();

		$countPages = ceil($countComments / $this->mMaxPerPage);
		$pageRequest = (int) $page;
		$page = 1;
		if ($pageRequest <= $countPages && $pageRequest > 0) {
			$page = $pageRequest;
		}
		$comments = $this->getCommentPages(false, $page);
		$this->preloadFirstRevId( $comments );
		$pagination = $this->doPagination($countComments, count($comments), $page);

		return array(
			'avatar' => AvatarService::renderAvatar($wgUser->getName(), 50),
			'userurl' => AvatarService::getUrl($wgUser->getName()),
			'canEdit' => $canEdit,
			'commentListRaw' => $comments,
			'commentingAllowed' => ArticleComment::canComment( $this->mTitle ),
			'commentsPerPage' => $this->mMaxPerPage,
			'countComments' => $countComments,
			'countCommentsNested' => $countCommentsNested,
			'isAnon' => $wgUser->isAnon(),
			'isBlocked' => $isBlocked,
			'isReadOnly' => $isReadOnly,
			'page' => $page,
			'pagination' => $pagination,
			'reason' => $isBlocked ? $this->blockedPage() : '',
			'stylePath' => $wgStylePath,
			'title' => $this->mTitle
		);
	} // end getData();

	/**
	 * doPagination -- return HTML code for pagination
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	function doPagination($countAll, $countComments, $activePage = 1, $title = null) {
		global $wgTitle;

		$maxDisplayedPages = 6;
		$pagination = '';

		if ( $title == null ){
			$title = $wgTitle;
		}

		if(empty($title)) {
			return "";
		}

		if ($countAll > $countComments) {
			$numberOfPages = ceil($countAll / $this->mMaxPerPage );

			//previous
			if ($activePage > 1) {
				$pagination .= '<a href="' . $title->getLinkUrl('page='. (max($activePage - 1, 1)) ) . '#article-comments" id="article-comments-pagination-link-prev" class="article-comments-pagination-link dark_text_1" page="' . (max($activePage - 1, 1)) . '">' . wfMsg('article-comments-prev-page') . '</a>';
			}

			//first page - always visible
			$pagination .= '<a href="' . $title->getFullUrl('page=1') . '#article-comments" id="article-comments-pagination-link-1" class="article-comments-pagination-link dark_text_1' . ($activePage == 1 ? ' article-comments-pagination-link-active accent' : '') . '" page="1">1</a>';

			//calculate the 2nd and the last but one pages to display
			$firstVisiblePage = max(2, min($numberOfPages - $maxDisplayedPages + 1, $activePage - $maxDisplayedPages + 4));
			$lastVisiblePage = min($numberOfPages - 1, $maxDisplayedPages + $firstVisiblePage - 2);

			//add spacer when there is a gap between 1st and 2nd visible page
			if ($firstVisiblePage > 2) {
				$pagination .= wfMsg('article-comments-page-spacer');
			}

			//generate links
			for ($i = $firstVisiblePage; $i <= $lastVisiblePage; $i++) {
				$pagination .= '<a href="' . $title->getFullUrl('page=' . $i) . '#article-comments" id="article-comments-pagination-link-' . $i . '" class="article-comments-pagination-link dark_text_1' . ($i == $activePage ? ' article-comments-pagination-link-active accent' : '') . '" page="' . $i . '">' . $i . '</a>';
			}

			//add spacer when there is a gap between 2 last links
			if ($numberOfPages - $lastVisiblePage > 1) {
				$pagination .= wfMsg('article-comments-page-spacer');
			}

			//add last page - always visible
			$pagination .= '<a href="' . $title->getFullUrl('page=' . $numberOfPages) . '#article-comments" id="article-comments-pagination-link-' . $numberOfPages . '" class="article-comments-pagination-link dark_text_1' . ($numberOfPages == $activePage ? ' article-comments-pagination-link-active accent' : '') . '" page="' . $numberOfPages . '">' . $numberOfPages . '</a>';

			//next
			if ($activePage < $numberOfPages) {
				$pagination .= '<a href="' . $title->getFullUrl('page=' . (min($activePage + 1, $numberOfPages)) ) . '#article-comments" id="article-comments-pagination-link-next" class="article-comments-pagination-link dark_text_1" page="' . (min($activePage + 1, $numberOfPages)) . '">' . wfMsg('article-comments-next-page') . '</a>';
			}
		}
		return $pagination;
	}

	/**
	 * blockedPage -- return HTML code for displaying reason of user block
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	public function blockedPage() {
		global $wgUser, $wgLang, $wgContLang, $wgRequest;

		// macbre: prevent fatals in code below
		if (empty($wgUser->mBlock)) {
			return '';
		}

		list ($blockerName, $reason, $ip, $blockid, $blockTimestamp, $blockExpiry, $intended) = array(
			User::whoIs( $wgUser->blockedBy() ),
			$wgUser->blockedFor() ? $wgUser->blockedFor() : wfMsg( 'blockednoreason' ),
			$wgRequest->getIP(),
			$wgUser->getBlockId(),
			$wgLang->timeanddate( wfTimestamp( TS_MW, $wgUser->mBlock->mTimestamp ), true ),
			$wgUser->mBlock->mExpiry,
			$wgUser->mBlock->mAddress
		);

		$blockerLink = '[[' . $wgContLang->getNsText( NS_USER ) . ":{$blockerName}|{$blockerName}]]";

		if ( $blockExpiry == 'infinity' ) {
			$scBlockExpiryOptions = wfMsg( 'ipboptions' );
			foreach ( explode( ',', $scBlockExpiryOptions ) as $option ) {
				if ( strpos( $option, ":" ) === false ) continue;
				list( $show, $value ) = explode( ":", $option );
				if ( $value == 'infinite' || $value == 'indefinite' ) {
					$blockExpiry = $show;
					break;
				}
			}
		} else {
			$blockExpiry = $wgLang->timeanddate( wfTimestamp( TS_MW, $blockExpiry ), true );
		}

		if ( $wgUser->mBlock->mAuto ) {
			$msg = 'autoblockedtext';
		} else {
			$msg = 'blockedtext';
		}

		return wfMsgExt( $msg, array('parse'), $blockerLink, $reason, $ip, $blockerName, $blockid, $blockExpiry, $intended, $blockTimestamp );
	}

	/**
	 * remove lising from cache and mark title for squid as invalid
	 */
	public function purge() {
		self::purgeCache( $this->mTitle );
	}

	protected function preloadFirstRevId( $comments ) {
		wfProfileIn( __METHOD__ );
		$articles = array();
		foreach ($comments as $id => $levels) {
			if ( isset($levels['level1']) ) {
				if ( !empty( $levels['level1'] ) ) {
					$articles[$levels['level1']->getTitle()->getArticleID()] = $levels['level1'];
				}
			}
			if ( isset($levels['level2']) ) {
				foreach ($levels['level2'] as $nested) {
					if ( !empty( $nested ) ) {
						$articles[$nested->getTitle()->getArticleID()] = $nested;
					}
				}
			}
		}

		if ( !empty( $articles ) ) {
			$db = wfGetDB( DB_SLAVE );
			$res = $db->select(
				'revision',
				array( 'rev_page', 'min(rev_id) AS min_rev_id' ),
				array( 'rev_page' => array_keys($articles) ),
				__METHOD__,
				array(
					'GROUP BY' => 'rev_page',
				)
			);

			foreach ($res as $row) {
				if ( isset( $articles[$row->rev_page] ) ) {
					$articles[$row->rev_page]->setFirstRevId( $row->min_rev_id, DB_SLAVE );
					unset( $articles[$row->rev_page] );
				}
			}

			foreach ($articles as $id => $comment) {
				$comment->setFirstRevId( false, DB_SLAVE );
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Hook
	 *
	 * @param WikiPage $wikiPage -- instance of WikiPage class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $error   -- error msg
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDelete( WikiPage &$wikiPage, &$user, &$reason, &$error ) {
		wfProfileIn( __METHOD__ );

		$title = $wikiPage->getTitle();

		if ( empty( self::$mArticlesToDelete ) ) {
			$listing = ArticleCommentList::newFromTitle($title);
			self::$mArticlesToDelete = $listing->getAllCommentPages();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Generates a cache key give a Title instance
	 *
	 * @param Title $title
	 *
	 * @return string The cache key
	 */
	static private function getCacheKey( Title $title ) {
		return wfMemcKey( 'articlecomment', 'comm', md5( $title->getDBkey() . $title->getNamespace() . self::CACHE_VERSION ) );
	}

	/**
	 * Centralized memcache purging to avoid getting the cache out of sync.
	 *
	 * @param Title $title [description]
	 *
	 * @return [type] [description]
	 */
	static public function purgeCache( Title $title ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$wgMemc->delete( self::getCacheKey( $title ) );
		$title->invalidateCache();
		$title->purgeSquid();

		wfRunHooks( 'ArticleCommentListPurgeComplete', array( $title ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Hook
	 *
	 * @param WikiPage $wikiPage -- instance of Article class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $id      -- article id
	 *
	 * @static
	 * @access public
	 *
	 * @return boolean -- because it's a hook
	 */
	static public function articleDeleteComplete( WikiPage &$wikiPage, &$user, $reason, $id ) {
		global $wgOut, $wgRC2UDPEnabled, $wgMaxCommentsToDelete, $wgCityId, $wgUser, $wgEnableMultiDeleteExt;
		wfProfileIn( __METHOD__ );

		$title = $wikiPage->getTitle();

		if (!MWNamespace::isTalk($title->getNamespace()) || !ArticleComment::isTitleComment($title)) {
			if ( empty( self::$mArticlesToDelete ) ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}

		if(class_exists('WallHelper') && WallHelper::isWallNamespace( $title->getNamespace() )) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		//watch out for recursion
		if (self::$mDeletionInProgress) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		self::$mDeletionInProgress = true;

		//redirect to article/blog after deleting a comment (or whole article/blog)
		$parts = ArticleComment::explode($title->getText());
		$parentTitle = Title::newFromText($parts['title'], MWNamespace::getSubject($title->getNamespace()));
		$wgOut->redirect($parentTitle->getFullUrl());

		//do not use $reason as it contains content of parent article/comment - not current ones that we delete in a loop

		$deleteReason = wfMsgForContent('article-comments-delete-reason');

		//we have comment 1st level - checked in articleDelete() (or 2nd - so do nothing)
		if (is_array(self::$mArticlesToDelete)) {
			$mDelete = 'live';
			if ( isset($wgMaxCommentsToDelete) && ( count(self::$mArticlesToDelete) > $wgMaxCommentsToDelete ) ) {
				if ( !empty($wgEnableMultiDeleteExt) ) {
					$mDelete = 'task';
				}
			}

			if ( $mDelete == 'live' ) {
				$irc_backup = $wgRC2UDPEnabled;	//backup
				$wgRC2UDPEnabled = false; //turn off
				foreach (self::$mArticlesToDelete as $page_id => $oComment) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						$oComment = new ArticleComment($oCommentTitle);
						$oComment->doDeleteComment($deleteReason);
					}
				}

				$wgRC2UDPEnabled = $irc_backup; //restore to whatever it was
				$listing = ArticleCommentList::newFromTitle($parentTitle);
				$listing->purge();
			} else {
				$taskParams= array(
					'mode' 		=> 'you',
					'wikis'		=> '',
					'range'		=> 'one',
					'reason' 	=> 'delete page',
					'lang'		=> '',
					'cat'		=> '',
					'selwikia'	=> $wgCityId,
					'edittoken' => $wgUser->getEditToken(),
					'user'		=> $wgUser->getName(),
					'admin'		=> $wgUser->getName()
				);


				foreach (self::$mArticlesToDelete as $oComment) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						/* @var $oCommentTitle Title */
						$data = $taskParams;
						$data['page'] = $oCommentTitle->getFullText();

						$task = new \Wikia\Tasks\Tasks\MultiTask();
						$task->call('delete', $data);
						$submit_id = $task->queue();

						Wikia::log( __METHOD__, 'deletecomment', "Added task ($submit_id) for {$data['page']} page" );
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $oTitle -- instance of Title class
	 * @param Revision $revision    -- new revision
	 * @param Integer  $old_page_id  -- old page ID
	 *
	 * @static
	 * @access public
	 *
	 * @return boolean -- because it's a hook
	 */
	static public function undeleteComments( &$oTitle, $revision, $old_page_id ) {
		global $wgRC2UDPEnabled;
		wfProfileIn( __METHOD__ );

		if ( $oTitle instanceof Title ) {
			$new_page_id = $oTitle->getArticleId();
			$listing = ArticleCommentList::newFromTitle($oTitle);
			$pagesToRecover = $listing->getRemovedCommentPages($oTitle);
			if ( !empty($pagesToRecover) && is_array($pagesToRecover) ) {
				$irc_backup = $wgRC2UDPEnabled;	//backup
				$wgRC2UDPEnabled = false; //turn off
				foreach ($pagesToRecover as $page_id => $page_value) {
					$oCommentTitle = Title::makeTitleSafe( $page_value['nspace'], $page_value['title'] );
					if ($oCommentTitle instanceof Title) {
						$archive = new PageArchive( $oCommentTitle );
						$ok = $archive->undelete( '', wfMsg('article-comments-undeleted-comment', $new_page_id) );

						if ( !is_array($ok) ) {
							Wikia::log( __METHOD__, 'error', "cannot restore comment {$page_value['title']} (id: {$page_id})" );
						}
					}
				}
				$wgRC2UDPEnabled = $irc_backup; //restore to whatever it was
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @desc Changes $secureName in MW ChangesList.php #L815 so Article Comments and extensions which are based on AC (as long as those extensions doesn't have their own hook)
	 *
	 * @param ChangesList $oChangeList -- instance of ChangeList class
	 * @param String $currentName    -- current value of RC key
	 * @param RCCacheEntry $oRCCacheEntry  -- instance of RCCacheEntry class
	 *
	 * @static
	 * @access public
	 *
	 * @return boolean -- because it's a hook
	 */
	static public function makeChangesListKey( $oChangeList, &$currentName, $oRCCacheEntry ) {
		global $wgEnableGroupedArticleCommentsRC;

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		wfProfileIn( __METHOD__ );

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		if( MWNamespace::isTalk($namespace) && ArticleComment::isTitleComment($oTitle) ) {
			$parts = ArticleComment::explode($oTitle->getText());
			if ($parts['title'] != '') {
				$currentName = 'ArticleComments' . $parts['title'];
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param ChangesList $oChangeList -- instance of ChangeList class
	 * @param String $header    -- current value of RC key
	 * @param Array of RCCacheEntry $oRCCacheEntryArray  -- array of instance of RCCacheEntry classes
	 * @param boolean $changeRecentChangesHeader a flag saying Wikia's hook if we want to change header or not
	 * @param string $headerTitle string which will be put as a header for RecentChanges block
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function setHeaderBlockGroup($oChangeList, $header, Array /*of oRCCacheEntry*/ $oRCCacheEntryArray, &$changeRecentChangesHeader, $oTitle, &$headerTitle) {
		global $wgEnableGroupedArticleCommentsRC, $wgEnableWallExt;
		$namespace = $oTitle->getNamespace();

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		if( !is_null($oTitle)
			&& MWNamespace::isTalk($namespace)
			&& ArticleComment::isTitleComment($oTitle)
		) {
			$parts = ArticleComment::explode($oTitle->getFullText());

			if ($parts['title'] != '') {
				$changeRecentChangesHeader = true;

				$title = Title::newFromText( $parts['title'] );

				if ( $title instanceof Title ) {
					$namespace = $title->getNamespace();

					$text = $title->getText();

					$title = Title::newFromText( $text, MWNamespace::getSubject( $namespace ) );

					if ( $title instanceof Title ) {
						if ( ArticleComment::isBlog() ) {
							$messageKey = 'article-comments-rc-blog-comments';
						} else {
							$messageKey = 'article-comments-rc-comments';
						}

						$headerTitle = wfMsgExt($messageKey, array('parseinline'), $title->getPrefixedText());
					} else {
						Wikia::log( __METHOD__, '2', 'Title does not exist: ' . $text, true );
					}
				} else {
					Wikia::log( __METHOD__, '1', 'Title does not exist: ' . $parts['title'], true );
				}


			}
		}

		return true;
	} // end setHeaderBlockGroup()

	/**
	 * formatList
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function formatList($comments) {
		$template = new EasyTemplate( dirname( __FILE__ ) . '/../templates/' );
		$template->set_vars( array(
			'comments'  => $comments
		) );
		return $template->render( 'comment-list' );
	}

	/*
	 * @access public
	 * @deprecated don't use it for Oasis, still needed for non-Oasis skins
	 * @deprecated - not used in Oasis
	 *
	 * @return String HTML text with rendered comments section
	 */

	public function render() {
		return F::app()->renderView('ArticleComments', 'Index');
 	}

	/**
	 * static entry point for hook
	 *
	 * @param Title $title
	 * @param Article $article
	 *
	 * @static
	 * @access public
	 */
	static public function ArticleFromTitle( &$title, &$article ) {
		if( MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title) ) {
			global $wgRequest, $wgOut;
			$redirect = $wgRequest->getText('redirect', false);
			$diff = $wgRequest->getText('diff', '');
			$oldid = $wgRequest->getText('oldid', '');
			$action = $wgRequest->getText('action', '');
			$permalink = $wgRequest->getInt( 'permalink', 0 );

			if (($redirect != 'no') && empty($diff) && empty($oldid) && ($action != 'history') && ($action != 'delete')) {
				$parts = ArticleComment::explode($title->getText());
				$redirectTitle = Title::newFromText($parts['title'], MWNamespace::getSubject($title->getNamespace()));
				$commentId = $title->getArticleID();

				if ($redirectTitle) {
					$query = array();

					if ( $permalink || $commentId !== 0 ) {
						if( $commentId !== 0 ) {
							/** bugId:11179 @author: nAndy */
							$permalink = $commentId;
						}

						$redirectTitle->setFragment("#comm-$permalink");
						$page = self::getPageForComment( $redirectTitle, $permalink );
						if ( $page > 1 ) {
							$query = array( 'page' => $page );
						}
					}

					$wgOut->redirect($redirectTitle->getFullUrl( $query ));
				}
			}
		}

		return true;
	}

	static private function getPageForComment( $title, $id ) {
		$page = 0;

		$articleComment = ArticleCommentList::newFromTitle( $title );
		$commentList = $articleComment->getCommentList( false );
		$topLevel = array_keys($commentList);
		$found = array_search( $id, $topLevel );
		if ( $found !== false ) {
			$page = ceil( ( $found + 1 ) / $articleComment->mMaxPerPage );
		} else {
			// not found in top level comments so we have to search 2nd level comments
			$index = 0;
			foreach ($commentList as $comment) {
				$index ++;
				if (isset($comment['level2'])) {
					$found = array_search($id, $comment['level2']);
					if ($found !== false) {
						$page = ceil ( $index / $articleComment->mMaxPerPage  );
					}
				}
			}
		}

		return $page;
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function onConfirmEdit(&$SimpleCaptcha, &$editPage, $newtext, $section, $merged, &$result) {
		$title = $editPage->getArticle()->getTitle();
		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			$result = true;	//omit captcha
			return false;
		}
		return true;
	}

	/**
	 * TODO: Document what the parameters are.
	 */
	static function ChangesListInsertArticleLink($changeList, &$articlelink, &$s, $rc, $unpatrolled, $watched) {
		$rcTitle = $rc->getAttribute('rc_title');
		$rcNamespace = $rc->getAttribute('rc_namespace');
		$title = Title::newFromText($rcTitle, $rcNamespace);

		if( MWNamespace::isTalk($rcNamespace) && ArticleComment::isTitleComment($title) ) {
			$parts = ArticleComment::explode($rcTitle);

			$titleMainArticle = Title::newFromText($parts['title'], MWNamespace::getSubject($rcNamespace));

			//fb#15143
			if( $titleMainArticle instanceof Title ) {
				if ( ArticleComment::isBlog() ) {
					$messageKey = 'article-comments-rc-blog-comment';
				} else {
					$messageKey = 'article-comments-rc-comment';
				}

				$articleId = $title->getArticleId();
				$articlelink = wfMsgExt($messageKey, array('parseinline'), $title->getFullURL("permalink=$articleId#comm-$articleId"),  $titleMainArticle->getText());
			} else {
			//it should never happened because $rcTitle is never empty,
			//ArticleComment::explode() always returns an array with not-empty 'title' element,
			//(both files: ArticleComments/classes/ArticleComments.class.php
			//and WallArticleComment/classes/ArticleComments.class.php have
			//the same definition of explode() method)
			//and static constructor newFromText() should create a Title instance for $parts['title']
				Wikia::log( __METHOD__, false, 'WALL_ARTICLE_COMMENT_ERROR: no main article title: '.print_r($parts, true).' namespace: '.$rcNamespace );
			}
		}

		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $oTitle -- instance of Title class
	 * @param User    $User    -- current user
	 * @param string  $reason  -- undeleting reason
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's hook
	 */
	static public function undeleteComplete($oTitle, $oUser, $reason) {
		wfProfileIn( __METHOD__ );
		if ($oTitle instanceof Title) {
			if ( in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) ) {
				$aProps = $oTitle->aProps;
				$pageId = $oTitle->getArticleId();
				if (!empty($aProps)) {
					BlogArticle::setProps($pageId, $aProps);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
