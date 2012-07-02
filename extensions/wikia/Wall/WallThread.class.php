<?php

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
		
		$this->data->threadReplyIds = $ids;
		$this->data->threadActivityScore = $this->_getScore();
		$this->data->threadLastReplyTimestamp = $this->_getLastReplyTimestamp();
		
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
	
	private function loadReplyObjs() {
		if( $this->data->threadReplyIds === false )
			$this->loadReplyIdsFromDB();
		$this->data->threadReplyObjs = array();
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
		return wfSharedMemcKey( __CLASS__, 'thread-key-v09', $this->mCityId, $this->mThreadId);
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

?>
