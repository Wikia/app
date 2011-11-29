<?php

function sort_lastreply( $a, $b ) {
	return ($a->getLastReplyTimestamp() < $b->getLastReplyTimestamp() ) ? 1 : -1;
}

function sort_mostactive( $a, $b ) {
	return ($a->getScore() < $b->getScore() ) ? 1 : -1;
}

class Wall {
	private $mTitle;
	private $mThreadMapping = null;
	private $mThreadMappingRev = null;
	private $mMaxPerPage = false;
	private $mSorting = false;
	
	
	static public function newFromTitle( Title $title ) {
		$wall = new Wall();
		$wall->mTitle = $title;

		return $wall;
	}
	
	static function getParentTitleFromReplyTitle( $titleText ) {
		$parts = explode('/@', $titleText);
		if(count($parts) < 3) return null;	
		return $parts[0] . '/@' . $parts[1];
	}
	
	public function getThreads($page = 1) {
		// make objects out of IDs
		// load missing data in ONE SQL query
		// grouping together all threads without reply data

		if(is_null($this->mThreadMapping)) {
			$this->loadThreadList();
		}
		
		// the order of funcitons differs, because sorting for threads
		// by "newest" / "oldest" does not require all of them
		// so we can slice first, than load them
		// and for other sorting methods we need to fetch them all first
		// than sort
		switch( $this->mSorting ) {
			case 'nt':
				$this->loadThreads();		
				$this->sliceThreads( $page );
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				return $this->threads;
			case 'ot':
				$this->loadThreads();		
				$this->threads = array_reverse($this->threads, true);
				$this->sliceThreads( $page );		
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				return $this->threads;
			case 'nr':
				$this->loadThreads();		
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				$this->preloadThreadTimestamp();
				uasort( $this->threads, "sort_lastreply" );
				$this->sliceThreads( $page );		
				return $this->threads;
			case 'ma':
				$this->loadThreads();		
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				$this->preloadThreadScore();
				uasort( $this->threads, "sort_mostactive" );
				$this->sliceThreads( $page );		
				return $this->threads;
			default:
				$this->loadThreads();		
				$this->sliceThreads( $page );		
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				return $this->threads;
		}
		
	}

	public function getThreadCount() {
		if(is_null($this->mThreadMapping)) {
			$this->loadThreadList();
		}
		return count($this->mThreadMapping);
	}
	
	public function setMaxPerPage( $val ) {
 		$this->mMaxPerPage = $val;
	}

	public function setSorting( $val ) {
 		$this->mSorting = $val;
	}

	private function preloadThreadTimestamp() {
		foreach( $this->threads as $thread ) {
			$thread->getLastReplyTimestamp(); // prevent changing object when sorting
		}
	}
	
	private function preloadThreadScore() {
		foreach( $this->threads as $thread ) {
			$thread->getScore(); // prevent changing object when sorting
		}
		
	}
	
	private function sliceThreads( $page ) {
		if(!empty($this->mMaxPerPage)) {
			$this->threads = array_slice($this->threads, $this->mMaxPerPage * ($page - 1), $this->mMaxPerPage, true);
		}
	}
	
	private function checkWhichThreadsAreCached() {
		$this->notCached = array();
		foreach( $this->threads as $tId => $thread ) {
			if( !$thread->isCached() ) {
				$this->notCached[$tId] = $this->mThreadMappingRev[ $tId ];
			}
		}
	}
	
	private function loadThreads() {
		$this->threads = array();
		foreach( $this->mThreadMapping as $tTitle => $tId ) {
			$thread = WallThread::newFromId( $tId );
			$this->threads[$tId] = $thread;
		}

	}
	
	private function loadThreadList($master = true) {
		// get list of threads (article IDs) on Message Wall
		
		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$table = array( 'page' );
		$vars = array( 'page_id', 'page_title' );
		$conds = array();
		$conds[] = "page_title LIKE '" . $dbr->escapeLike( $this->mTitle->getDBkey() ) . '/' . ARTICLECOMMENT_PREFIX . "%'";
		$conds[] = "page_title NOT LIKE '" . $dbr->escapeLike( $this->mTitle->getDBkey() ) . '/' . ARTICLECOMMENT_PREFIX . "%/" . ARTICLECOMMENT_PREFIX ."%'";
		$conds['page_namespace'] = NS_USER_WALL_MESSAGE;
		$options = array( 'ORDER BY' => 'page_id DESC' );
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);

		$this->mThreadMapping = array();
		$this->mThreadMappingRev = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$this->mThreadMapping[$row->page_title] = $row->page_id;
			$this->mThreadMappingRev[$row->page_id] = $row->page_title;
		}
		
	}
	
	private function preloadThreadsGrouped( $master = true ) {
		// load data for threads on the notCached list
		// send it to objects on threads list
		if( count($this->notCached) == 0 ) return;

		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$table = array( 'page' );
		$vars = array( 'page_id', 'page_title' );
		$conds = array();
		$like = array();
		foreach( $this->notCached as $tId => $tTitle ) {
			$like[]  = "page_title LIKE '" . $dbr->escapeLike( $tTitle ) . '/' . ARTICLECOMMENT_PREFIX ."%'";
		}
		$conds[] = implode(' OR ', $like);
		$conds['page_namespace'] = NS_USER_WALL_MESSAGE;
		$options = array( 'ORDER BY' => 'page_id ASC' );
		$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);

		$replyThreadMapping = array();
		$threadWithNoReplies = array_flip($this->notCached);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$parent = self::getParentTitleFromReplyTitle($row->page_title);
			if(!isset($replyThreadMapping[$parent])) {
				$replyThreadMapping[$parent] = array();
				unset( $threadWithNoReplies[$parent] );
			}
			array_push($replyThreadMapping[$parent], $row->page_id);
		}
		
		foreach($replyThreadMapping as $title=>$ids) {
			if(!isset($this->mThreadMapping[$title])) {
				// replies to thread that doesn't exist
				// ignore
			} else {
				$parentId = $this->mThreadMapping[$title];
				$this->threads[ $parentId ]->setReplies( $ids );
			}
		}
		
		foreach($threadWithNoReplies as $title=>$id) {
			$this->threads[ $id ]->setReplies( array() );
		}		
		//var_dump($threads); die();
	}
	
	private function invalidateCache() {
		// invalidate cache at Wall level (new thread or thread removed)
	}
	
}

?>