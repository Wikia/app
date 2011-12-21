<?php

class WallThread {
	private $mThreadId = false;
	private $mCached = null;
	
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
	}
	
	static public function newFromId( $id ) {
		$wt = new WallThread();
		$wt->mThreadId = $id;
		
		return $wt;
	}
	
	static public function timestampToScore ( $timestamp ) {
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
	
	public function isCached() {
		return false;
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
			if( $obj->mFirstRevision ) {
				$timestamp = $obj->mFirstRevision->getTimestamp();
				$score += self::timestampToScore( $timestamp );
			}
		}
		$ac = $this->getThreadAC();
		$ac->load();
		$score += self::timestampToScore( $ac->mFirstRevision->getTimestamp() );
		return $score;
	}
	
	private function _getLastReplyTimestamp() {
		if($this->data->threadReplyObjs === false) $this->loadReplyObjs();
		if(count($this->data->threadReplyObjs) > 0) {
			$last = end($this->data->threadReplyObjs);
		} else {
			$last = $this->getThreadAC();
		}
		//var_dump($this->mReplyObjs);
		//var_dump($last);
		$last->load();
		if( $last->mFirstRevision ) {
			return $last->mFirstRevision->getTimestamp();
		}
	
	}
	
	private function loadReplyObjs() {
		if( $this->data->threadReplyIds === false )
			$this->loadReplyIdsFromDB();
		$this->data->threadReplyObjs = array();
		foreach( $this->data->threadReplyIds as $id ) {
			$ac = ArticleComment::newFromId( $id );
			//$this->mReplyObjs[ $id ] = WallMessage::newFromArticleComment( $ac );
			$this->data->threadReplyObjs[ $id ] = $ac;
		}
	}
	
	private function loadReplyIdsFromDB($master = true) {
		// this is a direct way to get IDs
		// the other one is in Wall.class done in a grouped way
		// (fetch for many threads at once, set with ->setReplies)

		$title = Title::newFromId( $this->mThreadId );

		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$table = array( 'page' );
		$vars = array( 'page_id' );
		$conds[]  = "page_title LIKE '" . $dbr->escapeLike( $title->getDBkey() ) . '/' . ARTICLECOMMENT_PREFIX ."%'";
		$conds['page_namespace'] = NS_USER_WALL_MESSAGE;
		$options = array( 'ORDER BY' => 'page_id ASC' );
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);

		$list = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			array_push($list, $row->page_id);
		}
		$this->setReplies( $list );

	}
	
	private function reloadAndCache() {
		// invalidate cache at Thread level (new reply or reply removed in thread, reply edited)
	}
	
	private function getThreadKey() {
		return  __CLASS__ . 'thread-key-v08-' . $this->mThreadId;
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
	}
	
	public function getThreadAC() {
		return ArticleComment::newFromId( $this->mThreadId );
	}
	
	public function getRepliesAC() {
		if($this->data->threadReplyObjs === false)
			$this->loadReplyObjs();
		return $this->data->threadReplyObjs;
	}
	
}

?>