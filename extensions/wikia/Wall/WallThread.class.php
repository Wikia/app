<?php

class WallThread {
	private $mThreadId = false;
	private $mCached = null;
	private $mForceMaster = false;

	// cached data
	private $data;

	public function __construct() {
		$this->data = new StdClass();
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;

		$this->mCached = null;
		$this->mCityId = F::app()->wg->CityId;
	}

	/**
	 * @static
	 * @param $id
	 * @return WallThread
	 */
	static public function newFromId( $id ) {
		$wt = new WallThread();
		$wt->mThreadId = $id;

		return $wt;
	}
	public function loadIfCached() {
		if($this->mCached === null) {
			$this->loadFromMemcache();
		}
		return $this->mCached;
	}
	
	public function move(Wall $dest, $user) {
		CommentsIndex::changeParent( 0, $dest->getId(), $this->mThreadId);
		
		$wallHistory = new WallHistory( $this->mCityId );
		$wallHistory->moveThread( $this->mThreadId, $dest->getId() );
		
		$main = $this->getThreadMainMsg();
		$main->load();
		//this is use to build a history in contribiution page
		$main->markAsMove($user);
		$this->invalidateCache();
	}
	

	public function setReplies( $ids ) {
		// set and cache replies of this thread
		$this->data = new StdClass();
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;
		
		$this->data->threadReplyIds = $ids;

		$this->saveToMemcache();
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
				$this->data->threadReplyObjs[] = $wm;
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

		$threadId = $title->getArticleID();

		$result = $dbr->select(
				array( 'comments_index' ),
				array( 'distinct comment_id' ),
				array( 'parent_comment_id = '.$threadId ),
				__METHOD__,
				array( 'ORDER BY' => 'comment_id ASC' )
		);

		$list = array();
		while ( $row = $dbr->fetchObject( $result ) ) {
			$list[] = $row->comment_id;
		}

		$this->setReplies( $list );
	}

	public function invalidateCache() {
		// invalidate cache at Thread level (new reply or reply removed in thread)
		$this->mForceMaster = true;
		$this->loadReplyIdsFromDB( true );
	}

	private function getThreadKey() {
		return  wfMemcKey(__CLASS__, '-thread-key-v17-', $this->mThreadId);
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
	
	public function getRepliesCount() {
		if($this->data->threadReplyObjs === false) {
			$this->loadReplyObjs();	
		}
		
		return count($this->data->threadReplyObjs);
	}
	//TODO: fix the performace of Replies Wall

	public function getRepliesWallMessages($limit = 0, $order = "ASC" ) {
		if($this->data->threadReplyObjs === false) {
			$this->loadReplyObjs();	
		}
		
		$out = $this->data->threadReplyObjs;
		
		if($order == "DESC") {
			$out = array_reverse($out);	
		}
				
		if($limit > 0) {
			$out = array_slice($out, 0, $limit);
		}
		
		return $out;
	}
	
	public function purgeLastMessage() {
		$key = wfMemcKey(__CLASS__, '-thread-lastreply-key', $this->mThreadId);
		WikiaDataAccess::cachePurge($key);
	}
	
	public function getLastMessage() {
		$key = wfMemcKey(__CLASS__, '-thread-lastreply-key', $this->mThreadId);
		$threadId = $this->mThreadId;
		$data = WikiaDataAccess::cache( $key, 30*24*60*60, function() use ($threadId) {
			$db = wfGetDB(DB_SLAVE);
			$row = $db->selectRow(
				array( 'comments_index' ),
				array( 'max(first_rev_id) rev_id' ),
				array(
						'parent_comment_id' => $threadId,
						'archived' => 0,
						'deleted' => 0,
						'removed' => 0
				),
				__METHOD__
			);
			return $row;
		});
		
		// get last post info
		$revision = Revision::newFromId( $data->rev_id );
		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle();
			$wallMessage = WallMessage::newFromId($title->getArticleId());
			if(!empty($wallMessage)) {
				$wallMessage->load();
				return $wallMessage;
			} 
		}
		
		return null;
	}
}
