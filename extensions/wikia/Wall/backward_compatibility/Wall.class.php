<?php

//Wall backward compatibility we are goin to remove it after comments indexing and 1.19 migration


class Wall {
	/** @var $mTitle Title */
	private $mTitle;
	private $mCityId;
	private $mThreadMapping = null;
	private $mThreadMappingRev = null;
	private $mThreadRCMapping = null;
	private $mThreadsHistory = null;
	private $mMaxPerPage = false;
	private $mSorting = false;
	public $mRelatedPageId = false; 
	private $cacheable = true;

	static public function newFromTitle( Title $title ) {
		wfProfileIn(__METHOD__);
		$wall = new Wall();
		$wall->mTitle = $title;
		$wall->mCityId = F::app()->wg->CityId;
		wfProfileOut(__METHOD__);
		return $wall;
	} 
	
	static public function newFromRelatedPages( Title $title, $relatedPageId ) {
		wfProfileIn(__METHOD__);
		
		$wall = new Wall();
		$wall->mTitle = $title;
		$wall->mCityId = F::app()->wg->CityId;
		$wall->mRelatedPageId = (int) $relatedPageId;
		
		wfProfileOut(__METHOD__);
		return $wall;
	} 
	
	static function getParentTitleFromReplyTitle( $titleText ) {
		wfProfileIn(__METHOD__);
		$parts = explode('/@', $titleText);
		if(count($parts) < 3) {
			wfProfileOut(__METHOD__);
			return null;
		}
		wfProfileOut(__METHOD__);	
		return $parts[0] . '/@' . $parts[1];
	}
	
	public function getId() {
		return $this->mTitle->getArticleId();
	}

	public function getTitle() {
		return $this->mTitle;
	}
	
	public function getRelatedPageId() {
		return $this->mRelatedPageId;
	}
	
	public function getUser() {
		return User::newFromName($this->mTitle->getBaseText(), false);
	}
	
	public function disableCache() {
		$this->cacheable = false;
	}
	
