<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueItem {
	// What to put in memcached
	static $mCacheVars = array( 'mQueue', 'mCaseID', 'mReason', 'mTimestamp', 'mExpiry', 'mDiscussionPageID', 'mArticleID', 'mVotes' );
	static $cache = array();
	const CACHE_VERSION = 1;
	const CACHE_EXPIRY = 43200; // 12 hours

	protected $mQueue,$mCaseID,$mReason,$mTimestamp,$mExpiry,$mDiscussionPage,$mArticleID,$mArticle,$mRow,$mEndorsements,$mObjections;
	var $mMainLoaded = false, $mLoadedFromMaster = false;

	private function __construct() {}

	/**
	 * Load the deletion queue item for a given page.
	 * @param $article Integer/Article Article object or article ID for the article in question.
	 */
	static function newFromArticle( $article ) {
		if ( $article instanceof Article ) {
			// No need to do anything
		} elseif ( $article instanceof Title ) {
			$article = new Article($article);
		} elseif ( !is_object( $article ) ) {
			$article = new Article( Title::newFromId($article) ); // WTF? Why can't we load an article without a title?
		} else {
			throw new MWException( "Bad argument to DeleteQueueItem constructor (".gettype($article).")" );
		}

		if (isset($article->mDeleteQueueItem) && $article->mDeleteQueueItem instanceof DeleteQueueItem) {
			return $article->mDeleteQueueItem;
		}

		$item = new DeleteQueueItem();

		$item->mArticle = $article;
		$item->mArticleID = $article->getId();

		$article->mDeleteQueueItem = $item;

		return $item;
	}

	/**
	 * Load the deletion queue item for a given deletion discussion page.
	 * @param $page Article object of the deletion discussion page.
	 */
	static function newFromDiscussion( $page ) {
		$item = new DeleteQueueItem();

		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'delete_queue', '*', array( 'dq_discussionpage' => $page->mTitle->getArticleID() ), __METHOD__ );

		wfDebugLog( 'deletequeue', "Got delete_queue row for discussion page ".$page->mTitle->getArticleID() );

		$item->loadFromRow( $row );

		return $item;
	}

	/**
	 * Get the delete_queue row for this item.
	 * @param $useMaster Boolean True to load from the DB master.
	 */
	protected function getRow( $useMaster ) {
		$dbr = wfGetDB( $useMaster ? DB_MASTER : DB_SLAVE );

		$row = $this->mRow = $dbr->selectRow( 'delete_queue', '*', array( 'dq_page' => $this->mArticleID, 'dq_active' => 1 ), __METHOD__ );

		wfDebugLog( 'deletequeue', "Got delete_queue row for article {$this->mArticleID}" );

		return $row;
	}

	/**
	 * Load main row data for this item.
	 * @param $useMaster Boolean True to make a point of using the DB master (for caching)
	 * @param $store Boolean True to cache the data if not already cached (Will load from the master)
	 */
	function loadData($useMaster = false, $store = true) {
		if ($this->mMainLoaded && ($this->mLoadedFromMaster || !( $useMaster || $store ) ) ) {
			// Already loaded.
			return;
		}

		if (!$useMaster) {
			global $wgMemc;

			if ( is_array( $item = $wgMemc->get( $this->cacheKey() ) ) ) {
				$this->loadFromCacheObject( $item );
				return;
			}

			if ( isset(self::$cache[$this->mArticleID]) ) {
				$this->loadFromCacheObject( self::$cache[$this->mArticleID] );
			}
		}

		// Load from master iff $store or $useMaster is set.
		$row = $this->getRow( $store || $useMaster );
		$this->loadFromRow( $row );

		$this->mLoadedFromMaster = $store || $useMaster;

		if ( $store ) {
			wfDebugLog( 'deletequeue', "Storing DeleteQueue item for article {$this->mArticleID} to cache." );
			// Store to cache
			global $wgMemc;

			$item = $this->storeToCacheObject();

			$wgMemc->set( $this->cacheKey(), $item, self::CACHE_EXPIRY );
			self::$cache[$this->mArticleID] = $item;
		}
	}

	/**
	 * Get the key used to store the data in memcached
	 */
	protected function cacheKey() {
		return wfMemcKey( 'DeleteQueueItem', 'Article', $this->mArticleID, self::CACHE_VERSION );
	}

	/**
	 * Load data from a cached array.
	 * @param $item Array from storeToCacheObject()
	 */
	protected function loadFromCacheObject( $item ) {
		foreach( self::$mCacheVars as $var ) {
			if (isset( $item[$var] ))
				$this->$var = $item[$var];
		}

		$this->postLoad();

		wfDebugLog( 'deletequeue', "Loded DeleteQueue item for article {$this->mArticleID} from cache." );
	}

	/**
	 * Load main-row data from a database row.
	 * @param $row Object a row returned from Database::fetchObject
	 */
	public function loadFromRow( $row ) {
		// Reset state
		$this->reset();

		if (!$row) {
			$this->mQueue = '';
			$this->mMainLoaded = true;
			wfDebugLog( 'deletequeue', "Loaded empty DeleteQueue item for article {$this->mArticleID} from DB." );
			return;
		}

		// Stuff that can be loaded straight in.
		$loadVars = array( 'dq_queue' => 'mQueue', 'dq_case' => 'mCaseID', 'dq_reason' => 'mReason', 'dq_discussionpage' => 'mDiscussionPageID', 'dq_page' => 'mArticleID' );

		foreach( $loadVars as $col => $var ) {
			$this->$var = $row->$col;
		}

		$this->mTimestamp = wfTimestamp( TS_MW, $row->dq_timestamp );
		$this->mExpiry = wfTimestamp( TS_MW, $row->dq_expiry );

		$this->postLoad();

		wfDebugLog( 'deletequeue', "Loded DeleteQueue item for article {$this->mArticleID} from DB." );

		$this->mMainLoaded = true;
	}

	/** Reset all variables */
	protected function reset() {
		$vars = array( 'mCaseID', 'mReason', 'mTimestamp', 'mExpiry', 'mDiscussionPage', 'mRow', 'mEndorsements', 'mObjections' );

		foreach( $vars as $var ) {
			$this->$var = null;
		}
	}

	/**
	 * Load related users for a deletion case.
	 */
	function loadRelatedUsers() {
		if ( isset( $this->mRelatedUsers ) && is_array( $this->mRelatedUsers ) ) {
			return;
		}

		if (!$this->isQueued()) {
			return;
		}

		$case_id = $this->mCaseID;

		$users = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'delete_queue_role', '*', array( 'dqr_case' => $case_id ), __METHOD__ );

		while ($row = $dbr->fetchObject( $res )) {
			$users[] = array($row->dqr_user_text, $row->dqr_type);
		}

		$this->mRelatedUsers = $users;
	}

	/**
	 * Load votes.
	 */
	function loadVotes() {
		if( isset( $this->mVotes ) && is_array( $this->mVotes ) ) {
			return;
		}

		if (!$this->isQueued()) {
			return;
		}

		$case_id = $this->mCaseID;

		$this->mVotes = array();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'delete_queue_vote', '*', array( 'dqv_case' => $case_id ), __METHOD__, array( 'ORDER BY' => 'dqv_timestamp DESC' ) );

		while ($row = $dbr->fetchObject( $res )) {
			$this_vote = array();
			// Load simple stuff
			$row_mappings = array( 'dqv_user_text' => 'user', 'dqv_comment' => 'comment', 'dqv_current' => 'current' );

			foreach( $row_mappings as $col => $field ) {
				$this_vote[$field] = $row->$col;
			}

			// More difficult stuff.
			$this_vote['timestamp'] = wfTimestamp( TS_MW, $row->dqv_timestamp );
			$this_vote['type'] = $type = $row->dqv_endorse ? 'endorse' : 'object';

			$this->mVotes[] = $this_vote;
		}

		$this->postLoad();
	}

	/**
	 * Load all lazy-loaded data.
	 * Used for caching.
	 */
	function loadAllData() {
		$this->loadData( true );
		$this->loadRelatedUsers( true );
		$this->loadVotes( true );
	}

	/**
	 * Store the data in the cache.
	 * @return Array suitable for storing in memcached.
	 */
	protected function storeToCacheObject() {
		$this->loadAllData();
		$item = array();
		foreach( self::$mCacheVars as $var ) {
			if ( isset( $this->$var ) )
				$item[$var] = $this->$var;
		}
		return $item;
	}

	/**
	 * Stuff that needs to be done after loading new data.
	 */
	protected function postLoad() {
		if (isset($this->mDiscussionPageID)) {
			$this->mDiscussionPage = Article::newFromId( $this->mDiscussionPageID );
		}

		$this->mArticle = Article::newFromId( $this->mArticleID );

		// Split votes.
		if ( isset($this->mVotes) && count($this->mVotes) ) {
			$this->mVotesEndorse = array();
			$this->mVotesObject = array();

			foreach( $this->mVotes as $vote ) {
				$type = ucfirst($vote['type']);
				$arr_name = "mVotes$type";

				$this->{$arr_name}[] = $vote;
			}
		} elseif (isset($this->mVotes)) {
			// Clear them.
			$this->mVotesEndorse = array();
			$this->mVotesObject = array();
		}
	}

	/**
	 * Adds user to $role
	 * @param string $role The role to set.
	 * @param User $user The user to assign to that role. Optional.
	 */
	public function addRole( $role, $user=null ) {
		if (!$this->getCaseID())
			return; // Case doesn't exist anymore.
			
		if ( $user == null ) {
			global $wgUser;
			$user = $wgUser;
		}

		if (!$this->isQueued()) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->replace( 'delete_queue_role', array( array('dqr_case', 'dqr_user', 'dqr_type') ), array( 'dqr_case' => $this->getCaseID(), 'dqr_user' => $user->getId(), 'dqr_user_text' => $user->getName(), 'dqr_type' => $role ), __METHOD__ );
		
		$this->purge();
	}

	/**
	 * Adds vote for user, changing as necessary.
	 * @param string $action Either 'endorse' or 'object'.
	 * @param string $comments Comments made by the user.
	 * @param string $user The user who's voted (Optional)
	 */
	public function addVote( $action, $comments, $user = null ) {
		if (!$this->getCaseID())
			return; // Case doesn't exist anymore.
	
		if ( $user == null ) {
			global $wgUser;
			$user = $wgUser;
		}

		// Begin transaction
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		// Mark old votes as non-current
		$dbw->update( 'delete_queue_vote', array( 'dqv_current' => 0 ), array( 'dqv_case' => $this->getCaseID(), 'dqv_user' => $user->getId() ), __METHOD__ );

		// Add new vote
		$dbw->insert( 'delete_queue_vote',
			array( 'dqv_case' => $this->getCaseID(), 'dqv_user' => $user->getId(), 'dqv_user_text' => $user->getName(), 'dqv_comment' => $comments,
				'dqv_endorse' => ($action == 'endorse'), 'dqv_timestamp' => $dbw->timestamp( wfTimestampNow() )
			), __METHOD__ );

		// Add user as voter
		$this->addRole( "vote-$action" );

		$dbw->commit();
		
		$this->purge();
	}

	/**
	 * Moves this article to a different queue
	 * @param string $queue The queue to place the article in.
	 * @param string $reason The reason for deletion.
	 * @param string $timestamp Timestamp in database format. Optional.
	 */
	public function setQueue( $queue, $reason, $timestamp = null ) {
	
		if (!$this->getCaseID())
			return; // Case doesn't exist anymore.
	
		$dbw = wfGetDB( DB_MASTER );

		if ($timestamp == null) {
			$timestamp = $dbw->timestamp( wfTimestampNow( TS_MW ) );
		}

		$row = array();

		$article = $this->getArticle();

		if ($queue == 'deletediscuss') {
			// We need to create the relevant page, etc.

			// Generate new page name.
			$base = $article->mTitle->getPrefixedText();
			$articleName = $article->mTitle->getPrefixedText();

			$title = Title::makeTitle( NS_DELETION, $base );
			$i=1;
			while ($title->exists()) {
				$i++;
				$title = Title::makeTitle( NS_DELETION, "$base $i" );
			}

			// Create the page.
			$discusspage = new Article( $title );
			$discusspage->doEdit( wfMsgForContent('deletequeue-discusscreate-text', $base, $reason) . ' ~~~~', wfMsgForContent('deletequeue-discusscreate-summary', $base), EDIT_NEW | EDIT_SUPPRESS_RC );

			$row['dq_discussionpage'] = $discusspage->getId();
		}

		global $wgDeleteQueueExpiry;
		$expiry = $dbw->timestamp( time() + $wgDeleteQueueExpiry[$queue] );

		$row['dq_page'] = $article->getId();
		$row['dq_queue'] = $queue;
		$row['dq_reason'] = $reason;
		$row['dq_timestamp'] = $timestamp;
		$row['dq_expiry'] = $expiry;

		$dbw->replace( 'delete_queue', array( 'dq_page' ), $row, __METHOD__ );

		$this->purge();
	}

	/** Purge the cache of this deletion item. */
	public function purge() {
		// Reload new data from the master.
		$this->loadData(true);

		if ($this->getArticle()->mTitle) {
			$this->getArticle()->mTitle->invalidateCache();
			$this->getArticle()->mTitle->purgeSquid();
		}
	}

	/**
	 * Remove this page from all queues
	 */
	public function deQueue(  ) {
		$dbw = wfGetDB( DB_MASTER );
		
		if (!$this->getCaseID())
			return; // Case doesn't exist anymore.

		$dbw->update( 'delete_queue', array( 'dq_active' => 0 ), array( 'dq_case' => $this->getCaseID() ), __METHOD__ );

		$this->purge();
	}

	/**
	 * Gets a user's role(s) in a case.
	 */
	public function getUserRoles( $user ) {
		if (!$this->isQueued()) {
			return array();
		}

		$relatedUsers = $this->getRelatedUsers();

		if ($user instanceof User) {
			$user = $user->getName();
		}

		$roles = array();

		// Work through the users.
		foreach( $relatedUsers as $data ) {
			list ($name,$role) = $data;
			if ($name == $user) {
				$roles[$role] = 1;
			}
		}

		return array_keys($roles);
	}

	/** Lazy accessors */

	/**
	 * Lazy accessor template
	 * @param $field The name of the field to access.
	 * @param $func The load function to call first.
	 * @return The value of the field.
	 */
	protected function lazyAccessor( $field, $func = 'loadData' ) {
		// Ironically, I was too lazy to write this out in all lazy accessors.
		$this->$func();
		return $this->$field;
	}

	/**
	 * Gets a list of users and their roles with regard to a case.
	 */
	public function getRelatedUsers( ) {
		$this->loadRelatedUsers();

		return $this->mRelatedUsers;
	}

	/** Get a brief description for a role */
	public static function getRoleDescription( $role ) {
		return wfMsg( "deletequeue-role-$role" );
	}

	function getQueue() 		{ return $this->lazyAccessor( 'mQueue' ); }
	function getCaseID() 		{ return $this->lazyAccessor( 'mCaseID' ); }
	function getReason() 		{ return $this->lazyAccessor( 'mReason' ); }
	function getTimestamp() 	{ return $this->lazyAccessor( 'mTimestamp' ); }
	function getExpiry() 		{ return $this->lazyAccessor( 'mExpiry' ); }
	function getDiscussionPage() 	{ return $this->lazyAccessor( 'mDiscussionPage' ); }
	function getArticle() 		{ return $this->lazyAccessor( 'mArticle' ); }
	function getArticleID() 	{ return $this->lazyAccessor( 'mArticleID' ); }
	function isQueued()		{ return $this->getQueue() != 'null'; }
	function getVotes()		{ return $this->lazyAccessor( 'mVotes', 'loadVotes' ); }
	function getEndorsements()	{ return $this->lazyAccessor( 'mVotesEndorse', 'loadVotes' ); }
	function getObjections()	{ return $this->lazyAccessor( 'mVotesObject', 'loadVotes' ); }
	function getObjectionCount()	{ return count($this->getObjections()); }
	function getEndorsementCOunt()	{ return count($this->getEndorsements()); }

	static function filterActiveVotes($votes) {
		$return = array();

		foreach( $votes as $vote ) {
			if ($vote['current']) {
				$return[] = $vote;
			}
		}

		return $return;
	}

	function getActiveObjections() { return self::filterActiveVotes( $this->getObjections() ); }
	function getActiveEndorsements() { return self::filterActiveVotes( $this->getEndorsements() ); }
	function getActiveEndorseCount() { return count($this->getActiveEndorsements()); }
	function getActiveObjectCount() { return count($this->getActiveObjections()); }
}
