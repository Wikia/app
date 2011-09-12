<?php

/**
 * ArticleCommentList is a listing, basicly it's an array of comments
 */
class ArticleCommentList {

	private $mTitle;
	private $mText;
	private $mComments = false;
	private $mCommentsAll = false;
	private $mCount = false;       // Count of comments actually loaded after paging rules are applied
	private $mCountNested = false;
	private $mCountAll = false;    // Count of all comments
	private $mCountAllNested = false;
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

	public function setText( $text ) {
		$this->mText = $text;
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
	 * getCommentPages -- get the article contents from the list of article pages
	 *
	 * pass false in page parameter to get ALL pages but
	 * try not to defeat the paging, getting ALL articles is expensive
	 */

	public function getCommentPages( $master = true, $page = 1) {
		global $wgRequest, $wgArticleCommentsMaxPerPage;

		//initialize list of comment ids if not done already
		if ($this->mCommentsAll === false) {
			$this->getCommentList( $master );
		}
		$showall = $wgRequest->getText( 'showall', false );

		//pagination
		if ($page !== false && ($showall != 1 || $this->getCountAllNested() > 200 /*see RT#64641*/)) {
			$this->mComments = array_slice($this->mCommentsAll, ($page - 1) * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
		} else {
			$this->mComments = $this->mCommentsAll;
		}

		$this->mCount = count($this->mComments);
		$this->mCountNested = 0;

		// grab article contents for each comment
		foreach($this->mComments as $id => &$levels) {
			if(isset($levels['level1'])) {
				$levels['level1'] = ArticleComment::newFromId($id);
				$this->mCountNested++;
			}
			if(isset($levels['level2'])) {
				foreach($levels['level2'] as $subid => &$sublevel) {
					$sublevel = ArticleComment::newFromId($subid);
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

		$memckey = wfMemcKey( 'articlecomment', 'comm', $this->getTitle()->getArticleId(), 'v1' );
		
		/**
		 * skip cache if purging or using master connection
		 */
		if ( $action != 'purge' && !$master ) {
			$this->mCommentsAll = $wgMemc->get( $memckey );
		}

		if ( empty( $this->mCommentsAll ) ) {
			$pages = array();
			$subpages = array();
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			$table = array( 'page' );
			$vars = array( 'page_id', 'page_title' );
			$conds = array(
					'page_namespace' => MWNamespace::getTalk($this->getTitle()->getNamespace()),
					"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . '/' . ARTICLECOMMENT_PREFIX . "%'"
				      );
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
				$pages[$helperArray[$p0]]['level2'] = array_reverse( $level2, true );
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
			$wgMemc->set( $memckey, $this->mCommentsAll, 3600 );
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

		$pages = array();
		$dbr = wfGetDB( DB_MASTER );
		$namespace = $this->getTitle()->getNamespace();

		$res = $dbr->select(
			array( 'page' ),
			array( 'page_id', 'page_title' ),
			array(
				'page_namespace' => MWNamespace::getTalk($namespace),
				"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . '/' . ARTICLECOMMENT_PREFIX . "%'"
			),
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
					"ar_title LIKE '" . $dbr->escapeLike($oTitle->getDBkey()) . "/" . ARTICLECOMMENT_PREFIX . "%'"
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

	public function getData() {
		global $wgUser, $wgTitle, $wgRequest, $wgOut, $wgArticleCommentsMaxPerPage, $wgStylePath;

		if ($wgRequest->wasPosted()) {
			// for non-JS version !!!
			$sComment = $wgRequest->getVal( 'wpArticleComment', false );
			$iArticleId = $wgRequest->getVal( 'wpArticleId', false );
			$sSubmit = $wgRequest->getVal( 'wpArticleSubmit', false );
			if ( $sSubmit && $sComment && $iArticleId ) {
				$oTitle = Title::newFromID( $iArticleId );
				if ( $oTitle instanceof Title ) {
					$response = ArticleComment::doPost( $wgRequest, $wgUser, $oTitle );
					$res = array();
					if ( $response !== false ) {
						$status = $response[0]; $article = $response[1];
						$res = ArticleComment::doAfterPost($status, $article);
					}
					$wgOut->redirect( $oTitle->getLocalURL() );
				}
			}
		}

		wfLoadExtensionMessages('ArticleComments');
		/**
		 * $pages is array of comment articles
		 */
		if (class_exists('Masthead')){
			$avatar = Masthead::newFromUser( $wgUser );
		} else {
			// Formerly Answers (this was in the Social code).
			$avatar = new wAvatar($wgUser->getId(), 'ml');
		}

		$groups = $wgUser->getEffectiveGroups();
		//$isSysop = in_array('sysop', $groups) || in_array('staff', $groups);
		$canEdit = $wgUser->isAllowed( 'edit' );
		$isBlocked = $wgUser->isBlocked();
		$isReadOnly = wfReadOnly();
		//$showall = $wgRequest->getText( 'showall', false );

		//default to using slave. comments are posted with ajax which hits master db
		//$commentList = $this->getCommentList(false);
		$countComments = $this->getCountAll();
		$countCommentsNested = $this->getCountAllNested();
		$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);

		$pageRequest = (int)$wgRequest->getVal( 'page', 1 );
		$page = 1;
		if ($pageRequest <= $countPages && $pageRequest > 0) {
			$page = $pageRequest;
		}
		$comments = $this->getCommentPages(false, $page);
		$pagination = self::doPagination($countComments, count($comments), $page);
		$commentListHTML = wfRenderPartial('ArticleComments', 'CommentList', array('commentListRaw' => $comments, 'page' => $page, 'useMaster' => false));

		$commentingAllowed = true;

		if (defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE) {
			$props = BlogArticle::getProps($wgTitle->getArticleID());
			$commentingAllowed = isset($props['commenting']) ? (bool)$props['commenting'] : true;
		}

		$retVal = array(
			'avatar' => $avatar,
			'canEdit' => $canEdit,
			'commentListRaw' => $comments,
			'commentListHTML' => $commentListHTML,
			'commentingAllowed' => $commentingAllowed,
			'commentsPerPage' => $wgArticleCommentsMaxPerPage,
			'countComments' => $countComments,
			'countCommentsNested' => $countCommentsNested,
			'isAnon' => $wgUser->isAnon(),
			'isBlocked' => $isBlocked,
			'isFBConnectionProblem' => ArticleCommentInit::isFbConnectionNeeded(),
			'isReadOnly' => $isReadOnly,
			'page' => $page,
			'pagination' => array('totalItems' => $countComments, 'itemsPerPage' => $wgArticleCommentsMaxPerPage, 'currentPage' => $page),
			'reason' => $isBlocked ? $this->blockedPage() : '',
			'stylePath' => $wgStylePath,
			'title' => $wgTitle
		);

		return $retVal;
	} // end getData();

	/**
	 * doPagination -- return HTML code for pagination
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	static function doPagination($countAll, $countComments, $activePage = 1, $title = null) {
		global $wgArticleCommentsMaxPerPage, $wgTitle;

		$maxDisplayedPages = 6;
		$pagination = '';

		if ( $title == null ){
			$title = $wgTitle;
		}

		if ($countAll > $countComments) {
			$numberOfPages = ceil($countAll / $wgArticleCommentsMaxPerPage);

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
		global $wgUser, $wgLang, $wgContLang;

		// macbre: prevent fatals in code below
		if (empty($wgUser->mBlock)) {
			return '';
		}

		list ($blockerName, $reason, $ip, $blockid, $blockTimestamp, $blockExpiry, $intended) = array(
			User::whoIs( $wgUser->blockedBy() ),
			$wgUser->blockedFor() ? $wgUser->blockedFor() : wfMsg( 'blockednoreason' ),
			wfGetIP(),
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
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$wgMemc->delete( wfMemcKey( 'articlecomment', 'comm', $this->mTitle->getArticleID(), 'v1' ) );
		$this->mTitle->invalidateCache();
		$this->mTitle->purgeSquid();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Hook
	 *
	 * @param Article $article -- instance of Article class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $error   -- error msg
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDelete( &$article, &$user, &$reason, &$error ) {
		wfProfileIn( __METHOD__ );

		$title = $article->getTitle();

		if ( empty( self::$mArticlesToDelete ) ) {
			$listing = ArticleCommentList::newFromTitle($title);
			self::$mArticlesToDelete = $listing->getAllCommentPages();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Article $article -- instance of Article class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $id      -- article id
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDeleteComplete( &$article, &$user, $reason, $id ) {
		global $wgOut, $wgRC2UDPEnabled, $wgMaxCommentsToDelete, $wgCityId, $wgUser, $wgEnableMultiDeleteExt;
		wfProfileIn( __METHOD__ );

		$title = $article->getTitle();

		if (!MWNamespace::isTalk($title->getNamespace()) || !ArticleComment::isTitleComment($title)) {
			if ( empty( self::$mArticlesToDelete ) ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
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
		wfLoadExtensionMessages('ArticleComments');
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
						$oArticle = new Article($oCommentTitle);
						$oArticle->doDelete($deleteReason);
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
					'edittoken' => $wgUser->editToken(),
					'user'		=> $wgUser->getName(),
					'admin'		=> $wgUser->getName()
				);

				foreach (self::$mArticlesToDelete as $page_id => $oComment) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						$data = $taskParams;
						$data['page'] = $oCommentTitle->getFullText();
						$thisTask = new MultiDeleteTask( $data );
						$submit_id = $thisTask->submitForm();
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
	 * @return true -- because it's a hook
	 */
	static public function undeleteComments( &$oTitle, $revision, $old_page_id ) {
		global $wgRC2UDPEnabled;
		wfProfileIn( __METHOD__ );

		if ( $oTitle instanceof Title ) {
			$new_page_id = $oTitle->getArticleId();
			$listing = ArticleCommentList::newFromTitle($oTitle);
			$pagesToRecover = $listing->getRemovedCommentPages($oTitle);
			if ( !empty($pagesToRecover) && is_array($pagesToRecover) ) {
				wfLoadExtensionMessages('ArticleComments');
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
	 * @param ChangeList $oChangeList -- instance of ChangeList class
	 * @param String $currentName    -- current value of RC key
	 * @param RCCacheEntry $oRCCacheEntry  -- instance of RCCacheEntry class
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	//TODO: review - blogs only?
	static public function makeChangesListKey( &$oChangeList, &$currentName, &$oRCCacheEntry ) {
		global $wgEnableGroupedArticleCommentsRC, $wgEnableBlogArticles;
		wfProfileIn( __METHOD__ );

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		$allowed = !( $wgEnableBlogArticles && in_array($namespace, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) );
		if (!is_null($oTitle) && MWNamespace::isTalk($namespace) && ArticleComment::isTitleComment($oTitle) && $allowed) {
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
	 * @param ChangeList $oChangeList -- instance of ChangeList class
	 * @param String $header    -- current value of RC key
	 * @param Array of RCCacheEntry $oRCCacheEntryArray  -- array of instance of RCCacheEntry classes
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function setHeaderBlockGroup(&$oChangeList, &$header, Array /*of oRCCacheEntry*/ &$oRCCacheEntryArray) {
		global $wgLang, $wgContLang, $wgEnableGroupedArticleCommentsRC;

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		$oRCCacheEntry = null;
		if ( !empty($oRCCacheEntryArray) ) {
			$oRCCacheEntry = $oRCCacheEntryArray[0];
		}

		if ( !is_null($oRCCacheEntry) ) {
			$oTitle = $oRCCacheEntry->getTitle();
			$namespace = $oTitle->getNamespace();

			if ( !is_null($oTitle) && MWNamespace::isTalk($oTitle->getNamespace()) && ArticleComment::isTitleComment($oTitle)) {
				$parts = ArticleComment::explode($oTitle->getFullText());

				if ($parts['title'] != '') {
					$cnt = count($oRCCacheEntryArray);

					$userlinks = array();
					foreach ( $oRCCacheEntryArray as $id => $oRCCacheEntry ) {
			 			$u = $oRCCacheEntry->userlink;
						if ( !isset( $userlinks[$u] ) ) {
							$userlinks[$u] = 0;
						}
						$userlinks[$u]++;
					}

					$users = array();
					foreach( $userlinks as $userlink => $count) {
						$text = $userlink;
						$text .= $wgContLang->getDirMark();
						if ( $count > 1 ) {
							$text .= ' (' . $wgLang->formatNum( $count ) . '×)';
						}
						array_push( $users, $text );
					}

					$cntChanges = wfMsgExt( 'nchanges', array( 'parsemag', 'escape' ), $wgLang->formatNum( $cnt ) );
					$title = Title::newFromText($parts['title']);
					$namespace = $title->getNamespace();
					$title = Title::newFromText($title->getText(), MWNamespace::getSubject($namespace));

					if ((defined('NS_BLOG_ARTICLE') && $namespace == NS_BLOG_ARTICLE) ||
						defined('NS_BLOG_ARTICLE_TALK') && $namespace == NS_BLOG_ARTICLE_TALK ) {
						$messageKey = 'article-comments-rc-blog-comments';
					} else {
						$messageKey = 'article-comments-rc-comments';
					}

					$vars = array (
							'cntChanges'	=> $cntChanges,
							'hdrtitle' 		=> wfMsgExt($messageKey, array('parseinline'), $title->getPrefixedText()),
							'inx'			=> $oChangeList->rcCacheIndex,
							'users'			=> $users
						);
					$header = wfRenderPartial('ArticleComments', 'RCHeaderBlock', $vars);
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
		return wfRenderModule('ArticleComments', 'Index');
 	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function ArticleFromTitle( &$title, &$article ) {
		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			global $wgRequest, $wgOut;
			$redirect = $wgRequest->getText('redirect', false);
			$diff = $wgRequest->getText('diff', '');
			$oldid = $wgRequest->getText('oldid', '');
			$action = $wgRequest->getText('action', '');
			$permalink = $wgRequest->getInt( 'permalink', 0 );
			if (($redirect != 'no') && empty($diff) && empty($oldid) && ($action != 'history') && ($action != 'delete')) {
				$parts = ArticleComment::explode($title->getText());
				$redirectTitle = Title::newFromText($parts['title'], MWNamespace::getSubject($title->getNamespace()));
				if ($redirectTitle) {
					$query = array();
					if ( $permalink ) {
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
		global $wgArticleCommentsMaxPerPage;

		$page = 0;

		$commentList = ArticleCommentList::newFromTitle( $title )->getCommentList( false );
		$topLevel = array_keys($commentList);
		$found = array_search( $id, $topLevel );
		if ( $found !== false ) {
			$page = ceil( ( $found + 1 ) / $wgArticleCommentsMaxPerPage );
		} else {
			// not found in top level comments so we have to search 2nd level comments
			$index = 0;
			foreach ($commentList as $comment) {
				$index ++;
				if (isset($comment['level2'])) {
					$found = array_search($id, $comment['level2']);
					if ($found !== false) {
						$page = ceil ( $index / $wgArticleCommentsMaxPerPage );
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
	static function ChangesListInsertArticleLink($changeList, &$articlelink, &$s, &$rc, $unpatrolled, $watched) {
		$rcTitle = $rc->getAttribute('rc_title');
		$rcNamespace = $rc->getAttribute('rc_namespace');
		$title = Title::newFromText($rcTitle, $rcNamespace);

		if (MWNamespace::isTalk($rcNamespace) && ArticleComment::isTitleComment($title)) {
			$parts = ArticleComment::explode($rcTitle);

			$titleMainArticle = Title::newFromText($parts['title'], MWNamespace::getSubject($rcNamespace));

			if ((defined('NS_BLOG_ARTICLE') && $rcNamespace == NS_BLOG_ARTICLE) ||
				defined('NS_BLOG_ARTICLE_TALK') && $rcNamespace == NS_BLOG_ARTICLE_TALK ) {
				$messageKey = 'article-comments-rc-blog-comment';
			} else {
				$messageKey = 'article-comments-rc-comment';
		}
			$articleId = $title->getArticleId();
			$articlelink = wfMsgExt($messageKey, array('parseinline'), $title->getFullURL("permalink=$articleId#comm-$articleId"),  $titleMainArticle->getText());
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
