<?php

/**
 * Class VoteHelper
 */
class VoteHelper {
	protected $userId;
	protected $pageId;
	protected $userIP = '';

	function __construct( User $user = null, $pageId = 0 ) {
		global $wgRequest;

		$this->userIP = $wgRequest->getIP();
		$this->userId = $user->getId();
		$this->pageId = $pageId;
	}

	// TODO: caching ?
	function getVotersList( $from = 0, $count = 50 ) {
		$dbr = wfGetDB( DB_SLAVE );
		// TODO: abstract the query
		$res = $dbr->select(
			[ 'page_vote', 'ipblocks' ],
			[ 'user_id' ],
			[
				"ifnull(ipb_expiry, 0) != 'infinity'",
				'ifnull(ipb_expiry, 0) < ' . wfTimestamp( TS_MW ),
				'article_id' => $this->pageId,
			],
			__METHOD__,
			[
				'OFFSET' => $from,
				'LIMIT' => $count,
				'ORDER BY' => 'time desc'
			],
			[ 'ipblocks'  => [ 'LEFT JOIN', 'user_id = ipb_user' ] ]
		);

		$out = array();

		while ( $row = $res->fetchObject() ) {
			$out[] = $row->user_id;
		}

		$this->getCache()->delete( $this->getPageCacheKey() );

		$this->getVoteCount();

		return $out;
	}

	function addVote( $score = 1 ) {
		if ( $this->isVoted() ) {
			return false;
		}
		$dbr = wfGetDB( DB_MASTER );

		$values = [
			'article_id' => $this->pageId,
			'ip' => $this->userIP,
			'user_id' => $this->userId,
			'unique_id' => md5( $this->userIP ), // Backward compatibility
			'time' => wfTimestampNow(),
			'vote' => $score,
		];

		$dbr->insert(
			'page_vote',
			$values,
			__METHOD__
		);

		$cache = $this->getCache();
		$cache->set( $this->getUserCacheKey(), 'Y' );
		$this->getVoteCount( DB_MASTER );

		return true;
	}

	function removeVote() {
		$dbr = wfGetDB( DB_MASTER );
		$dbr->delete(
			'page_vote',
			$this->getUserWhere(),
			__METHOD__
		);

		$cache = $this->getCache();
		$cache->set( $this->getUserCacheKey(), 'N' );
		$this->getVoteCount( DB_MASTER );
	}

	function getVoteCount( $db = DB_SLAVE ) {
		$cache = $this->getCache();
		if ( $db != DB_MASTER ) {
			$cacheVal = $cache->get( $this->getPageCacheKey() );
			if ( $cacheVal !== false ) {
				return $cacheVal;
			}
		}

		$dbr = wfGetDB( $db );
		// TODO: abstract the query
		$row = $dbr->selectRow(
			[ 'page_vote', 'ipblocks' ],
			[ 'count(*) as cnt' ],
			[
				"ifnull(ipb_expiry, 0) != 'infinity'",
				'ifnull(ipb_expiry, 0) < ' . wfTimestamp( TS_MW ),
				'article_id' => $this->pageId,
			],
			__METHOD__,
			[
				'ORDER BY' => 'time desc'
			],
			[
				'ipblocks'  => [ 'LEFT JOIN', 'user_id = ipb_user' ]
			]
		);

		$cache->set( $this->getPageCacheKey(), $row->cnt );

		return (int) $row->cnt;
	}

	// TODO: move this to background tasks, for now just invalidation of last 100 votes
	function invalidateUser() {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			[ 'page_vote' ],
			[ 'article_id' ],
			[ 'user_id' => $this->userId ],
			__METHOD__,
			[
				'LIMIT' => 100,
				'ORDER BY' => 'time desc'
			]
		);

		$cache = $this->getCache();
		while ( $row = $res->fetchObject() ) {
			$key = $this->getPageCacheKey( $row->article_id );
			$cache->delete( $key );
		}

		return true;
	}

	/**
	 * Whether this user has voted on the forum thread or not.  For anonymous
	 * users, this always returns false.
	 *
	 * @param int $db
	 *
	 * @return bool
	 */
	public function isVoted( $db = DB_SLAVE ) {
		if ( $this->userId == 0 ) {
			return false;
		}

		$cache = $this->getCache();
		$cacheVal = $cache->get( $this->getUserCacheKey() );

		if ( !empty( $cacheVal ) ) {
			return $cacheVal == 'Y';
		}

		$dbr = wfGetDB( $db );
		$row = $dbr->selectRow(
			'page_vote',
			[ 'count(*) as cnt' ],
			$this->getUserWhere(),
			__METHOD__
		);

		$val = $row->cnt > 0;

		// Y:N solve the problem with default val
		$cache->set( $this->getUserCacheKey(), $val ? 'Y': 'N' );
		return $val;
	}

	protected function getUserWhere() {
		return [
			'article_id' => $this->pageId,
			'user_id' => $this->userId,
		];
	}

	protected function getUserCacheKey() {
		return wfMemcKey( __CLASS__, __METHOD__, $this->pageId, $this->userId, 'VER1' );
	}

	protected function getPageCacheKey( $page = false ) {
		return wfMemcKey( __CLASS__, __METHOD__, $page ? $page: $this->pageId, 'VER2' );
	}

	private function getCache() {
		return F::App()->wg->Memc;
	}
}
