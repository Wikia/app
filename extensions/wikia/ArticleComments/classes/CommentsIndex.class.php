<?php

/**
 * CommentsIndex Class
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

class CommentsIndex extends WikiaModel {

	protected $parentPageId = 0;
	protected $commentId = 0;
	protected $parentCommentId = 0;
	protected $lastChildCommentId = 0;
	protected $archived = 0;
	protected $deleted = 0;
	protected $removed = 0;
	protected $locked = 0;
	protected $protected = 0;
	protected $sticky = 0;
	protected $firstRevId = 0;
	protected $createdAt = 0;
	protected $lastRevId = 0;
	protected $lastTouched = 0;
	protected $namespace = 0;
	protected $data = array();
	private $dbw = null;

	public function __construct( $data = array(), $dbw = null ) {
		$this->data = $data;
		$this->dbw = $dbw;

		foreach ( $data as $key => $value ) {
			$this->$key = $value;
		}

		parent::__construct();
	}

	public function __clone() {
		return new CommentsIndex([
			'parentPageId' =>  $this->parentPageId,
			'commentId' => $this->commentId,
			'parentCommentId' => $this->parentCommentId,
			'lastChildCommentId' => $this->lastChildCommentId,
			'archived' => $this->archived,
			'deleted' => $this->deleted,
			'removed' => $this->removed,
			'locked' => $this->locked,
			'protected' => $this->protected,
			'sticky' => $this->sticky,
			'firstRevId' => $this->firstRevId,
			'createdAt' => $this->createdAt,
			'lastRevId' => $this->lastRevId,
			'lastTouched' => $this->lastTouched,
			'namespace' => $this->namespace
		]);
	}

	/**
	 * Set the database connection used by the CommentsIndex object
	 */
	private function setDB( $dbw ) {
		$this->dbw = $dbw;
	}

	/*
	 * When posting on Wall or Forum, new CommentsIndex object is created. This object is used several times
	 * later in this request. We're caching those fresh instances of CommentsIndex, as fetching them from
	 * database would result in unnecessary queries to master db
	 */
	private static $objectCache = [];

	private function cache() {
		if ( $this->commentId ) {
			self::$objectCache[ $this->commentId ] = $this;
		}
	}

	public function setCommentId( $value ) {
		$this->commentId = $value;
	}

	/**
	 * update archived flag
	 * @param integer $value
	 */
	public function updateArchived( $value = 1 ) {
		$updateValue = array( 'archived' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update deleted flag
	 * @param integer $value
	 */
	public function updateDeleted( $value = 1 ) {
		$updateValue = array(
			'deleted' => $value,
		);
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update removed flag
	 * @param integer $value
	 */
	public function updateRemoved( $value = 1 ) {
		$updateValue = array(
			'removed' => $value,
		);
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update locked flag
	 * @param integer $value
	 */
	public function updateLocked( $value = 1 ) {
		$updateValue = array( 'locked' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update protected flag
	 * @param integer $value
	 */
	public function updateProtected( $value = 1 ) {
		$updateValue = array( 'protected' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update sticky flag
	 * @param integer $value
	 */
	public function updateSticky( $value = 1 ) {
		$updateValue = array( 'sticky' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update last revision id
	 * @param integer $value
	 */
	public function updateLastRevId( $value ) {
		$updateValue = array( 'last_rev_id' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * update last child comment id
	 * @param integer $value
	 */
	public function updateLastChildCommentId( $value ) {
		$updateValue = array( 'last_child_comment_id' => $value );
		$this->updateDatabase( $updateValue );
	}

	/**
	 * check if deleted flag is set
	 * @return boolean
	 */
	public function isDeleted() {
		return ( $this->deleted == 1 );
	}

	/**
	 * check if removed flag is set
	 * @return boolean
	 */
	public function isRemoved() {
		return ( $this->removed == 1 );
	}

	/**
	 * check if archived flag is set
	 * @return boolean
	 */
	public function isArchieved() {
		return ( $this->archived == 1 );
	}

	/**
	 * check if locked flag is set
	 * @return boolean
	 */
	public function isLocked() {
		return ( $this->locked == 1 );
	}

	/**
	 * check if protected flag is set
	 * @return boolean
	 */
	public function isProtected() {
		return ( $this->protected == 1 );
	}

	/**
	 * check if sticky flag is set
	 * @return boolean
	 */
	public function isSticky() {
		return ( $this->sticky == 1 );
	}

	/**
	 * update data in the database
	 * @param array updateValue [ array( field => value ) ]
	 * [ field = archived, deleted, removed, locked, protected, sticky, last_rev_id, last_child_comment_id ]
	 */
	protected function updateDatabase( $updateValue ) {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() && !empty($this->commentId) ) {
			$this->createTableCommentsIndex();

			$db = $this->dbw ? $this->dbw : wfGetDB( DB_MASTER );

			$updateValue['last_touched'] = $db->timestamp();

			foreach ( $updateValue as $key => $value ) {
				$this->$key = $value;
			}

			$db->update(
				'comments_index',
				$updateValue,
				array( 'comment_id' => $this->commentId ),
				__METHOD__
			);

			// if $dbw was passed, this is a part of some outside transaction, so we don't commit anything yet
			if ( is_null( $this->dbw ) ) {
				$db->commit();
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * add comment to database
	 * this assumes that wfReadOnly was called before and we're safe to write to master (see DAR-120 for details)
	 */
	public function addToDatabase() {

		wfProfileIn( __METHOD__ );


		$this->createTableCommentsIndex();
		$db = $this->dbw ? $this->dbw : wfGetDB( DB_MASTER );
		$timestamp = $db->timestamp();
		if ( empty($this->createdAt) ) {
			$this->createdAt = $timestamp;
		}
		if ( empty($this->lastTouched) ) {
			$this->lastTouched = $timestamp;
		}

		if ( $this->lastChildCommentId == 0 ) {
			$this->lastChildCommentId = $this->commentId;
		}

		//cache the new instance so we won't have to query the db when we need it again during this request
		$this->cache();

		$status = $db->replace(
			'comments_index',
			'',
			array(
				'parent_page_id' => $this->parentPageId,
				'comment_id' => $this->commentId,
				'parent_comment_id' => $this->parentCommentId,
				'last_child_comment_id' => $this->lastChildCommentId,
				'archived' => $this->archived,
				'deleted' => $this->deleted,
				'removed' => $this->removed,
				'locked' => $this->locked,
				'protected' => $this->protected,
				'sticky' => $this->sticky,
				'first_rev_id' => $this->firstRevId,
				'created_at' => $this->createdAt,
				'last_rev_id' => $this->lastRevId,
				'last_touched' => $this->lastTouched,
			),
			__METHOD__
		);
		if ( false === $status ) {
			Wikia::log(__FUNCTION__, __LINE__, "WALL_COMMENTS_INDEX_ERROR Failed to create comments_index entry, parent_page_id={$this->parentPageId}, comment_id={$this->commentId}, parent_comment_id={$this->parentCommentId}", true);
		}

		// if $dbw was passed, this is a part of some outside transaction, so we don't commit anything yet
		if ( is_null( $this->dbw ) ) {
			$db->commit();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * create comments_index table if not exists
	 */
	public function createTableCommentsIndex() {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() ) {
			$db = $this->dbw ? $this->dbw : wfGetDB( DB_MASTER );

			if ( !$db->tableExists('comments_index') ) {
				$source = dirname(__FILE__) . "/../patch-create-comments_index.sql";
				$db->sourceFile( $source );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get CommentsIndex object from id
	 * @param integer $commentId
	 * @param integer $parentPageId
	 * @return object $comment
	 */
	public static function newFromId( $commentId, $parentPageId = 0, $dbw = null ) {

		wfProfileIn( __METHOD__ );

		$sqlWhere = array( 'comment_id' => $commentId );
		if ( !empty($parentPageId) ) {
			$sqlWhere['parent_page_id'] = $parentPageId;
		} else {
			// instances created during this requests are stored in the cache, so we don't call the db to fetch them
			if ( isset( self::$objectCache[ $commentId ] ) ) {
				error_log("MECH NEW returning cached object for id " . $commentId);
				$ci = clone self::$objectCache[ $commentId ];
				$ci->setDB( $dbw );
				return $ci;
			}

		}

		$db = $dbw ? $dbw : wfGetDB( DB_SLAVE );

		$row = self::selectRow( $db, $sqlWhere );

		if( empty($row) ) {
			$db = wfGetDB( DB_MASTER );
			$row = self::selectRow( $db, $sqlWhere );	
		}

		if ( $row ) {
			$comment = self::newFromRow( $row, $dbw );
			// reset parent page id
			if ( !empty($parentPageId) ) {
				$comment->parentPageId = $parentPageId;
			}
		} else {
			$comment = null;
		}

		wfProfileOut( __METHOD__ );

		return $comment;
	}
	
	/**
	 * just select the row form comment index
	 */
	 
	 public static function selectRow($db, $sqlWhere) {
	 	$row = $db->selectRow(
			'comments_index',
			'*',
			$sqlWhere,
			__METHOD__,
			array( 'LIMIT' => 1 )
		);	
		return $row;
	 }

	/**
	 * get CommentsIndex object from row
	 * @param array row
	 * @return array comment
	 */
	public static function newFromRow( $row, $dbw = null ) {
		$data = array(
			'parentPageId' => $row->parent_page_id,
			'commentId' => $row->comment_id,
			'parentCommentId' => $row->parent_comment_id,
			'lastChildCommentId' => $row->last_child_comment_id,
			'archived' => $row->archived,
			'deleted' => $row->deleted,
			'removed' => $row->removed,
			'locked' => $row->locked,
			'protected' => $row->protected,
			'sticky' => $row->sticky,
			'firstRevId' => $row->first_rev_id,
			'createdAt' => $row->created_at,
			'lastRevId' => $row->last_rev_id,
			'lastTouched' => $row->last_touched,
		);
		
		$comment = new CommentsIndex($data, $dbw);

		return $comment;
	}

	/**
	 * get last revision id of the comment
	 * @return integer
	 */
	protected function getArticleLastRevId() {
		$article = Article::newFromID($this->commentId);
		return $article->getRevIdFetched();
	}

	/**
	 * update last child comment id of the parent comment
	 * @param integer $lastChildCommentId
	 */
	public function updateParentLastCommentId( $lastChildCommentId ) {
		wfProfileIn( __METHOD__ );

		if ( !empty($this->parentCommentId) ) {
			$data = array( 'commentId' => $this->parentCommentId );
			$parent = new CommentsIndex($data, $this->dbw);
			$parent->updateLastChildCommentId( $lastChildCommentId );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get last comment id of the parent comment
	 * @param boolean $useMaster
	 * @return integer $lastCommentId
	 */
	public function getParentLastCommentId( $useMaster = false ) {
		wfProfileIn( __METHOD__ );

		$dbname = ( $useMaster ) ? DB_MASTER : DB_SLAVE ;
		$db = wfGetDB( $dbname );

		$row = $db->selectRow(
			array( 'comments_index' ),
			array( 'max(comment_id) last_comment_id' ),
			array(
				'parent_comment_id' => $this->parentCommentId,
				'archived' => 0,
				'removed' => 0,
				'deleted' => 0,
			),
			__METHOD__
		);

		$lastCommentId = 0;
		if ( $row ) {
			$lastCommentId = $row->last_comment_id;
		}

		wfProfileOut( __METHOD__ );

		return $lastCommentId;
	}

	/**
	 * get of parent page id
	 * @return int $parentPageId
	 */
	public function getParentPageId() {
		return $this->parentPageId;
	}

	/**
	 * get parent comemnt index
	 */

	public function getParentCommentId() {
		return $this->parentCommentId;
	}
	
	/**
	 *  fast moving of comment from one page to another
	 */ 
	public static function changeParent($from, $to, $parent_comment = null) {
		$db = wfGetDB( DB_MASTER );

		if(!empty($parent_comment)) {
			$where = array( "parent_comment_id = ". $parent_comment ." or comment_id = ". $parent_comment );
		} else {
			$where = array( 'parent_page_id' => $from );
			
		}

		$db->update(
			'comments_index',
			array( 'parent_page_id' => $to ),
			$where,
			__METHOD__
		);
		
		$db->commit();
	}

	/**
	 * LoadExtensionSchemaUpdates handler; set up comments_index table on install/upgrade.
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	static public function onLoadExtensionSchemaUpdates( $updater = null ) {
		$map = array(
			'mysql' => 'patch-create-comments_index.sql',
		);

		$type = $updater->getDB()->getType();
		if( isset( $map[$type] ) ) {
			$sql = dirname( __FILE__ ) . "/../" . $map[ $type ];
			$updater->addExtensionTable( 'comments_index', $sql );
		} else {
			throw new MWException( "Comments extension does not currently support $type database." );
		}
		return true;

	}

	/*
	 * We need some data in order to create CommentIndex objects inside the MW transaction creating the article
	 */
	private static $commentInfoData = [];

	/**
	 * Store the information about new comment, so it can be used for creating CommentsIndex instances inside
	 * MW transaction (ArticleDoEdit hook)
	 */
	static public function addCommentInfo($commentTitleText, $userPageTitle, $parentId) {
		$entry = new stdClass();
		$entry->userPageTitle = $userPageTitle;
		$entry->parentId = $parentId;

		self::$commentInfoData[ $commentTitleText ] = $entry;
	}

	/**
	 * Hook into MW transaction that creates new article comments and execute queries that create comments_index entries
	 * @param $dbw database connetion
	 * @param Title $title newly created article
	 * @param Revision $revision revision containig the lastest version of article comment
	 * @param $flags Integer bitfield, the same as in WikiPage::doEdit method
	 */
	static public function onArticleDoEdit( $dbw, Title $title, Revision $revision, $flags) {
		global $wgEnableWallEngine;

		if ( !empty( $wgEnableWallEngine ) && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			if ( $flags & EDIT_NEW ) {
				$titleText = $title->getText();
				if ( isset( self::$commentInfoData[ $titleText] ) ) {
					$data = array(
						'namespace' => self::$commentInfoData[ $titleText]->userPageTitle->getNamespace(),
						'parentPageId' => self::$commentInfoData[ $titleText]->userPageTitle->getArticleID(),
						'commentId' => $title->getArticleID(),
						'parentCommentId' => intval(self::$commentInfoData[ $titleText]->parentId),
						'firstRevId' => $revision->getId(),
						'lastRevId' => $revision->getId(),
					);

					$commentsIndex = new CommentsIndex( $data, $dbw );
					$commentsIndex->addToDatabase();

					$commentsIndex->updateParentLastCommentId( $data['commentId'] );
				}

			} else {
				$commentsIndex = CommentsIndex::newFromId( $title->getArticleID(), 0, $dbw );
				if ( $commentsIndex instanceof CommentsIndex ) {
					$commentsIndex->updateLastRevId( $revision->getId() );

				}
			}
		}

		return true;
	}

}