	public function getUrl() {
		$title = Title::newFromText( $this->getUser()->getName(), NS_USER_WALL );
		return $title->getFullUrl();
	}

	
	public function getThreads($page = 1, $queryLimit = array() ) {
		wfProfileIn(__METHOD__);
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
			case 'nt': // newest threads first
			default:
				$this->loadThreads();
				$this->sliceThreads( $page );
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				wfProfileOut(__METHOD__);
				return $this->threads;
			case 'ot': // oldest threads first
				$this->loadThreads();
				$this->threads = array_reverse($this->threads, true);
				$this->sliceThreads( $page );
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				wfProfileOut(__METHOD__);
				return $this->threads;
			case 'nr': // threads with newest reply first
				$this->loadThreads();
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				$this->preloadThreadTimestamp();
				uasort($this->threads, array($this, 'sortLastReply'));
				$this->sliceThreads( $page );
				wfProfileOut(__METHOD__);
				return $this->threads;
			case 'ma': // most active threads first
				$this->loadThreads();
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				$this->preloadThreadScore();
				uasort($this->threads, array($this, 'sortMostactive'));
				$this->sliceThreads( $page );
				wfProfileOut(__METHOD__);
				return $this->threads;
			case 'mr': // most replies in 7 days first
				$this->loadThreads();
				$this->checkWhichThreadsAreCached();
				$this->preloadThreadsGrouped();
				$this->preloadThreadReplyScore();
				uasort($this->threads, array($this, 'sortMostReply'));
				$this->sliceThreads( $page );
				wfProfileOut(__METHOD__);
				return $this->threads;
		}
	}

	public function sortLastReply( $a, $b ) {
		wfProfileIn(__METHOD__);
		$out = ($a->getLastReplyTimestamp() < $b->getLastReplyTimestamp() ) ? 1 : -1;
		wfProfileOut(__METHOD__);
		return $out;
	}

	public function sortMostactive( $a, $b ) {
		wfProfileIn(__METHOD__);
		$out = ($a->getScore() < $b->getScore() ) ? 1 : -1;
		wfProfileOut(__METHOD__);
		return $out;
	}

	public function sortMostReply( $a, $b ) {
		wfProfileIn(__METHOD__);
		if ( $a->getReplyScore() < $b->getReplyScore() ) {
			wfProfileOut(__METHOD__);
			return 1;
		} else if ( $a->getReplyScore() > $b->getReplyScore() ) {
			wfProfileOut(__METHOD__);
			return -1;
		} else {
			wfProfileOut(__METHOD__);
			return $this->sortLastReply( $a, $b );
		}
	}

	public function getThreadHistoryCount() {
		wfProfileIn(__METHOD__);
		if(is_null($this->mThreadsHistory)) {
			$this->loadWallThreadsHistory();
		}
		wfProfileOut(__METHOD__);
		return count($this->mThreadsHistory);
	}
	
	public function getThreadCount() {
		wfProfileIn(__METHOD__);
		if(is_null($this->mThreadMapping)) {
			$this->loadThreadList();
		}
		wfProfileOut(__METHOD__);
		return count($this->mThreadMapping);
	}
	
	public function setMaxPerPage( $val ) {
		wfProfileIn(__METHOD__);
 		$this->mMaxPerPage = $val;
 		wfProfileOut(__METHOD__);
	}

	public function setSorting( $val ) {
		wfProfileIn(__METHOD__);
 		$this->mSorting = $val;
 		wfProfileOut(__METHOD__);
	}
	
	private function preloadThreadTimestamp() {
		wfProfileIn(__METHOD__);
		// preload timestamps of replies (and cache in thread object)
		// to prevent changing object when sorting
		foreach( $this->threads as $thread ) {
			$thread->getLastReplyTimestamp(); 
		}
		wfProfileOut(__METHOD__);
	}
	
	private function preloadThreadScore() {
		wfProfileIn(__METHOD__);
		// preload score of threads (and cache in thread object)
		// to prevent changing object when sorting
		foreach( $this->threads as $thread ) {
			$thread->getScore();
		}
		wfProfileOut(__METHOD__);
	}
	
	private function preloadThreadReplyScore() {
		wfProfileIn(__METHOD__);
		// preload reply score of threads (and cache in thread object)
		// to prevent changing object when sorting
		foreach( $this->threads as $thread ) {
			$thread->getReplyScore();
		}
		wfProfileOut(__METHOD__);
	}

	private function sliceThreads( $page ) {
		wfProfileIn(__METHOD__);
		if(!empty($this->mMaxPerPage)) {
			$this->threads = array_slice($this->threads, $this->mMaxPerPage * ($page - 1), $this->mMaxPerPage, true);
		}
		wfProfileOut(__METHOD__);
	}
	
	private function checkWhichThreadsAreCached() {
		wfProfileIn(__METHOD__);
		$this->notCached = array();
		foreach( $this->threads as $tId => $thread ) {
			if( !$thread->loadIfCached() ) {
				if(!empty($this->mThreadMappingRev[ $tId ])) {
					$this->notCached[$tId] = $this->mThreadMappingRev[ $tId ];					
				}
			}
		}
		wfProfileOut(__METHOD__);
	}
	
	private function loadThreads() {
		wfProfileIn(__METHOD__);
		$this->threads = array();
		foreach( $this->mThreadMapping as $tTitle => $tId ) {
			$thread = WallThread::newFromId( $tId );
			$this->threads[$tId] = $thread;
		}
		wfProfileOut(__METHOD__);
	}

	private function loadThreadList( $forceReload = false ) {
		wfProfileIn(__METHOD__);
		$cache = $this->getCache();
		$key = $this->getWallThreadListKey();
		if( $this->cacheable && $forceReload === false ) {
			$val = $cache->get( $key );
		}

		if( empty($val) ) {
			// if forcing reload use master server
			$this->LoadThreadListFromDB( $forceReload );

			$val = array();
			$val['threadMapping'] = $this->mThreadMapping;
			$val['threadMappingRev'] = $this->mThreadMappingRev;
			
			$cache->set( $key, $val );
		} else {
			$this->mThreadMapping = $val['threadMapping'];
			$this->mThreadMappingRev = $val['threadMappingRev'];
		}
		wfProfileOut(__METHOD__);
	}
	
	private function loadThreadListFromDB($master = true) {
		wfProfileIn(__METHOD__);
		// get list of threads (article IDs) on Message Wall
		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );
		
		$query = '';

		// page_latest condition is for BugId:22821
		$query = "
			select page.page_id, page.page_title from page
			left join page_wikia_props
			on page.page_id = page_wikia_props.page_id
			and (page_wikia_props.propname = ".WPP_WALL_ADMINDELETE."
			     or page_wikia_props.propname = ".WPP_WALL_REMOVE."
			     or page_wikia_props.propname = ".WPP_WALL_ARCHIVE.")
			where page_wikia_props.page_id is null
			and page.page_title" . $dbr->buildLike( sprintf( "%s/%s", $this->mTitle->getDBkey(), ARTICLECOMMENT_PREFIX ), $dbr->anyString() ) . " 
			and page.page_title NOT " . $dbr->buildLike( sprintf( "%s/%s%%/%s", $this->mTitle->getDBkey(), ARTICLECOMMENT_PREFIX, ARTICLECOMMENT_PREFIX ), $dbr->anyString() ) . "
			and page.page_title not like '%@%@%'
			and page.page_namespace = ".MWNamespace::getTalk($this->mTitle->getNamespace())."
			and page.page_latest > 0
			order by page.page_id desc";
		
		$res = $dbr->query( $query );
		
		$this->mThreadMapping = array();
		$this->mThreadMappingRev = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$this->mThreadMapping[$row->page_title] = $row->page_id;
			$this->mThreadMappingRev[$row->page_id] = $row->page_title;
		}
		wfProfileOut(__METHOD__);
	}
	
	private function preloadThreadsGrouped( $master = true ) {
		wfProfileIn(__METHOD__);
		// load data for threads on the notCached list
		// send it to objects on threads list
		if( count($this->notCached) == 0 ) {
			wfProfileOut(__METHOD__);
			return;
		}

		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$table = array( 'page' );
		$vars = array( 'page_id', 'page_title' );
		$conds = array();
		$like = array();
		foreach( $this->notCached as $tId => $tTitle ) {
			$like[]  = "page_title" . $dbr->buildLike( sprintf( "%s/%s", $tTitle, ARTICLECOMMENT_PREFIX ), $dbr->anyString() );
		}
		$conds[] = implode(' OR ', $like);
		$conds[] = "page_latest > 0";	// BugId:22821
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

		wfProfileOut(__METHOD__);
		//var_dump($threads); die();
	}

	private function getWallThreadListKey() {
		return  wfMemcKey(__CLASS__ ,'wall-threadlist-key', $this->mTitle->getDBkey(), $this->mTitle->getNamespace(), 'v5');
	}
	
	private function getCache() {
		return F::App()->wg->Memc;
	}

	
	public function invalidateCache() {
		wfProfileIn(__METHOD__);
		// invalidate cache at Wall level (new thread or thread removed)
		$this->loadThreadList( true );
		wfProfileOut(__METHOD__);
	}
	
}