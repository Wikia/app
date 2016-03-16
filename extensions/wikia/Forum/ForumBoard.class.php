<?php

// TODO: move this to wall class php ??

/**
 * Forum Board
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumBoard extends Wall {
	const CACHE_VERSION = 1;
	const FORUM_BOARD_INFO = 'forum_board_info';

	/**
	 * @return ForumBoard
	 */
	static public function getEmpty() {
		return new ForumBoard();
	}

	/**
	 * get board info: the number of threads, the number of posts, the username and timestamp of the last post
	 * @return ForumBoardInfo $info
	 */
	public function getBoardInfo() {
		wfProfileIn( __METHOD__ );

		$memKey = self::getBoardInfoCacheKey( $this->getId() );
		$info = $this->wg->Memc->get( $memKey );
		wfProfileOut( __METHOD__ );
		return empty( $info ) ? $this->getBoardInfoFromMaster() : new ForumBoardInfo( $info );
	}

	/**
	 * get number of active threads (exclude deleted and removed threads)
	 * @return integer activeThreads
	 */
	public function getTotalActiveThreads( $relatedPageId = 0, $db = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $relatedPageId ) ) {
			$memKey = wfMemcKey( 'forum_board_active_threads', $this->getId() );

			if ( $db == DB_SLAVE ) {
				$activeThreads = $this->wg->Memc->get( $memKey );
			}
		}

		if ( !empty( $relatedPageId ) || $activeThreads === false ) {
			$db = wfGetDB( $db );

			if ( !empty( $relatedPageId ) ) {
				$filter = "comment_id in (select comment_id from wall_related_pages where page_id = {$relatedPageId})";
			} else {
				$filter = 'parent_page_id =' . ( (int)$this->getId() );
			}

			$activeThreads = $db->selectField(
				[ 'comments_index' ],
				[ 'count(*) cnt' ],
				[ $filter,
					'parent_comment_id' => 0,
					'deleted' => 0,
					'removed' => 0,
					'last_touched > curdate() - interval 7 day',
				],
				__METHOD__
			);

			$activeThreads = intval( $activeThreads );
			if ( empty( $relatedPageId ) ) {
				$this->wg->Memc->set( $memKey, $activeThreads, 60 * 60 * 12 );
			}
		}

		wfProfileOut( __METHOD__ );

		return $activeThreads;
	}

	private function getBoardInfoFromMaster() {
		$db = wfGetDB( DB_MASTER );
		$row = $db->selectRow(
			[ 'comments_index' ],
			[ 'count(if(parent_comment_id=0,1,null)) threads, count(*) posts, max(first_rev_id) rev_id' ],
			[
				'parent_page_id' => $this->getId(),
				'archived' => 0,
				'deleted' => 0,
				'removed' => 0
			],
			__METHOD__
		);

		$forumBoardInfo = new ForumBoardInfo();

		if ( $row ) {
			$forumBoardInfo->setPostCount( $row->posts );
			$forumBoardInfo->setThreadCount( $row->threads );
			$forumBoardInfo->setLastPost( $this->getLastPost( $row->rev_id ) );
		}
		$forumBoardInfo->setId( $this->getTitle()->getArticleID() );
		$forumBoardInfo->setName( $this->getTitle()->getText() );
		$forumBoardInfo->setUrl( $this->getTitle()->getFullURL() );
		$forumBoardInfo->setDescription( $this->getDescriptionWithoutTemplates() );
		$memKey = self::getBoardInfoCacheKey( $this->getId() );
		$this->wg->Memc->set( $memKey, $forumBoardInfo->toArray(), 60 * 60 * 12 );
		return $forumBoardInfo;
	}

	/**
	 * clear cache for board info
	 */
	public function clearCacheBoardInfo() {
		$this->getBoardInfoFromMaster();
		$this->getTotalActiveThreads( DB_MASTER );

		$title = Title::newFromID( $this->getId() );
		if ( $title instanceof Title ) {
			$title->purgeSquid();
		}
	}

	private function getLastPost( $rev_id ) {
		$postInfo = null;
		$revision = Revision::newFromId( $rev_id );
		if ( $revision instanceof Revision ) {
			$username = $revision->getRawUser() == 0 ? wfMsg( 'oasis-anon-user' ) : $revision->getRawUserText();
			$ns = $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK;
			$userprofile = Title::makeTitle( $ns, $username )->getFullURL();
			$postInfo = new ForumPostInfo();
			$postInfo->setUsername($username);
			$postInfo->setUserProfile($userprofile);
			$postInfo->setTimestamp($revision->getTimestamp());
		}
		return $postInfo;
	}

	/**
	 * @param $forumBoardId integer
	 * @return string cache key for getBoardInfo()
	 */
	private static function getBoardInfoCacheKey( $forumBoardId ) {
		return wfMemcKey( self::FORUM_BOARD_INFO, self::CACHE_VERSION, $forumBoardId );
	}
}
