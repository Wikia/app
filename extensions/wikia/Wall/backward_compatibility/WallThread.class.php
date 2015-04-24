<?php

//Wall backward compatibility we are goin to remove it after comments indexing and 1.19 migration

class WallThread {
	private $mThreadId = false;
	private $mCached = null;
	private $mForceMaster = false;

	// cached data
	private $data;
	/*
		private $data->threadReplyIds = false;
		private $data->threadReplyObjs = false;
 		private $data->threadActivityScore = false;
		private $data->threadLastReplyTimestamp = false;
	 */

	public function __construct() {
		$this->data = null;
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;
		$this->data->threadActivityScore = false;
		$this->data->threadLastReplyTimestamp = false;
		$this->data->threadReplyScore = false;
		$this->mCached = null;
		$this->mCityId = F::app()->wg->CityId;
	}

	static public function newFromId( $id ) {
		$wt = new WallThread();
		$wt->mThreadId = $id;

		return $wt;
	}

	public function timestampToScore ( $timestamp ) {
		$ago = time() - strtotime($timestamp) + 1;
		if ($ago < 86400) {
			// Under 24 hrs
			return 50;
		}
		else if ($ago < 7 * 86400) {
			// Under 7 days
			return 25;
		}
		else if ($ago < 14 * 86400) {
			// Under 14 days
			return 10;
		}
		else if ($ago < 30 * 86400) {
			// Under 30 days
			return 1;
		}
		else {
			return 0;
		}
	}

	public function loadIfCached() {
		if($this->mCached === null) {
			$this->loadFromMemcache();
		}
		return $this->mCached;
	}

	public function setReplies( $ids ) {
		// set and cache replies of this thread
		$this->data = null;
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;
		$this->data->threadActivityScore = false;
		$this->data->threadLastReplyTimestamp = false;
		$this->data->threadReplyScore = false;

		$this->data->threadReplyIds = $ids;
		$this->data->threadActivityScore = $this->_getScore();
		$this->data->threadLastReplyTimestamp = $this->_getLastReplyTimestamp();
		$this->data->threadReplyScore = $this->_getReplyScore();

		$this->saveToMemcache();
	}

	public function getScore() {
		if( !($this->data->threadActivityScore === false) )
			return $this->data->threadActivityScore;
		$this->data->threadActivityScore = $this->_getScore();
		return $this->data->threadActivityScore;
	}

	public function getLastReplyTimestamp() {
		if( !($this->data->threadLastReplyTimestamp === false) )
			return $this->data->threadLastReplyTimestamp;
		$this->data->threadLastReplyTimestamp = $this->_getLastReplyTimestamp();
		return $this->data->threadLastReplyTimestamp;
	}

	public function getReplyScore() {
		if( !($this->data->threadReplyScore === false) ) {
			return $this->data->threadReplyScore;
		}
		$this->data->threadReplyScore = $this->_getReplyScore();

		return $this->data->threadReplyScore;
	}

	private function _getScore() {
		// score is used for Most Active thread sorting
		if($this->data->threadReplyObjs === false) $this->loadReplyObjs();
		$score = 0;
		foreach( $this->data->threadReplyObjs as $obj ) {
			$obj->load();
			if( !empty($obj->mFirstRevision) ) {
				$timestamp = $obj->mFirstRevision->getTimestamp();
				$score += $this->timestampToScore( $timestamp );
			}
		}

		$mainMsg = $this->getThreadMainMsg();
		if(!($mainMsg instanceof WallMessage)) {
			return 0;
		}
		$mainMsg->load();
		$score += $this->timestampToScore( $mainMsg->getCreateTimeRAW() );
		return $score;
	}

	private function _getLastReplyTimestamp() {
		if($this->data->threadReplyObjs === false) $this->loadReplyObjs();
		if(count($this->data->threadReplyObjs) > 0) {
			$last = end($this->data->threadReplyObjs);
		} else {
			$last = $this->getThreadMainMsg();
		}
		if(!($last instanceof WallMessage)) {
			return 0;
		}
		$last->load();

		return $last->getCreateTimeRAW();

	}

