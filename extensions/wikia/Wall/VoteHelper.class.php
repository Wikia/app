<?php

// TODO: move this to services

class VoteHelper {
	protected $userId;
	protected $pageId;
	protected $userIP = '';

	function __construct( $user = null, $pageId = 0 ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$this->userIP = $wgRequest->getIP();
		if ( $user->isLoggedIn() ) {
			$this->userId = $user->getId();
		} else {
			$this->userId = 0;
		}

		$this->pageId = $pageId;
		wfProfileOut( __METHOD__ );
	}

	// TODO: caching ?
	function getVotersList( $from = 0, $count = 50 ) {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE );
		// TODO: abstract the query
		$res = $dbr->select( array( 'page_vote', 'ipblocks' ),
			array( 'user_id' ),
			array(
				"ifnull(ipb_expiry, 0) != 'infinity'",
				'ifnull(ipb_expiry, 0) < ' . wfTimestamp( TS_MW ),
				'article_id' => $this->pageId,
			),
			__METHOD__,
			array(
				'OFFSET' => $from,
				'LIMIT' => $count,
				'ORDER BY' => 'time desc'
			),
			array( 'ipblocks'  => array( 'LEFT JOIN', 'user_id = ipb_user' ) )
		);

		$out = array();

		while ( $row = $res->fetchObject() ) {
			$out[] = $row->user_id;
		}

		$this->getCache()->delete( $this->getPageCacheKey() );

		$this->getVoteCount();

		wfProfileOut( __METHOD__ );
		return $out;
	}

	function addVote( $score = 1 ) {
		wfProfileIn( __METHOD__ );
		if ( $this->isVoted() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		$dbr = wfGetDB( DB_MASTER );

		$values = array();
		$values['article_id'] = $this->pageId;
		$values['ip'] = $this->userIP;
		$values['user_id'] = $this->userId;

		$values['unique_id'] = md5( $this->userIP ); // Backward compatibility
		$values['time'] = wfTimestampNow();
		$values['vote'] = $score;

		$dbr->insert( 'page_vote',
			$values,
		__METHOD__ );

		$cache = $this->getCache();
		$cache->set( $this->getUserCacheKey(), 'Y', 60 * 60 );
		$this->getVoteCount( DB_MASTER );
		wfProfileOut( __METHOD__ ); ;
		return true;
	}

	function removeVote() {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_MASTER );
		$dbr->delete( 'page_vote',
			$this->getUserWhere(),
		__METHOD__ );

		$cache = $this->getCache();
		$cache->set( $this->getUserCacheKey(), 'N' );
		$this->getVoteCount( DB_MASTER );
		wfProfileOut( __METHOD__ );
	}

	function getVoteCount( $db = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );
		$cache = $this->getCache();
		if ( $db != DB_MASTER ) {
			$cacheVal = $cache->get( $this->getPageCacheKey(), null );
			if ( $cacheVal !== false ) {
				wfProfileOut( __METHOD__ );
				return $cacheVal;
			}
		}

		$dbr = wfGetDB( $db );
		// TODO: abstract the query
		$row = $dbr->selectRow( array( 'page_vote', 'ipblocks' ),
			array( 'count(*) as cnt' ),
			array(
				"ifnull(ipb_expiry, 0) != 'infinity'",
				'ifnull(ipb_expiry, 0) < ' . wfTimestamp( TS_MW ),
				'article_id' => $this->pageId,
			),
			__METHOD__,
			array(
				'ORDER BY' => 'time desc'
			),
			array( 'ipblocks'  => array( 'LEFT JOIN', 'user_id = ipb_user' ) )
		);

		$cache->set( $this->getPageCacheKey(), $row->cnt, 60 * 60 );
		wfProfileOut( __METHOD__ );
		return (int) $row->cnt;
	}

	// TODO: move this to background tasks, for now just invalidation of last 100 votes
	function invalidateUser() {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( array( 'page_vote' ),
			array( 'article_id' ),
			array(
				'user_id' => $this->userId,
			),
			__METHOD__,
			array(
				'LIMIT' => 100,
				'ORDER BY' => 'time desc'
			)
		);

		$out = array();

		$cache = $this->getCache();
		while ( $row = $res->fetchObject() ) {
			$key = $this->getPageCacheKey( $row->article_id );
			$cache->delete( $key );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	function isVoted( $db = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( $db );

		$cache = $this->getCache();
		$cacheVal = $cache->get( $this->getUserCacheKey(), "N" );

		if ( !empty( $cacheVal ) ) {
			wfProfileOut( __METHOD__ );
			return $cacheVal == 'Y';
		}

		$row = $dbr->selectRow( 'page_vote',
			array( 'count(*)as cnt' ),
			$this->getUserWhere(),
			__METHOD__ );

		$val = ( $row->cnt > 0 );

		// Y:N solve the problem with defult val
		$cache->set( $this->getUserCacheKey(), $val ? 'Y': 'N' );
		wfProfileOut( __METHOD__ );
		return $val;
	}

	protected function getUserWhere() {
		wfProfileIn( __METHOD__ );
		$where = array(
				'article_id' => $this->pageId,
		);

		if ( $this->userId == 0 ) {
			$where['user_id'] = 0;
			$where['ip'] = $this->userIP;
		} else {
			$where['user_id'] = $this->userId;
		}
		wfProfileOut( __METHOD__ );
		return $where;
	}

	protected function getUserCacheKey() {
		wfProfileIn( __METHOD__ );
		if ( $this->userId == 0 ) {
			$res = wfMemcKey( __CLASS__, __METHOD__, $this->pageId, 0, $this->userIP, 'VER1' );
		} else {
			$res = wfMemcKey( __CLASS__, __METHOD__, $this->pageId,  $this->userId, '', 'VER1' );
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	protected function getPageCacheKey( $page = false ) {
		return wfMemcKey( __CLASS__, __METHOD__, $page ? $page: $this->pageId, 'VER2' );
	}

	private function getCache() {
		return F::App()->wg->Memc;
	}
}
