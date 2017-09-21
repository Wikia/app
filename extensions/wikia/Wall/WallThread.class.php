<?php

class WallThread {
	const FETCHED_REPLIES_LIMIT = 500;

	private $mThreadId = false;
	private $mCached = null;
	private $mForceMaster = false;

	// cached data
	private $data;

	public function __construct() {
		$this->initializeReplyData();
		$this->mCached = null;
		$this->mCityId = F::app()->wg->CityId;
	}

	protected function initializeReplyData() {
		$this->data = new stdClass();
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;
	}

	/**
	 * @param int $id
	 * @return WallThread
	 */
	static public function newFromId( $id ) {
		$wt = new WallThread();
		$wt->mThreadId = $id;

		return $wt;
	}

	public function loadIfCached() {
		if ( $this->mCached === null ) {
			$this->loadFromMemcache();
		}
		return $this->mCached;
	}

	public function move( Wall $dest, $user ) {
		CommentsIndex::getInstance()->moveThread( $this->mThreadId, $dest->getId() );

		$wallHistory = new WallHistory();
		$wallHistory->moveThread( $this->mThreadId, $dest->getId() );

		$main = $this->getThreadMainMsg();
		$main->load();
		// this is use to build a history in contribiution page
		$main->markAsMove( $user );
		$this->invalidateCache();
	}

	/**
	 * Fetch data for replies on this thread from DB, then cache the result.
	 * Result is cached indefinitely and is purged when thread is updated
	 * @see WallThread::invalidateCache()
	 */
	private function loadReplyObjs() {
		if ( $this->data->threadReplyIds === false ) {
			$this->loadReplyIdsFromDB();
		}

		$this->data->threadReplyObjs = [ ];

		if ( empty( $this->data->threadReplyIds ) ) {
			$this->data->threadReplyIds = [ ];
		}

		$replyMessages = WallMessage::newFromIds( $this->data->threadReplyIds );

		foreach ( $replyMessages as $reply ) {
			if ( !$reply->isAdminDelete() ) {
				$this->data->threadReplyObjs[] = $reply;
			}
		}

		// SUS-262: Save state to cache at this point, after objects have been initialized (using WallMessage::newFromIds)
		$this->saveToMemcache();
	}

	/**
	 * Fetches reply IDs for the thread, using a limit to control large queries
	 *
	 * @param DatabaseBase $dbr Database resource
	 * @param integer $afterId The last reply ID after which the next set is selected
	 * @return array List of reply IDs
	 */
	private function getReplyIdsFromDB( $dbr, $afterId = 0 ) {
		// this is a direct way to get IDs
		// the other one is in Wall.class done in a grouped way

		$query = ( new WikiaSQL() )
			->SELECT( 'distinct comment_id' )
			->FROM( 'comments_index' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( $this->mThreadId );

		if ( (int) $afterId > 0 ) {
			$query->AND_( 'comment_id' )->GREATER_THAN( $afterId );
		}

		$list = $query->ORDER_BY( [ 'comment_id', 'ASC' ] )
			->LIMIT( self::FETCHED_REPLIES_LIMIT )
			->runLoop( $dbr, function( &$list, $oRow ) {
				$list[] = $oRow->comment_id;
			} );

		return count( $list ) < self::FETCHED_REPLIES_LIMIT ?
			$list
			: array_merge( $list, $this->getReplyIdsFromDB( $dbr, end( $list ) ) );
	}

	private function loadReplyIdsFromDB() {
		if ( empty( Title::newFromID( $this->mThreadId ) ) ) {
			return;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$this->data->threadReplyIds = $this->getReplyIdsFromDB( $dbr );
	}

	public function invalidateCache() {
		// invalidate cache at Thread level (new reply or reply removed in thread)
		$this->getCache()->delete( $this->getThreadKey() );
		// Reset data
		$this->initializeReplyData();
	}

	private function getThreadKey() {
		return  wfMemcKey( __CLASS__, '-thread-key-v17-', $this->mThreadId );
	}

	private function getCache() {
		return F::app()->wg->Memc;
	}

	private function loadFromMemcache() {
		$cache = $this->getCache();
		$key = $this->getThreadKey();

		$ret = $cache->get( $key );
		if ( $ret === false || $ret === null ) {
			$this->mCached = false;
		} else {
			$this->data = $ret;
			$this->mCached = true;
		}
	}

	private function saveToMemcache() {
		$this->getCache()->set( $this->getThreadKey(), $this->data );
		$this->mCached = true;
		$this->mForceMaster = false;
	}

	public function getThreadMainMsg() {
		return WallMessage::newFromId( $this->mThreadId );
	}

	public function getRepliesCount() {
		if ( $this->data->threadReplyObjs === false ) {
			$this->loadReplyObjs();
		}

		return count( $this->data->threadReplyObjs );
	}
	// TODO: fix the performace of Replies Wall

	public function getRepliesWallMessages( $limit = 0, $order = "ASC" ) {
		if ( $this->data->threadReplyObjs === false ) {
			$this->loadReplyObjs();
		}

		$out = $this->data->threadReplyObjs;

		if ( $order == "DESC" ) {
			$out = array_reverse( $out );
		}

		if ( $limit > 0 ) {
			$out = array_slice( $out, 0, $limit );
		}

		return $out;
	}

	public function purgeLastMessage() {
		$key = wfMemcKey( __CLASS__, '-thread-lastreply-key', $this->mThreadId );
		WikiaDataAccess::cachePurge( $key );
	}

	/**
	 * TODO: used by ForumController::boardThread() method only. Move it there?
	 *
	 * @return null|WallMessage
	 */
	public function getLastMessage() {
		$key = wfMemcKey( __CLASS__, '-thread-lastreply-key', $this->mThreadId );
		$fname = __METHOD__;

		$data = WikiaDataAccess::cache( $key, 30 * 24 * 60 * 60, function() use ( $fname ) {
			$db = wfGetDB( DB_SLAVE );
			$row = $db->selectRow(
				[ 'comments_index' ],
				[ 'max(first_rev_id) rev_id' ],
				[
						'parent_comment_id' => $this->mThreadId,
						'archived' => 0,
						'deleted' => 0,
						'removed' => 0
				],
				$fname
			);
			return $row;
		} );

		// get last post info
		$revision = Revision::newFromId( $data->rev_id );
		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle();
			$wallMessage = WallMessage::newFromId( $title->getArticleID() );
			if ( !empty( $wallMessage ) ) {
				$wallMessage->load();
				return $wallMessage;
			}
		}

		return null;
	}
}
