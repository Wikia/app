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
		$this->data = new StdClass();
		$this->data->threadReplyIds = false;
		$this->data->threadReplyObjs = false;
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
		if ( $this->mCached === null ) {
			$this->loadFromMemcache();
		}
		return $this->mCached;
	}

	public function move( Wall $dest, $user ) {
		CommentsIndex::changeParent( 0, $dest->getId(), $this->mThreadId );

		$wallHistory = new WallHistory( $this->mCityId );
		$wallHistory->moveThread( $this->mThreadId, $dest->getId() );

		$main = $this->getThreadMainMsg();
		$main->load();
		// this is use to build a history in contribiution page
		$main->markAsMove( $user );
		$this->invalidateCache();
	}


	public function setReplies( $ids ) {
		// set and cache replies of this thread
		$this->initializeReplyData();

		$this->data->threadReplyIds = $ids;

		$this->saveToMemcache();
	}

	private function loadReplyObjs() {
		if ( $this->data->threadReplyIds === false ) {
			$this->loadReplyIdsFromDB();
		}

		$this->data->threadReplyObjs = [ ];

		if ( empty( $this->data->threadReplyIds ) ) {
			$this->data->threadReplyIds = [ ];
		}

		$replyMessages = WallMessage::newFromIds( $this->data->threadReplyIds );

		/** @var WallMessage $reply */
		foreach ( $replyMessages as $reply ) {
			if ( !$reply->isAdminDelete() ) {
				$this->data->threadReplyObjs[] = $reply;
			}
		}
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
		// (fetch for many threads at once, set with ->setReplies)

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

	private function loadReplyIdsFromDB( $master = false ) {
		if ( empty( Title::newFromId( $this->mThreadId ) ) ) {
			return;
		}

		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$this->setReplies( $this->getReplyIdsFromDB( $dbr ) );
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
		return F::App()->wg->Memc;
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

	public function getLastMessage() {
		$key = wfMemcKey( __CLASS__, '-thread-lastreply-key', $this->mThreadId );
		$threadId = $this->mThreadId;
		$data = WikiaDataAccess::cache( $key, 30 * 24 * 60 * 60, function() use ( $threadId ) {
			$db = wfGetDB( DB_SLAVE );
			$row = $db->selectRow(
				[ 'comments_index' ],
				[ 'max(first_rev_id) rev_id' ],
				[
						'parent_comment_id' => $threadId,
						'archived' => 0,
						'deleted' => 0,
						'removed' => 0
				],
				__METHOD__
			);
			return $row;
		} );

		// get last post info
		$revision = Revision::newFromId( $data->rev_id );
		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle();
			$wallMessage = WallMessage::newFromId( $title->getArticleId() );
			if ( !empty( $wallMessage ) ) {
				$wallMessage->load();
				return $wallMessage;
			}
		}

		return null;
	}
}
