<?php

/**
 * ArticleCommentList is a listing, basically it's an array of comments
 */
class ArticleCommentList {
	const CACHE_VERSION = 'v2';

	/** @var Title */
	private $mTitle;
	private $mText;
	private $mCommentId = null;
	private $mComments = false;

	/** @var bool|array */
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
		$this->setMaxPerPage( $wgArticleCommentsMaxPerPage );
	}

	public function setMaxPerPage( $val ) {
 		$this->mMaxPerPage = $val;
	}

	public function setText( $text ) {
		$this->mText = $text;
	}

	/**
	 * setId -- set mCommentId it will limit select to only this comment
	 *
	 * @param int $id
	 */
	public function setId( $id ) {
		$this->mCommentId = $id;
	}

	/**
	 * setTitle -- standard accessor/setter
	 *
	 * @param Title $title
	 */
	public function setTitle( Title $title ) {
		$this->mTitle = $title;
	}

	/**
	 * getTitle -- standard accessor/getter
	 *
	 * @return Title
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * getCountAll -- count 1st level comments
	 */
	public function getCountAll() {
		if ( $this->mCountAll === false ) {
			$this->getCommentList( false );
		}
		return $this->mCountAll;
	}

	/**
	 * getCountAllNested -- count all comments - including nested
	 */
	public function getCountAllNested() {
		if ( $this->mCountAllNested === false ) {
			$this->getCommentList( false );
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

	public function getCommentPages( $master = true, $page = 1 ) {
		global $wgRequest;

		// initialize list of comment ids if not done already
		if ( $this->mCommentsAll === false ) {
			$this->getCommentList( $master );
		}
		$showall = $wgRequest->getText( 'showall', false );

		// pagination
		if ( $page !== false && ( $showall != 1 || $this->getCountAllNested() > 200 /*see RT#64641*/ ) ) {
			$this->mComments = array_slice( $this->mCommentsAll, ( $page - 1 ) * $this->mMaxPerPage, $this->mMaxPerPage, true );
		} else {
			$this->mComments = $this->mCommentsAll;
		}

		$this->mCount = count( $this->mComments );
		$this->mCountNested = 0;

		// grab list of required article IDs
		$commentsQueue = [ ];
		foreach ( $this->mComments as $id => &$levels ) {
			if ( isset( $levels['level1'] ) ) {
				$commentsQueue[] = $id;
			}
			if ( isset( $levels['level2'] ) ) {
				$commentsQueue = array_merge( $commentsQueue, array_keys( $levels['level2'] ) );
			}
		}

		$titles = Title::newFromIds( $commentsQueue );

		$comments = [ ];
		foreach ( $titles as $title ) {
			$comments[$title->getArticleID()] = ArticleComment::newFromTitle( $title );
		}

		// grab article contents for each comment
		foreach ( $this->mComments as $id => &$levels ) {
			if ( isset( $levels['level1'] ) ) {
				$levels['level1'] = $comments[$id];
				$this->mCountNested++;
			}
			if ( isset( $levels['level2'] ) ) {
				foreach ( $levels['level2'] as $subid => &$sublevel ) {
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

		$action = $wgRequest->getText( 'action', false );
        $title = $this->getTitle();
		$memckey = self::getCacheKey( $title );

		/**
		 * skip cache if purging or using master connection or in case of single comment
		 */
		if ( $action != 'purge' && !$master && empty( $this->mCommentId ) ) {
			$this->mCommentsAll = $wgMemc->get( $memckey );
		}

		if ( empty( $this->mCommentsAll ) ) {
			$pages = [ ];
			$subpages = [ ];
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			$table = [ 'page' ];
			$vars = [ 'page_id', 'page_title' ];
			$conds = $this->getQueryWhere( $dbr );
			$options = [ 'ORDER BY' => 'page_id DESC' ];
			$join_conds = [ ];

			if ( !empty( $wgArticleCommentsEnableVoting ) ) {
				// add votes to the result set
				$table[] = 'page_vote';
				$vars[] = 'count(vote) as vote_cnt';
				$options['GROUP BY'] = 'page_id, page_title';
				$join_conds['page_vote'] = [ 'LEFT JOIN', 'page_id = article_id' ];

				// a placeholder for 3 top voted answers
				$top3 = [ ];
			}
			$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options, $join_conds );

			$helperArray = [ ];
			while ( $row = $dbr->fetchObject( $res ) ) {
				$parts = ArticleComment::explode( $row->page_title );
				$p0 = $parts['partsStripped'][0];

				if ( count( $parts['partsStripped'] ) == 2 ) {
					// push comment replies aside, we'll merge them later
					$subpages[$p0][$row->page_id] = $row->page_id;
				} else {
					// map title to page_id
					$helperArray[$p0] = $row->page_id;

					$pages[$row->page_id]['level1'] = $row->page_id;

					if ( !empty( $wgArticleCommentsEnableVoting ) ) {
						// check if the answer is in top 3
						for ( $i = 0; $i < 3; $i++ ) {
							if ( !isset( $top3[$i] ) ) {
								$top3[$i] = [ 'id' => $row->page_id, 'votes' => $row->vote_cnt ];
								break;
							}
							if ( $top3[$i]['votes'] > $row->vote_cnt ) {
								continue;
							}
							if ( $top3[$i]['votes'] == $row->vote_cnt && $top3[$i]['id'] > $row->page_id ) {
								continue;
							}
							$top3[$i + 1] = $top3[$i];
							$top3[$i] = [ 'id' => $row->page_id, 'votes' => $row->vote_cnt ];
							break;
						}
					}
				}
			}
			// attach replies to comments
			foreach ( $subpages as $p0 => $level2 ) {
				if ( !empty( $helperArray[$p0] ) ) {
					$idx = $helperArray[$p0];
					$pages[$idx]['level2'] = array_reverse( $level2, true );
				} else {
				// if its empty it's an error in our database
				// someone removed a parent and left its children
				// or someone removed parent and children and
				// restored children or a child without restoring parent
				// --nAndy
				}
			}

			if ( !empty( $wgArticleCommentsEnableVoting ) ) {
				// move 3 most voted answers to the top
				$newPages = [ ];
				for ( $i = 0; $i < 3; $i++ ) {
					if ( isset( $top3[$i] ) ) {
						$newPages[$top3[$i]['id']] = $pages[$top3[$i]['id']];
						$pages[$top3[$i]['id']] = null;
					}
				}
				foreach ( $pages as $id => $val ) {
					if ( $val ) {
						$newPages[$id] = $val;
					}
				}
				$pages = $newPages;
			}

			$dbr->freeResult( $res );
			$this->mCommentsAll = $pages;

			if ( empty( $this->mCommentId ) ) {
				$wgMemc->set( $memckey, $this->mCommentsAll, 3600 );
			}
		}

		$this->mCountAll = count( $this->mCommentsAll );
		// Set our nested count here RT#85503
		$this->mCountAllNested = 0;
		foreach ( $this->mCommentsAll as $comment ) {
			$this->mCountAllNested++;
			if ( isset( $comment['level2'] ) ) {
				$this->mCountAllNested += count( $comment['level2'] );
			}
		}

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
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			[ 'page' ],
			[ 'page_id', 'page_title' ],
			$this->getQueryWhere( $dbr ),
			__METHOD__
		);

		$pages = [ ];
		while ( $row = $dbr->fetchObject( $res ) ) {
			$pages[$row->page_id] = ArticleComment::newFromId( $row->page_id );
		}

		$dbr->freeResult( $res );
		return $pages;
	}

	public function getQueryWhere( DatabaseBase $dbr ) {
		$like = "page_title" . $dbr->buildLike( sprintf( "%s/%s", $this->mText, ARTICLECOMMENT_PREFIX ), $dbr->anyString() );
		$namspace = MWNamespace::getTalk( $this->getTitle()->getNamespace() );

		if ( empty( $this->mCommentId ) ) {
			return [ $like, 'page_namespace' => $namspace ];
		}

		$ac = ArticleComment::newFromId( $this->mCommentId );
		$parent = $ac->getTopParent();
		$title = $ac->getTitle();
		if ( empty( $parent ) && ( !empty( $title ) ) ) {
			$parent = $title->getDBkey();
		}
		$like = "page_title" . $dbr->buildLike( $parent, $dbr->anyString() );
		return [ $like, 'page_namespace' => $namspace ];
	}

	private function getRemovedCommentPages( $oTitle ) {
		$pages = [ ];

		if ( $oTitle instanceof Title ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				[ 'archive' ],
				[ 'ar_page_id', 'ar_title' ],
				[
					'ar_namespace' => MWNamespace::getTalk( $this->getTitle()->getNamespace() ),
					"ar_title" . $dbr->buildLike( sprintf( "%s/%s", $oTitle->getDBkey(), ARTICLECOMMENT_PREFIX ), $dbr->anyString() )
				],
				__METHOD__,
				[ 'ORDER BY' => 'ar_page_id ASC' ]
			);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->ar_page_id ] = [
					'title' => $row->ar_title,
					'nspace' => MWNamespace::getTalk( $this->getTitle()->getNamespace() )
				];
			}
			$dbr->freeResult( $res );
		}

		return $pages;
	}

	/**
	 * getData -- return raw data for displaying commentList
	 *
	 * @access public
	 *
	 * @return array data for comments list
	 */
	public function getData( $page = 1 ) {
		$wg = F::app()->wg;

		// $isSysop = in_array('sysop', $groups) || in_array('staff', $groups);
		
		$isBlocked = $wg->User->isBlocked();

		$isReadOnly = wfReadOnly();
		// $showall = $wgRequest->getText( 'showall', false );

		// default to using slave. comments are posted with ajax which hits master db
		// $commentList = $this->getCommentList(false);
		$countComments = $this->getCountAll();
		$countCommentsNested = $this->getCountAllNested();

		$countPages = ceil( $countComments / $this->mMaxPerPage );
		$pageRequest = (int) $page;
		$page = 1;
		if ( $pageRequest <= $countPages && $pageRequest > 0 ) {
			$page = $pageRequest;
		}
		$comments = $this->getCommentPages( false, $page );
		$this->preloadFirstRevId( $comments );
		$pagination = $this->doPagination( $countComments, count( $comments ), $page );

		return [
			'avatar' => AvatarService::renderAvatar( $wg->User->getName(), 50 ),
			'userurl' => AvatarService::getUrl( $wg->User->getName() ),
			'commentListRaw' => $comments,
			'commentingAllowed' => ArticleComment::userCanCommentOn( $this->mTitle ),
			'commentsPerPage' => $this->mMaxPerPage,
			'countComments' => $countComments,
			'countCommentsNested' => $countCommentsNested,
			'isAnon' => $wg->User->isAnon(),
			'isBlocked' => $isBlocked,
			'isReadOnly' => $isReadOnly,
			'page' => $page,
			'pagination' => $pagination,
			'reason' => $isBlocked ? $this->blockedPage() : '',
			'stylePath' => $wg->StylePath,
			'title' => $this->mTitle,
		];
	} // end getData();

	/**
	 * doPagination -- return HTML code for pagination
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	function doPagination( $countAll, $countComments, $activePage = 1, $title = null ) {
		global $wgTitle;

		$maxDisplayedPages = 6;
		$pagination = '';

		if ( $title == null ) {
			$title = $wgTitle;
		}

		if ( empty( $title ) ) {
			return "";
		}

		if ( $countAll > $countComments ) {
			$numberOfPages = ceil( $countAll / $this->mMaxPerPage );

			// previous
			if ( $activePage > 1 ) {
				$pagination .= '<a href="' . $title->getLinkUrl( 'page=' . ( max( $activePage - 1, 1 ) ) ) . '#article-comments" id="article-comments-pagination-link-prev" class="article-comments-pagination-link dark_text_1" page="' . ( max( $activePage - 1, 1 ) ) . '">' . wfMsg( 'article-comments-prev-page' ) . '</a>';
			}

			// first page - always visible
			$pagination .= '<a href="' . $title->getFullUrl( 'page=1' ) . '#article-comments" id="article-comments-pagination-link-1" class="article-comments-pagination-link dark_text_1' . ( $activePage == 1 ? ' article-comments-pagination-link-active accent' : '' ) . '" page="1">1</a>';

			// calculate the 2nd and the last but one pages to display
			$firstVisiblePage = max( 2, min( $numberOfPages - $maxDisplayedPages + 1, $activePage - $maxDisplayedPages + 4 ) );
			$lastVisiblePage = min( $numberOfPages - 1, $maxDisplayedPages + $firstVisiblePage - 2 );

			// add spacer when there is a gap between 1st and 2nd visible page
			if ( $firstVisiblePage > 2 ) {
				$pagination .= wfMessage( 'article-comments-page-spacer' )->escaped();
			}

			// generate links
			for ( $i = $firstVisiblePage; $i <= $lastVisiblePage; $i++ ) {
				$pagination .= '<a href="' . $title->getFullUrl( 'page=' . $i ) . '#article-comments" id="article-comments-pagination-link-' . $i . '" class="article-comments-pagination-link dark_text_1' . ( $i == $activePage ? ' article-comments-pagination-link-active accent' : '' ) . '" page="' . $i . '">' . $i . '</a>';
			}

			// add spacer when there is a gap between 2 last links
			if ( $numberOfPages - $lastVisiblePage > 1 ) {
				$pagination .= wfMessage( 'article-comments-page-spacer' )->escaped();
			}

			// add last page - always visible
			$pagination .= '<a href="' . $title->getFullUrl( 'page=' . $numberOfPages ) . '#article-comments" id="article-comments-pagination-link-' . $numberOfPages . '" class="article-comments-pagination-link dark_text_1' . ( $numberOfPages == $activePage ? ' article-comments-pagination-link-active accent' : '' ) . '" page="' . $numberOfPages . '">' . $numberOfPages . '</a>';

			// next
			if ( $activePage < $numberOfPages ) {
				$pagination .= '<a href="' . $title->getFullUrl( 'page=' . ( min( $activePage + 1, $numberOfPages ) ) ) . '#article-comments" id="article-comments-pagination-link-next" class="article-comments-pagination-link dark_text_1" page="' . ( min( $activePage + 1, $numberOfPages ) ) . '">' . wfMsg( 'article-comments-next-page' ) . '</a>';
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
		/** @var Language $wgLang */
		global $wgUser, $wgLang, $wgContLang, $wgRequest;

		// macbre: prevent fatals in code below
		if ( empty( $wgUser->mBlock ) ) {
			return '';
		}

		list( $blockerName, $reason, $ip, $blockid, $blockTimestamp, $blockExpiry, $intended, $isGlobal ) = [
			User::whoIs( $wgUser->blockedBy() ),
			$wgUser->blockedFor() ? $wgUser->blockedFor() : wfMessage( 'blockednoreason' )->text(),
			$wgRequest->getIP(),
			$wgUser->getBlockId(),
			$wgLang->timeanddate( wfTimestamp( TS_MW, $wgUser->mBlock->mTimestamp ), true ),
			$wgUser->mBlock->mExpiry,
			$wgUser->mBlock->mAddress,
			$wgUser->mBlockedGlobally
		];

		// Hide username of blocker if this is a global block (see lines 2112-2129 of includes/Title.php)
		if ( $isGlobal ) {
			$blocker = User::newFromName( $blockerName );
			if ( $blocker instanceof User ) {
				// user groups to be displayed instead of user name
				$groups = [
					'staff',
					'vstf',
				];
				$blockerGroups = $blocker->getEffectiveGroups();

				foreach ( $groups as $group ) {
					if ( in_array( $group, $blockerGroups ) ) {
						$blockerLink = wfMessage( "group-$group" )->plain();
					}
				}
			}
		} else {
			$blockerLink = '[[' . $wgContLang->getNsText( NS_USER ) . ":{$blockerName}|{$blockerName}]]";
		}

		if ( $blockExpiry == 'infinity' ) {
			$scBlockExpiryOptions = wfMessage( 'ipboptions' )->text();
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

		return wfMessage( $msg, $blockerLink, $reason, $ip, $blockerName, $blockid, $blockExpiry, $intended, $blockTimestamp )->parse();
	}

	/**
	 * remove lising from cache and mark title for squid as invalid
	 */
	public function purge() {
		self::purgeCache( $this->mTitle );
	}

	protected function preloadFirstRevId( $comments ) {
		$articles = [ ];
		foreach ( $comments as $id => $levels ) {
			if ( isset( $levels['level1'] ) ) {
				if ( !empty( $levels['level1'] ) ) {
					$articles[$levels['level1']->getTitle()->getArticleID()] = $levels['level1'];
				}
			}
			if ( isset( $levels['level2'] ) ) {
				foreach ( $levels['level2'] as $nested ) {
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
				[ 'rev_page', 'min(rev_id) AS min_rev_id' ],
				[ 'rev_page' => array_keys( $articles ) ],
				__METHOD__,
				[
					'GROUP BY' => 'rev_page',
				]
			);

			/** @var stdClass $row */
			foreach ( $res as $row ) {
				if ( isset( $articles[$row->rev_page] ) ) {
					$articles[$row->rev_page]->setFirstRevId( $row->min_rev_id, DB_SLAVE );
					unset( $articles[$row->rev_page] );
				}
			}

			/** @var ArticleComment $comment */
			foreach ( $articles as $id => $comment ) {
				$comment->setFirstRevId( false, DB_SLAVE );
			}
		}
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
		$title = $wikiPage->getTitle();

		if ( empty( self::$mArticlesToDelete ) ) {
			$listing = ArticleCommentList::newFromTitle( $title );
			self::$mArticlesToDelete = $listing->getAllCommentPages();
		}

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
	 * @param Title $title
	 */
	static public function purgeCache( Title $title ) {
		global $wgMemc;

		$wgMemc->delete( self::getCacheKey( $title ) );
		$title->invalidateCache();
		$title->purgeSquid();

		Hooks::run( 'ArticleCommentListPurgeComplete', [ $title ] );
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
		$title = $wikiPage->getTitle();

		if ( !MWNamespace::isTalk( $title->getNamespace() ) || !ArticleComment::isTitleComment( $title ) ) {
			if ( empty( self::$mArticlesToDelete ) ) {
				return true;
			}
		}

		if ( class_exists( 'WallHelper' ) && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			return true;
		}

		// watch out for recursion
		if ( self::$mDeletionInProgress ) {
			return true;
		}
		self::$mDeletionInProgress = true;

		// redirect to article/blog after deleting a comment (or whole article/blog)
		$parts = ArticleComment::explode( $title->getText() );
		$parentTitle = Title::newFromText( $parts['title'], MWNamespace::getSubject( $title->getNamespace() ) );
		$wgOut->redirect( $parentTitle->getFullUrl() );

		// do not use $reason as it contains content of parent article/comment - not current ones that we delete in a loop

		$deleteReason = wfMessage( 'article-comments-delete-reason' )->inContentLanguage()->escaped();

		// we have comment 1st level - checked in articleDelete() (or 2nd - so do nothing)
		if ( is_array( self::$mArticlesToDelete ) ) {
			$mDelete = 'live';
			if ( isset( $wgMaxCommentsToDelete ) && ( count( self::$mArticlesToDelete ) > $wgMaxCommentsToDelete ) ) {
				if ( !empty( $wgEnableMultiDeleteExt ) ) {
					$mDelete = 'task';
				}
			}

			if ( $mDelete == 'live' ) {
				$irc_backup = $wgRC2UDPEnabled;	// backup
				$wgRC2UDPEnabled = false; // turn off
				foreach ( self::$mArticlesToDelete as $page_id => $oComment ) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						$oComment = ArticleComment::newFromTitle( $oCommentTitle );
						$oComment->doDeleteComment( $deleteReason );
					}
				}

				$wgRC2UDPEnabled = $irc_backup; // restore to whatever it was
				$listing = ArticleCommentList::newFromTitle( $parentTitle );
				$listing->purge();
			} else {
				$taskParams = [
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
				];


				/** @var ArticleComment $oComment */
				foreach ( self::$mArticlesToDelete as $oComment ) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						/* @var $oCommentTitle Title */
						$data = $taskParams;
						$data['page'] = $oCommentTitle->getFullText();

						$task = new \Wikia\Tasks\Tasks\MultiTask();
						$task->call( 'delete', $data );
						$submit_id = $task->queue();
					}
				}
			}
		}

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
	static public function undeleteComments( Title &$oTitle, $revision, $old_page_id ) {
		global $wgRC2UDPEnabled;

		if ( $oTitle instanceof Title ) {
			$new_page_id = $oTitle->getArticleId();
			$listing = ArticleCommentList::newFromTitle( $oTitle );
			$pagesToRecover = $listing->getRemovedCommentPages( $oTitle );
			if ( !empty( $pagesToRecover ) && is_array( $pagesToRecover ) ) {
				$irc_backup = $wgRC2UDPEnabled;	// backup
				$wgRC2UDPEnabled = false; // turn off
				foreach ( $pagesToRecover as $page_id => $page_value ) {
					$oCommentTitle = Title::makeTitleSafe( $page_value['nspace'], $page_value['title'] );
					if ( $oCommentTitle instanceof Title ) {
						$archive = new PageArchive( $oCommentTitle );
						$ok = $archive->undelete( '', wfMessage( 'article-comments-undeleted-comment', $new_page_id )->escaped() );

						if ( !is_array( $ok ) ) {
							Wikia\Logger\WikiaLogger::instance()->error(
								__METHOD__ . ' - cannot restore comment',
								[
									'exception' => new Exception(),
									'page_id' => (string) $page_id,
									'page_title' => $page_value['title']
								]
							);
						}
					}
				}
				$wgRC2UDPEnabled = $irc_backup; // restore to whatever it was
			}
		}

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

		if ( empty( $wgEnableGroupedArticleCommentsRC ) ) {
			return true;
		}

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		if ( MWNamespace::isTalk( $namespace ) && ArticleComment::isTitleComment( $oTitle ) ) {
			$parts = ArticleComment::explode( $oTitle->getText() );
			if ( $parts['title'] != '' ) {
				$currentName = 'ArticleComments' . $parts['title'];
			}
		}

		return true;
	}

	/**
	 * Hook
	 *
	 * @param ChangesList $oChangeList -- instance of ChangeList class
	 * @param String $header -- current value of RC key
	 * @param array[RCCacheEntry] $oRCCacheEntryArray
	 * @param boolean $changeRecentChangesHeader a flag saying Wikia's hook if we want to change header or not
	 * @param Title $oTitle
	 * @param string $headerTitle string which will be put as a header for RecentChanges block
	 *
	 * @return true -- because it's a hook
	 *
	 * @throws MWException
	 */
	static public function setHeaderBlockGroup( ChangesList $oChangeList, $header, array $oRCCacheEntryArray, &$changeRecentChangesHeader, Title $oTitle, &$headerTitle ) {
		global $wgEnableGroupedArticleCommentsRC;
		$namespace = $oTitle->getNamespace();

		if ( empty( $wgEnableGroupedArticleCommentsRC ) ) {
			return true;
		}

		if ( !is_null( $oTitle )
			&& MWNamespace::isTalk( $namespace )
			&& ArticleComment::isTitleComment( $oTitle )
		) {
			$parts = ArticleComment::explode( $oTitle->getFullText() );

			if ( $parts['title'] != '' ) {
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

						$headerTitle = $oChangeList->msg( $messageKey, $title->getPrefixedText() )->parse();
					} else {
						Wikia::log( __METHOD__, '2', 'Title does not exist: ' . $text, true );
					}
				} else {
					Wikia::log( __METHOD__, '1', 'Title does not exist: ' . $parts['title'], true );
				}


			}
		}

		return true;
	}

	/**
	 * formatList
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function formatList( $comments ) {
		$template = new EasyTemplate( dirname( __FILE__ ) . '/../templates/' );
		$template->set_vars( [
			'comments'  => $comments
		] );
		return $template->render( 'comment-list' );
	}

	/**
	 * @deprecated Don't use it for Oasis, still needed for non-Oasis skins
	 *
	 * @return String HTML text with rendered comments section
	 */
	public function render() {
		return F::app()->renderView( 'ArticleComments', 'Index' );
 	}

	/**
	 * Static entry point for hook
	 *
	 * @param Title $title
	 * @param Article $article
	 *
	 * @return bool
	 */
	static public function ArticleFromTitle( Title &$title, &$article ) {
		// Don't bother checking for redirects if we're not loading this article for the current request
		if ( !self::isTitleForCurrentRequest( $title ) ) {
			return true;
		}

		// Only handle comments
		if ( !MWNamespace::isTalk( $title->getNamespace() ) || !ArticleComment::isTitleComment( $title ) ) {
			return true;
		}

		// See if this is a special request that can't be redirected
		if ( !self::canSetRedirect() ) {
			return true;
		}

		$parts = ArticleComment::explode( $title->getText() );
		$redirectTitle = Title::newFromText( $parts['title'], MWNamespace::getSubject( $title->getNamespace() ) );
		if ( empty( $redirectTitle ) ) {
			return true;
		}

		$query = [];
		$commentId = $title->getArticleID();
		$permalink = F::app()->wg->Request->getInt( 'permalink', 0 );

		// Use comment ID if available - https://wikia.fogbugz.com/f/cases/11179
		if ( $commentId !== 0 ) {
			$permalink = $commentId;
		}

		if ( $permalink ) {
			$redirectTitle->setFragment( "#comm-$permalink" );
			$page = self::getPageForComment( $redirectTitle, $permalink );
			if ( $page > 1 ) {
				$query = [ 'page' => $page ];
			}
		}

		F::app()->wg->Out->redirect( $redirectTitle->getFullUrl( $query ) );

		return true;
	}

	/**
	 * Returns whether the title we're working with now is the same as the title for the
	 * request itself.  Sometimes, (e.g. the file page when it loads related articles) code will
	 * load other articles, and we don't want to redirect in those cases.
	 *
	 * @param Title $title
	 *
	 * @return bool
	 */
	static private function isTitleForCurrentRequest( Title $title ) {
		if ( empty( F::app()->wg->Title ) ) {
			return false;
		}

		if ( $title->getPrefixedDBkey() != F::app()->wg->Title->getPrefixedDBkey() ) {
			return false;
		}

		return true;
	}

	static private function canSetRedirect() {
		$req = F::app()->wg->Request;
		$redirect = $req->getText( 'redirect', false );
		$diff = $req->getText( 'diff', '' );
		$oldId = $req->getText( 'oldid', '' );
		$action = $req->getText( 'action', '' );

		return (
			( $redirect != 'no' ) &&
			empty( $diff ) &&
			empty( $oldId ) &&
			( $action != 'history' ) &&
			( $action != 'delete' )
		);
	}

	static private function getPageForComment( $title, $id ) {
		$page = 0;

		$articleComment = ArticleCommentList::newFromTitle( $title );
		$commentList = $articleComment->getCommentList( false );
		$topLevel = array_keys( $commentList );
		$found = array_search( $id, $topLevel );
		if ( $found !== false ) {
			$page = ceil( ( $found + 1 ) / $articleComment->mMaxPerPage );
		} else {
			// not found in top level comments so we have to search 2nd level comments
			$index = 0;
			foreach ( $commentList as $comment ) {
				$index ++;
				if ( isset( $comment['level2'] ) ) {
					$found = array_search( $id, $comment['level2'] );
					if ( $found !== false ) {
						$page = ceil ( $index / $articleComment->mMaxPerPage  );
					}
				}
			}
		}

		return $page;
	}

	/**
	 * Static entry point for hook
	 *
	 * @param string $SimpleCaptcha
	 * @param EditPage $editPage
	 * @param string $newtext
	 * @param int $section
	 * @param $merged
	 * @param bool $result
	 *
	 * @return bool
	 */
	static public function onConfirmEdit( &$SimpleCaptcha, &$editPage, $newtext, $section, $merged, &$result ) {
		$title = $editPage->getArticle()->getTitle();
		if ( MWNamespace::isTalk( $title->getNamespace() ) && ArticleComment::isTitleComment( $title ) ) {
			$result = true;	// omit captcha
			return false;
		}
		return true;
	}

	/**
	 * TODO: Document what the parameters are.
	 *
	 * @param ChangesList $changeList
	 * @param $articlelink
	 * @param $s
	 * @param RecentChange $rc
	 * @param $unpatrolled
	 * @param $watched
	 *
	 * @return bool
	 * @throws MWException
	 */
	static function ChangesListInsertArticleLink( ChangesList $changeList, &$articlelink, &$s, RecentChange $rc, $unpatrolled, $watched ) {
		$rcTitle = $rc->getAttribute( 'rc_title' );
		$rcNamespace = $rc->getAttribute( 'rc_namespace' );
		$title = Title::newFromText( $rcTitle, $rcNamespace );

		if ( MWNamespace::isTalk( $rcNamespace ) && ArticleComment::isTitleComment( $title ) ) {
			$parts = ArticleComment::explode( $rcTitle );

			$titleMainArticle = Title::newFromText( $parts['title'], MWNamespace::getSubject( $rcNamespace ) );

			// fb#15143
			if ( $titleMainArticle instanceof Title ) {
				if ( ArticleComment::isBlog() ) {
					$messageKey = 'article-comments-rc-blog-comment';
				} else {
					$messageKey = 'article-comments-rc-comment';
				}

				$articleId = $title->getArticleId();
				$articlelink = $changeList->msg(
					$messageKey,
					$title->getFullURL( "permalink=$articleId#comm-$articleId" ),
					$titleMainArticle->getText()
				)->parse();
			} else {
				// it should never happened because $rcTitle is never empty,
				// ArticleComment::explode() always returns an array with not-empty 'title' element,
				// (both files: ArticleComments/classes/ArticleComments.class.php
				// and WallArticleComment/classes/ArticleComments.class.php have
				// the same definition of explode() method)
				// and static constructor newFromText() should create a Title instance for $parts['title']
				Wikia\Logger\WikiaLogger::instance()->error(
					__METHOD__ . ' - WALL_ARTICLE_COMMENT_ERROR: no main article title',
					[
						'exception' => new Exception(),
						'namespace' => $rcNamespace,
						'parts' => print_r( $parts, true )
					]
				);
			}
		}

		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $oTitle -- instance of Title class
	 * @param User    $oUser    -- current user
	 * @param string  $reason  -- undeleting reason
	 *
	 * @return true -- because it's hook
	 */
	static public function undeleteComplete( $oTitle, $oUser, $reason ) {
		if ( $oTitle instanceof Title ) {
			if ( in_array( $oTitle->getNamespace(), [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ] ) ) {
				$aProps = $oTitle->aProps;
				$pageId = $oTitle->getArticleId();
				if ( !empty( $aProps ) ) {
					BlogArticle::setProps( $pageId, $aProps );
				}
			}
		}
		return true;
	}
}