	// get reply score - score is used for Most Replies in 7 day sorting ( from comment_index table )
	private function _getReplyScore() {
		wfProfileIn( __METHOD__ );

		$score = 0;
		$startPeriod = wfTimestamp( TS_MW, strtotime( '-7 day' ) );
		$lastReply = $this->getLastReplyTimestamp();
		if ( $lastReply >= $startPeriod ) {
			if ( $this->data->threadReplyObjs === false ) {
				$this->loadReplyObjs();
			}

			if ( !empty($this->data->threadReplyObjs) ) {
				$db = wfGetDB( DB_SLAVE );
				$score = $db->selectField(
					array( 'comments_index' ),
					array( 'count(distinct comment_id) cnt' ),
					array(
						'parent_comment_id' => $this->mThreadId,
						'deleted' => 0,
						'removed' => 0,
						'created_at > '.$startPeriod,
					),
					__METHOD__
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return intval( $score );
	}

	private function loadReplyObjs() {
		if( $this->data->threadReplyIds === false )
			$this->loadReplyIdsFromDB();
		$this->data->threadReplyObjs = array();

		if(empty($this->data->threadReplyIds)) {
			$this->data->threadReplyIds = array();
		}

		foreach( $this->data->threadReplyIds as $id ) {
			$wm = WallMessage::newFromId( $id, $this->mForceMaster );
			if($wm instanceof WallMessage && !$wm->isAdminDelete()) {
				$this->data->threadReplyObjs[ $id ] = $wm;
			}
		}
	}

	private function loadReplyIdsFromDB($master = false) {
		// this is a direct way to get IDs
		// the other one is in Wall.class done in a grouped way
		// (fetch for many threads at once, set with ->setReplies)

		$title = Title::newFromId( $this->mThreadId );

		if( empty($title) ) {
			$title = Title::newFromId( $this->mThreadId, Title::GAID_FOR_UPDATE );
		}

		if( empty($title) ) {
			return ;
		}

		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$table = array( 'page' );
		$vars = array( 'page_id' );
		$conds[]  = "page_title" . $dbr->buildLike( sprintf( "%s/%s", $title->getDBkey(), ARTICLECOMMENT_PREFIX ), $dbr->anyString() );
		$conds[] = "page_latest > 0";	// BugId:22821
		$conds['page_namespace'] = MWNamespace::getTalk($title->getNamespace());
		$options = array( 'ORDER BY' => 'page_id ASC' );
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);

		$list = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			array_push($list, $row->page_id);
		}

		$this->setReplies( $list );
	}

	public function invalidateCache() {
		// invalidate cache at Thread level (new reply or reply removed in thread)
		$this->mForceMaster = true;
		$this->loadReplyIdsFromDB( true );
	}

	private function getThreadKey() {
		return  wfMemcKey(__CLASS__, '-thread-key-v16-', $this->mThreadId);
	}

	private function getCache() {
		return F::App()->wg->Memc;
	}

	private function loadFromMemcache() {
		$cache = $this->getCache();
		$key = $this->getThreadKey();

		$ret = $cache->get($key);
		if($ret === false || $ret === null) {
			$this->mCached = false;
		} else {
			$this->data = $ret;
			$this->mCached = true;
		}
	}

	private function saveToMemcache() {
		$cache = $this->getCache();
		$key = $this->getThreadKey();

		$cache->set($key, $this->data);
		$this->mCached = true;
		$this->mForceMaster = false;
	}

	public function getThreadMainMsg() {
		return WallMessage::newFromId( $this->mThreadId );
	}

	public function getRepliesWallMessages() {
		if($this->data->threadReplyObjs === false)
			$this->loadReplyObjs();
		return $this->data->threadReplyObjs;
	}

}
