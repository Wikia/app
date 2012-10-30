<?php

class Wall {
	protected $mTitle;
	protected $mCityId;

	protected $mMaxPerPage = false;
	protected $mSorting = false;
	protected $mRelatedPageId = false;
	protected $cacheable = true;

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
	
	public function exists() {
		$id = (int) $this->getId();
		if($id != 0) {
			return true;
		}
		return false;
	}

	public function getUrl() {
		wfProfileIn(__METHOD__);
		$title = F::build( 'title', array( $this->getUser()->getName(), NS_USER_WALL ), 'newFromText' );
		wfProfileOut(__METHOD__);
		return $title->getFullUrl();
	}

	public function disableCache() {
		$this->cacheable = false;
	}

	protected function getWhere() {
		wfProfileIn(__METHOD__);
		$pageId = $this->mTitle->getArticleID();

		$where = "parent_page_id = $pageId  and deleted = 0 and removed = 0";

		if( !empty($this->mRelatedPageId) ) {
			$where = "comment_id in (select comment_id from wall_related_pages where page_id = {$this->mRelatedPageId})";
		}

		wfProfileOut(__METHOD__);
		return $where;
	}

	/*
	 * most replies in 7 days
	 */

	protected function getLast7daysOrder( $master = false ) {
		wfProfileIn(__METHOD__);

		$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$time = date ("Y-m-d H:i:s", time() - 24*7*60*60 ) ;

		$pageId = (int) $this->mTitle->getArticleID();

		$res = $db->select(
			array( 'comments_index' ),
			array( 'parent_comment_id, count(*) as cnt' ),
			array(
				$this->getWhere(),
				'parent_comment_id != 0',
				"last_touched BETWEEN '$time' AND NOW()",
			),
			__METHOD__,
			array(
				'ORDER BY' => 'cnt desc',
				'LIMIT' => 100,
				'GROUP BY' => 'parent_comment_id'
			)
		);

		$out = array();

		while ( $row = $db->fetchObject( $res ) ) {
			$out[] = $row->parent_comment_id;
		}
		$ids = implode(',', $out);

		if(!empty($out)) {
			/* look a lit bit complicated but it is fast, tested on 150000 rows, we are expecing less then that. */
			$ids = implode(',', $out);
			$out = "CASE WHEN comment_id in (" . $ids . ") THEN Field(comment_id," . $ids . ")
				ELSE 1e12 END asc, comment_id desc ";
		} else {
			$out = 'comment_id DESC';
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	protected function getOrderBy() {
		wfProfileIn(__METHOD__);

		$this->getLast7daysOrder();

		switch( $this->mSorting ) {
			case 'nt': // newest threads first
			default:
				wfProfileOut(__METHOD__);
				return 'comment_id desc';
			case 'ot': // oldest threads first
				wfProfileOut(__METHOD__);
				return 'comment_id asc';
			case 'nr': // threads with newest reply first
				wfProfileOut(__METHOD__);
				return 'last_child_comment_id desc';
			case 'mr': // most replies in 7 days first
				$out = $this->getLast7daysOrder();
				wfProfileOut(__METHOD__);
				return $out;
		}
	}

	public function getThreads( $page = 1, $master = false ) {
		wfProfileIn(__METHOD__);
		// get list of threads (article IDs) on Message Wall
		$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$offset = ($page - 1)*$this->mMaxPerPage;

		$where = $this->getWhere();

		$where .= ' and parent_comment_id = 0 ';

		$orderBy = $this->getOrderBy();

		$query = "
			SELECT comment_id FROM comments_index
				WHERE $where
				ORDER BY $orderBy
				LIMIT $offset, {$this->mMaxPerPage}
			";

		$res = $db->query( $query );

		$out = array();

		while ( $row = $db->fetchObject( $res ) ) {
			$out[] = WallThread::newFromId($row->comment_id);
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	public function getThreadCount( $master = false ) {
		wfProfileIn(__METHOD__);

		$db = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

		$count = $db->selectField(
			array( 'comments_index' ),
			array( 'count(distinct comment_id) cnt' ),
			array(
				'parent_comment_id' => 0,
				$this->getWhere()
			),
			__METHOD__
		);

		wfProfileOut(__METHOD__);
		return $count;
	}
	
	public function moveAllThread($destWallId) {
//		CommentsIndex::changeParent
	}
	
	public function setMaxPerPage( $val ) {
 		$this->mMaxPerPage = $val;
	}

	public function setSorting( $val ) {
 		$this->mSorting = $val;
	}

	public function invalidateCache() {
		//TODO: implent it
		return true;
	}
}
