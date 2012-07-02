<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class Thread {
	/* SCHEMA changes must be reflected here. */

	/* ID references to other objects that are loaded on demand: */
	protected $rootId;
	protected $articleId;
	protected $summaryId;
	protected $ancestorId;
	protected $parentId;

	/* Actual objects loaded on demand from the above when accessors are called: */
	protected $root;
	protected $article;
	protected $summary;
	protected $superthread;
	protected $ancestor;

	/* Subject page of the talkpage we're attached to: */
	protected $articleNamespace;
	protected $articleTitle;

	/* Timestamps: */
	protected $modified;
	protected $created;
	protected $sortkey;

	protected $id;
	protected $type;
	protected $subject;
	protected $authorId;
	protected $authorName;
	protected $signature;

	protected $allDataLoaded;

	protected $isHistorical = false;

	protected $rootRevision;

	/* Flag about who has edited or replied to this thread. */
	public $editedness;
	protected $editors = null;

	protected $replies;
	protected $reactions;

	public $dbVersion; // A copy of the thread as it exists in the database.

	static $titleCacheById = array();
	static $replyCacheById = array();
	static $articleCacheById = array();
	static $reactionCacheById = array();

	static $VALID_TYPES = array( Threads::TYPE_NORMAL, Threads::TYPE_MOVED, Threads::TYPE_DELETED );

	function isHistorical() {
		return $this->isHistorical;
	}

	static function create( $root, $article, $superthread = null,
				$type = Threads::TYPE_NORMAL, $subject = '',
				$summary = '', $bump = null, $signature = null ) {

		$thread = new Thread( null );

		if ( !in_array( $type, self::$VALID_TYPES ) ) {
			throw new MWException( __METHOD__ . ": invalid change type $type." );
		}

		if ( $superthread ) {
			$change_type = Threads::CHANGE_REPLY_CREATED;
		} else {
			$change_type = Threads::CHANGE_NEW_THREAD;
		}

		global $wgUser;

		$thread->setAuthor( $wgUser );

		if ( is_object( $root ) ) {
			$thread->setRoot( $root );
		} else {
			$thread->setRootId( $root );
		}

		$thread->setSuperthread( $superthread );
		$thread->setArticle( $article );
		$thread->setSubject( $subject );
		$thread->setType( $type );

		if ( !is_null( $signature ) ) {
			$thread->setSignature( $signature );
		}

		$thread->insert();

		if ( $superthread ) {
			$superthread->addReply( $thread );

			$superthread->commitRevision( $change_type, $thread, $summary, $bump );
		} else {
			$hthread = ThreadRevision::create( $thread, $change_type );
		}

		// Create talk page
		Threads::createTalkpageIfNeeded( $article );

		// Notifications
		NewMessages::writeMessageStateForUpdatedThread( $thread, $change_type, $wgUser );

		if ( $wgUser->getOption( 'lqt-watch-threads', false ) ) {
			WatchAction::doWatch( $thread->topmostThread()->root()->getTitle(), $wgUser );
		}

		return $thread;
	}

	function insert() {
		$this->dieIfHistorical();
		
		if ( $this->id() ) {
			throw new MWException( "Attempt to insert a thread that already exists." );
		}

		$dbw = wfGetDB( DB_MASTER );

		$row = $this->getRow();
		$row['thread_id'] = $dbw->nextSequenceValue( 'thread_thread_id' );

		$dbw->insert( 'thread', $row, __METHOD__ );
		$this->id = $dbw->insertId();

		// Touch the root
		if ( $this->root() ) {
			$this->root()->getTitle()->invalidateCache();
		}

		// Touch the talk page, too.
		$this->getTitle()->invalidateCache();

		$this->dbVersion = clone $this;
		unset( $this->dbVersion->dbVersion );
	}

	function setRoot( $article ) {
		$this->rootId = $article->getId();
		$this->root = $article;
		
		if ( $article->getTitle()->getNamespace() != NS_LQT_THREAD ) {
			throw new MWException( "Attempt to set thread root to a non-Thread page" );
		}
	}

	function setRootId( $article ) {
		$this->rootId = $article;
		$this->root = null;
	}

	function commitRevision( $change_type, $change_object = null, $reason = "",
					$bump = null ) {
		$this->dieIfHistorical();
		global $wgUser;

		global $wgThreadActionsNoBump;
		if ( is_null( $bump ) ) {
			$bump = !in_array( $change_type, $wgThreadActionsNoBump );
		}
		if ( $bump ) {
			$this->sortkey = wfTimestamp( TS_MW );
		}

		$original = $this->dbVersion;

		$this->modified = wfTimestampNow();
		$this->updateEditedness( $change_type );
		$this->save( __METHOD__ . "/" . wfGetCaller() );

		$topmost = $this->topmostThread();
		$topmost->modified = wfTimestampNow();
		if ( $bump ) $topmost->setSortkey( wfTimestamp( TS_MW ) );
		$topmost->save();

		ThreadRevision::create( $this, $change_type, $change_object, $reason );
		$this->logChange( $change_type, $original, $change_object, $reason );

		if ( $change_type == Threads::CHANGE_EDITED_ROOT ) {
			NewMessages::writeMessageStateForUpdatedThread( $this, $change_type, $wgUser );
		}
	}

	function logChange( $change_type, $original, $change_object = null, $reason = '' ) {
		$log = new LogPage( 'liquidthreads' );

		if ( is_null( $reason ) ) {
			$reason = '';
		}

		switch( $change_type ) {
			case Threads::CHANGE_MOVED_TALKPAGE:
				$log->addEntry( 'move', $this->title(), $reason,
					array( $original->getTitle(),
						$this->getTitle() ) );
				break;
			case Threads::CHANGE_SPLIT:
				$log->addEntry( 'split', $this->title(), $reason,
					array( $this->subject(),
						$original->superthread()->title()
					) );
				break;
			case Threads::CHANGE_EDITED_SUBJECT:
				$log->addEntry( 'subjectedit', $this->title(), $reason,
					array( $original->subject(), $this->subject() ) );
				break;
			case Threads::CHANGE_MERGED_TO:
				$oldParent = $change_object->dbVersion->isTopmostThread()
						? ''
						: $change_object->dbVersion->superthread()->title();


				$log->addEntry( 'merge', $this->title(), $reason,
					array( $oldParent, $change_object->superthread()->title() ) );
				break;
			case Threads::CHANGE_ADJUSTED_SORTKEY:
				$log->addEntry( 'resort', $this->title(), $reason,
					array( $original->sortkey(), $this->sortkey() ) );
		}
	}

	function updateEditedness( $change_type ) {
		global $wgUser;

		if ( $change_type == Threads::CHANGE_REPLY_CREATED
				&& $this->editedness == Threads::EDITED_NEVER ) {
			$this->editedness = Threads::EDITED_HAS_REPLY;
		} elseif ( $change_type == Threads::CHANGE_EDITED_ROOT ) {
			$originalAuthor = $this->author();

			if ( ( $wgUser->getId() == 0 && $originalAuthor->getName() != $wgUser->getName() )
					|| $wgUser->getId() != $originalAuthor->getId() ) {
				$this->editedness = Threads::EDITED_BY_OTHERS;
			} elseif ( $this->editedness == Threads::EDITED_HAS_REPLY ) {
				$this->editedness = Threads::EDITED_BY_AUTHOR;
			}
		}
	}

	/** Unless you know what you're doing, you want commitRevision */
	function save( $fname = null ) {
		$this->dieIfHistorical();

		$dbr = wfGetDB( DB_MASTER );

		if ( !$fname ) {
			$fname = __METHOD__ . "/" . wfGetCaller();
		} else {
			$fname = __METHOD__ . "/" . $fname;
		}

		$dbr->update( 'thread',
		     /* SET */ $this->getRow(),
		     /* WHERE */ array( 'thread_id' => $this->id, ),
		     $fname );

		// Touch the root
		if ( $this->root() ) {
			$this->root()->getTitle()->invalidateCache();
		}

		// Touch the talk page, too.
		$this->getTitle()->invalidateCache();

		$this->dbVersion = clone $this;
		unset( $this->dbVersion->dbVersion );
	}

	function getRow() {
		$id = $this->id();

		$dbw = wfGetDB( DB_MASTER );

		if ( !$id ) {
			$id = $dbw->nextSequenceValue( 'thread_thread_id' );
		}

		// If there's no root, bail out with an error message
		if ( ! $this->rootId && ! ($this->type & Threads::TYPE_DELETED) ) {
			throw new MWException( "Non-deleted thread saved with empty root ID" );
		}

		if ( $this->replyCount < -1 ) {
			wfWarn( "Saving thread $id with negative reply count {$this->replyCount} " . wfGetAllCallers() );
			$this->replyCount = -1;
		}

		// Reflect schema changes here.

		return array(
			'thread_id' => $id,
			'thread_root' => $this->rootId,
			'thread_parent' => $this->parentId,
			'thread_article_namespace' => $this->articleNamespace,
			'thread_article_title' => $this->articleTitle,
			'thread_article_id' => $this->articleId,
			'thread_modified' => $dbw->timestamp( $this->modified ),
			'thread_created' => $dbw->timestamp( $this->created ),
			'thread_ancestor' => $this->ancestorId,
			'thread_type' => $this->type,
			'thread_subject' => $this->subject,
			'thread_author_id' => $this->authorId,
			'thread_author_name' => $this->authorName,
			'thread_summary_page' => $this->summaryId,
			'thread_editedness' => $this->editedness,
			'thread_sortkey' => $this->sortkey,
			'thread_replies' => $this->replyCount,
			'thread_signature' => $this->signature,
		);
	}

	function author() {
		if ( $this->authorId ) {
			return User::newFromId( $this->authorId );
		} else {
			// Do NOT validate username. If the user did it, they did it.
			return User::newFromName( $this->authorName, false /* no validation */ );
		}
	}

	function delete( $reason, $commit = true ) {
		if ( $this->type == Threads::TYPE_DELETED ) {
			return;
		}
		
		$this->type = Threads::TYPE_DELETED;
		
		if ( $commit ) {
			$this->commitRevision( Threads::CHANGE_DELETED, $this, $reason );
		} else {
			$this->save( __METHOD__ );
		}
		/* Mark thread as read by all users, or we get blank thingies in New Messages. */

		$this->dieIfHistorical();

		$dbw = wfGetDB( DB_MASTER );

 		$dbw->delete( 'user_message_state', array( 'ums_thread' => $this->id() ),
 						__METHOD__ );

		// Fix reply count.
		$t = $this->superthread();

		if ( $t ) {
			$t->decrementReplyCount( 1 + $this->replyCount() );
			$t->save();
		}
	}

	function undelete( $reason ) {
		$this->type = Threads::TYPE_NORMAL;
		$this->commitRevision( Threads::CHANGE_UNDELETED, $this, $reason );

		// Fix reply count.
		$t = $this->superthread();
		if ( $t ) {
			$t->incrementReplyCount( 1 );
			$t->save();
		}
	}

	function moveToPage( $title, $reason, $leave_trace ) {
		if ( !$this->isTopmostThread() )
			throw new MWException( "Attempt to move non-toplevel thread to another page" );

		$this->dieIfHistorical();

		$dbr = wfGetDB( DB_MASTER );

		$oldTitle = $this->getTitle();
		$newTitle = $title;

		$new_articleNamespace = $title->getNamespace();
		$new_articleTitle = $title->getDBkey();
		$new_articleID = $title->getArticleID();

		if ( !$new_articleID ) {
			$article = new Article( $newTitle );
			Threads::createTalkpageIfNeeded( $article );
			$new_articleID = $article->getId();
		}

		// Update on *all* subthreads.
		$dbr->update(
			'thread',
			array(
				'thread_article_namespace' => $new_articleNamespace,
				'thread_article_title' => $new_articleTitle,
				'thread_article_id' => $new_articleID,
			),
			array( 'thread_ancestor' => $this->id() ),
			__METHOD__
		);

		$this->articleNamespace = $new_articleNamespace;
		$this->articleTitle = $new_articleTitle;
		$this->articleId = $new_articleID;
		$this->article = null;

		$this->commitRevision( Threads::CHANGE_MOVED_TALKPAGE, null, $reason );

		if ( $leave_trace ) {
			$this->leaveTrace( $reason, $oldTitle, $newTitle );
		}
	}

	// Drop a note at the source location of a move, noting that a thread was moved from
	//  there.
	function leaveTrace( $reason, $oldTitle, $newTitle ) {
		$this->dieIfHistorical();

		// Create redirect text
		$mwRedir = MagicWord::get( 'redirect' );
		$redirectText = $mwRedir->getSynonym( 0 ) .
			' [[' . $this->title()->getPrefixedText() . "]]\n";

		// Make the article edit.
		$traceTitle = Threads::newThreadTitle( $this->subject(), new Article( $oldTitle ) );
		$redirectArticle = new Article( $traceTitle );
		$redirectArticle->doEdit( $redirectText, $reason, EDIT_NEW | EDIT_SUPPRESS_RC );

		// Add the trace thread to the tracking table.
		$thread = Thread::create( $redirectArticle, new Article( $oldTitle ), null,
		 	Threads::TYPE_MOVED, $this->subject() );

		 $thread->setSortkey( $this->sortkey() );
		 $thread->save();
	}

	// Lists total reply count, including replies to replies and such
	function replyCount() {
		// Populate reply count
		if ( $this->replyCount == - 1 ) {
			if ( $this->isTopmostThread() ) {
				$dbr = wfGetDB( DB_SLAVE );

				$count = $dbr->selectField( 'thread', 'count(*)',
					array( 'thread_ancestor' => $this->id() ), __METHOD__ );
			} else {
				$count = self::recursiveGetReplyCount( $this );
			}

			$this->replyCount = $count;
			$this->save();
		}

		return $this->replyCount;
	}

	function incrementReplyCount( $val = 1 ) {
		$this->replyCount += $val;

		wfDebug( "Incremented reply count for thread " . $this->id() . " to " . $this->replyCount . "\n" );

		$thread = $this->superthread();

		if ( $thread ) {
			$thread->incrementReplyCount( $val );
			wfDebug( "Saving Incremented thread " . $thread->id() .
				" with reply count " . $thread->replyCount . "\n" );
			$thread->save();
		}
	}

	function decrementReplyCount( $val = 1 ) {
		$this->incrementReplyCount( - $val );
	}

	static function newFromRow( $row ) {
		$id = $row->thread_id;

		if ( isset( Threads::$cache_by_id[$id] ) ) {
			return Threads::$cache_by_id[$id];
		}

		return new Thread( $row );
	}

	protected function __construct( $line, $unused = null ) {
		/* SCHEMA changes must be reflected here. */

		if ( is_null( $line ) ) { // For Thread::create().
			$dbr = wfGetDB( DB_SLAVE );
			$this->modified = $dbr->timestamp( wfTimestampNow() );
			$this->created = $dbr->timestamp( wfTimestampNow() );
			$this->sortkey = wfTimestamp( TS_MW );
			$this->editedness = Threads::EDITED_NEVER;
			$this->replyCount = 0;
			return;
		}

		$dataLoads = array(
			'thread_id' => 'id',
			'thread_root' => 'rootId',
			'thread_article_namespace' => 'articleNamespace',
			'thread_article_title' => 'articleTitle',
			'thread_article_id' => 'articleId',
			'thread_summary_page' => 'summaryId',
			'thread_ancestor' => 'ancestorId',
			'thread_parent' => 'parentId',
			'thread_modified' => 'modified',
			'thread_created' => 'created',
			'thread_type' => 'type',
			'thread_editedness' => 'editedness',
			'thread_subject' => 'subject',
			'thread_author_id' => 'authorId',
			'thread_author_name' => 'authorName',
			'thread_sortkey' => 'sortkey',
			'thread_replies' => 'replyCount',
			'thread_signature' => 'signature',
		);

		foreach ( $dataLoads as $db_field => $member_field ) {
			if ( isset( $line->$db_field ) ) {
				$this->$member_field = $line->$db_field;
			}
		}

		if ( isset( $line->page_namespace ) && isset( $line->page_title ) ) {
			$root_title = Title::makeTitle( $line->page_namespace, $line->page_title );
			$this->root = new Article( $root_title );
			$this->root->loadPageData( $line );
		} else {
			if ( isset( self::$titleCacheById[$this->rootId] ) ) {
				$root_title = self::$titleCacheById[$this->rootId];
			} else {
				$root_title = Title::newFromID( $this->rootId );
			}

			if ( $root_title ) {
				$this->root = new Article( $root_title );
			}
		}

		Threads::$cache_by_id[$line->thread_id] = $this;
		if ( $line->thread_parent ) {
			if ( !isset( self::$replyCacheById[$line->thread_parent] ) )
				self::$replyCacheById[$line->thread_parent] = array();
			self::$replyCacheById[$line->thread_parent][$line->thread_id] = $this;
		}

		try {
			$this->doLazyUpdates( $line );
		} catch ( Exception $excep ) {
			trigger_error( "Exception doing lazy updates: " . $excep->__toString() );
		}

		$this->dbVersion = clone $this;
		unset( $this->dbVersion->dbVersion );
	}

	// Load a list of threads in bulk, including all subthreads.
	static function bulkLoad( $rows ) {
		// Preload subthreads
		$top_thread_ids = array();
		$all_thread_rows = $rows;
		$pageIds = array();
		$linkBatch = new LinkBatch();
		$userIds = array();
		$loadEditorsFor = array();
		
		$dbr = wfGetDB( DB_SLAVE );

		if ( !is_array( self::$replyCacheById ) ) {
			self::$replyCacheById = array();
		}

		// Build a list of threads for which to pull replies, and page IDs to pull data for.
		//  Also, pre-initialise the reply cache.
		foreach ( $rows as $row ) {
			if ( $row->thread_ancestor ) {
				$top_thread_ids[] = $row->thread_ancestor;
			} else {
				$top_thread_ids[] = $row->thread_id;
			}

			// Grab page data while we're here.
			if ( $row->thread_root )
				$pageIds[] = $row->thread_root;
			if ( $row->thread_summary_page )
				$pageIds[] = $row->thread_summary_page;

			if ( !isset( self::$replyCacheById[$row->thread_id] ) ) {
				self::$replyCacheById[$row->thread_id] = array();
			}
		}
		
		$all_thread_ids = $top_thread_ids;

		// Pull replies to the threads provided, and as above, pull page IDs to pull data for,
		//  pre-initialise the reply cache, and stash the row object for later use.
		if ( count( $top_thread_ids ) ) {
			$res = $dbr->select( 'thread', '*',
						array( 'thread_ancestor' => $top_thread_ids,
							'thread_type != ' . $dbr->addQuotes( Threads::TYPE_DELETED ) ),
						__METHOD__ );

			foreach( $res as $row ) {
				// Grab page data while we're here.
				if ( $row->thread_root ) {
					$pageIds[] = $row->thread_root;
				}
				if ( $row->thread_summary_page ) {
					$pageIds[] = $row->thread_summary_page;
				}
				$all_thread_rows[] = $row;
				$all_thread_ids[$row->thread_id] = $row->thread_id;
			}
		}
		
		// Pull thread reactions
		if ( count( $all_thread_ids ) ) {
			$res = $dbr->select( 'thread_reaction', '*',
						array( 'tr_thread' => $all_thread_ids ),
						__METHOD__ );
			
			foreach( $res as $row ) {
				$thread_id = $row->tr_thread;
				$user = $row->tr_user_text;
				$info = array(
					'type' => $row->tr_type,
					'user-id' => $row->tr_user,
					'user-name' => $row->tr_user_text,
					'value' => $row->tr_value,
				);
				
				$type = $info['type'];
				$user = $info['user-name'];
				
				if ( ! isset( self::$reactionCacheById[$thread_id] ) ) {
					self::$reactionCacheById[$thread_id] = array();
				}
				
				if ( ! isset( self::$reactionCacheById[$thread_id][$type] ) ) {
					self::$reactionCacheById[$thread_id][$type] = array();
				}
				
				self::$reactionCacheById[$thread_id][$type][$user] = $info;
			}
		}

		// Preload page data (restrictions, and preload Article object with everything from
		//  the page table. Also, precache the title and article objects for pulling later.
		$articlesById = array();
		if ( count( $pageIds ) ) {
			// Pull restriction info. Needs to come first because otherwise it's done per
			//  page by loadPageData.
			$restrictionRows = array_fill_keys( $pageIds, array() );
			$res = $dbr->select( 'page_restrictions', '*', array( 'pr_page' => $pageIds ),
									__METHOD__ );
			foreach( $res as $row ) {
				$restrictionRows[$row->pr_page][] = $row;
			}

			$res = $dbr->select( 'page', '*', array( 'page_id' => $pageIds ), __METHOD__ );

			foreach( $res as $row ) {
				$t = Title::newFromRow( $row );

				if ( isset( $restrictionRows[$t->getArticleId()] ) ) {
					$t->loadRestrictionsFromRows( $restrictionRows[$t->getArticleId()],
									$row->page_restrictions );
				}

				$article = new Article( $t );
				$article->loadPageData( $row );

				self::$titleCacheById[$t->getArticleId()] = $t;
				$articlesById[$article->getId()] = $article;

				if ( count( self::$titleCacheById ) > 10000 ) {
					self::$titleCacheById = array();
				}
			}
		}

		// For every thread we have a row object for, load a Thread object, add the user and
		//  user talk pages to a link batch, cache the relevant user id/name pair, and
		//  populate the reply cache.
		foreach ( $all_thread_rows as $row ) {
			$thread = Thread::newFromRow( $row, null );

			if ( isset( $articlesById[$thread->rootId] ) )
				$thread->root = $articlesById[$thread->rootId];

			// User cache data
			$t = Title::makeTitleSafe( NS_USER, $row->thread_author_name );
			$linkBatch->addObj( $t );
			$t = Title::makeTitleSafe( NS_USER_TALK, $row->thread_author_name );
			$linkBatch->addObj( $t );

			User::$idCacheByName[$row->thread_author_name] = $row->thread_author_id;
			$userIds[$row->thread_author_id] = true;
			
			if ( $row->thread_editedness > Threads::EDITED_BY_AUTHOR ) {
				$loadEditorsFor[$row->thread_root] = $thread;
				$thread->setEditors( array() );
			}
		}
		
		// Pull list of users who have edited
		if ( count( $loadEditorsFor ) ) {
			$res = $dbr->select( 'revision', array( 'rev_user_text', 'rev_page' ),
				array( 'rev_page' => array_keys( $loadEditorsFor ),
					'rev_parent_id != ' . $dbr->addQuotes( 0 ) ),
					__METHOD__ );
			foreach ( $res as $row ) {
				$pageid = $row->rev_page;
				$editor = $row->rev_user_text;
				$t = $loadEditorsFor[$pageid];
				
				$t->addEditor( $editor );
			}
		}

		// Pull link batch data.
		$linkBatch->execute();

		$threads = array();

		// Fill and return an array with the threads that were actually requested.
		foreach ( $rows as $row ) {
			$threads[$row->thread_id] = Threads::$cache_by_id[$row->thread_id];
		}

		return $threads;
	}

	/**
	* Return the User object representing the author of the first revision
	* (or null, if the database is screwed up).
	*/
	function loadOriginalAuthorFromRevision( ) {
		$this->dieIfHistorical();

		$dbr = wfGetDB( DB_SLAVE );

		$article = $this->root();

		$line = $dbr->selectRow(
			'revision',
			'rev_user_text',
			array( 'rev_page' => $article->getID() ),
			__METHOD__,
			array(
				'ORDER BY' => 'rev_timestamp',
				'LIMIT'   => '1'
			)
		);
		if ( $line )
			return User::newFromName( $line->rev_user_text, false );
		else
			return null;
	}

	static function recursiveGetReplyCount( $thread, $level = 1 ) {
		if ( $level > 80 ) {
			return 1;
		}

		$count = 0;

		foreach ( $thread->replies() as $reply ) {
			if ( $thread->type != Threads::TYPE_DELETED ) {
				$count++;
				$count += self::recursiveGetReplyCount( $reply, $level + 1 );
			}
		}

		return $count;
	}

	// Lazy updates done whenever a thread is loaded.
	//  Much easier than running a long-running maintenance script.
	function doLazyUpdates( ) {
		if ( $this->isHistorical() )
			return; // Don't do lazy updates on stored historical threads.

		// This is an invocation guard to avoid infinite recursion when fixing a
		//  missing ancestor.
		static $doingUpdates = false;
		if ( $doingUpdates ) {
			return;
		}
		$doingUpdates = true;

		// Fix missing ancestry information.
		// (there was a bug where this was not saved properly)
		if ( $this->parentId && !$this->ancestorId ) {
			$this->fixMissingAncestor();
		}

		$ancestor = $this->topmostThread();

		$set = array();

		// Fix missing subject information
		// (this information only started to be added later)
		if ( !$this->subject && $this->root() ) {
			$detectedSubject = $this->root()->getTitle()->getText();
			$parts = self::splitIncrementFromSubject( $detectedSubject );

			$this->subject = $detectedSubject = $parts[1];

			// Update in the DB
			$set['thread_subject'] = $detectedSubject;
		}

		// Fix inconsistent subject information
		// (in some intermediate versions this was not updated when the subject was changed)
		if ( $this->subject() != $ancestor->subject() ) {
			$set['thread_subject'] = $ancestor->subject();

			$this->subject = $ancestor->subject();
		}

		// Fix missing authorship information
		// (this information only started to be added later)
		if ( !$this->authorName ) {
			$author = $this->loadOriginalAuthorFromRevision();

			$this->authorId = $author->getId();
			$this->authorName = $author->getName();

			$set['thread_author_name'] = $this->authorName;
			$set['thread_author_id'] = $this->authorId;
		}

		// Check for article being in subject, not talk namespace.
		// If the page is non-LiquidThreads and it's in subject-space, we'll assume it's meant
		// to be on the corresponding talk page, but only if the talk-page is a LQT page.
		// (Previous versions stored the subject page, for some totally bizarre reason)
		// Old versions also sometimes store the thread page for trace threads as the
		//  article, not as the root.
		//  Trying not to exacerbate this by moving it to be the 'Thread talk' page.
		$articleTitle = $this->getTitle();
		global $wgLiquidThreadsMigrate;
		if ( !LqtDispatch::isLqtPage( $articleTitle ) && !$articleTitle->isTalkPage() &&
				LqtDispatch::isLqtPage( $articleTitle->getTalkPage() ) &&
				$articleTitle->getNamespace() != NS_LQT_THREAD &&
				$wgLiquidThreadsMigrate ) {
			$newTitle = $articleTitle->getTalkPage();
			$newArticle = new Article( $newTitle );

			$set['thread_article_namespace'] = $newTitle->getNamespace();
			$set['thread_article_title'] = $newTitle->getDbKey();

			$this->articleNamespace = $newTitle->getNamespace();
			$this->articleTitle = $newTitle->getDbKey();
			$this->articleId = $newTitle->getArticleId();

			$this->article = $newArticle;
		}

		// Check for article corruption from incomplete thread moves.
		// (thread moves only updated this on immediate replies, not replies to replies etc)
		if ( ! $ancestor->getTitle()->equals( $this->getTitle() ) ) {
			$title = $ancestor->getTitle();
			$set['thread_article_namespace'] = $title->getNamespace();
			$set['thread_article_title'] = $title->getDbKey();

			$this->articleNamespace = $title->getNamespace();
			$this->articleTitle = $title->getDbKey();
			$this->articleId = $title->getArticleId();

			$this->article = $ancestor->article();
		}

		// Check for invalid/missing articleId
		$articleTitle = null;
		$dbTitle = Title::makeTitleSafe( $this->articleNamespace, $this->articleTitle );
		if ( $this->articleId && isset( self::$titleCacheById[$this->articleId] ) ) {
			// If it corresponds to a title, the article obviously exists.
			$articleTitle = self::$titleCacheById[$this->articleId];
			$this->article = new Article( $articleTitle );
		} elseif ( $this->articleId ) {
			$articleTitle = Title::newFromID( $this->articleId );
		}

		// If still unfilled, the article ID referred to is no longer valid. Re-fill it
		//  from the namespace/title pair if an article ID is provided
		if ( !$articleTitle && ( $this->articleId != 0 || $dbTitle->getArticleId() != 0 ) ) {
			$articleTitle = $dbTitle;
			$this->articleId = $articleTitle->getArticleId();
			$this->article = new Article( $dbTitle );

			$set['thread_article_id'] = $this->articleId;
			wfDebug( "Unfilled or non-existent thread_article_id, refilling to {$this->articleId}\n" );

			// There are probably problems on the rest of the article, trigger a small update
			Threads::synchroniseArticleData( $this->article, 100, 'cascade' );
		} elseif ( $articleTitle && !$articleTitle->equals( $dbTitle ) ) {
			// The page was probably moved and this was probably not updated.
			wfDebug( "Article ID/Title discrepancy, resetting NS/Title to article provided by ID\n" );
			$this->articleNamespace = $articleTitle->getNamespace();
			$this->articleTitle = $articleTitle->getDBkey();

			$set['thread_article_namespace'] = $articleTitle->getNamespace();
			$set['thread_article_title'] = $articleTitle->getDBkey();

			// There are probably problems on the rest of the article, trigger a small update
			Threads::synchroniseArticleData( $this->article, 100, 'cascade' );
		}

		// Check for unfilled signature field. This field hasn't existed until
		//  recently.
		if ( is_null( $this->signature ) ) {
			// Grab our signature.
			$sig = LqtView::getUserSignature( $this->author() );

			$set['thread_signature'] = $sig;
			$this->setSignature( $sig );
		}

		if ( count( $set ) ) {
			$dbw = wfGetDB( DB_MASTER );

			$dbw->update( 'thread', $set, array( 'thread_id' => $this->id() ), __METHOD__ );
		}

		// Done
		$doingUpdates = false;
	}

	function addReply( $thread ) {
		$thread->setSuperThread( $this );

		if ( is_array( $this->replies ) ) {
			$this->replies[$thread->id()] = $thread;
		} else {
			$this->replies();
			$this->replies[$thread->id()] = $thread;
		}

		// Increment reply count.
		$this->incrementReplyCount( $thread->replyCount() + 1 );
	}

	function removeReply( $thread ) {
		if ( is_object( $thread ) ) {
			$thread = $thread->id();
		}

		$this->replies();

		unset( $this->replies[$thread] );

		// Also, decrement the reply count.
		$threadObj = Threads::withId( $thread );
		$this->decrementReplyCount( 1 + $threadObj->replyCount() );
	}

	function checkReplies( $replies ) {
		// Fixes a bug where some history pages were not working, before
		//  superthread was properly instance-cached.
		if ( $this->isHistorical() ) { return; }
		foreach ( $replies as $reply ) {
			if ( ! $reply->hasSuperthread() ) {
				throw new MWException( "Post " . $this->id() .
				" has contaminated reply " . $reply->id() .
				". Found no superthread." );
			}

			if ( $reply->superthread()->id() != $this->id() ) {
				throw new MWException( "Post " . $this->id() .
				" has contaminated reply " . $reply->id() .
				". Expected " . $this->id() . ", got " .
				$reply->superthread()->id() );
			}
		}
	}

	function replies() {
		if ( !$this->id() ) {
			return array();
		}

		if ( !is_null( $this->replies ) ) {
			$this->checkReplies( $this->replies );
			return $this->replies;
		}

		$this->dieIfHistorical();

		// Check cache
		if ( isset( self::$replyCacheById[$this->id()] ) ) {
			return $this->replies = self::$replyCacheById[$this->id()];
		}

		$this->replies = array();

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'thread', '*',
					array( 'thread_parent' => $this->id(),
					'thread_type != ' . $dbr->addQuotes( Threads::TYPE_DELETED ) ),
					__METHOD__ );

		$rows = array();
		foreach( $res as $row ) {
			$rows[] = $row;
		}

		$this->replies = Thread::bulkLoad( $rows );

		$this->checkReplies( $this->replies );

		return $this->replies;
	}

	function setSuperthread( $thread ) {
		if ( $thread == null ) {
			$this->parentId = null;
			$this->ancestorId = 0;
			return;
		}

		$this->parentId = $thread->id();
		$this->superthread = $thread;

		if ( $thread->isTopmostThread() ) {
			$this->ancestorId = $thread->id();
			$this->ancestor = $thread;
		} else {
			$this->ancestorId = $thread->ancestorId();
			$this->ancestor = $thread->topmostThread();
		}
	}

	function superthread() {
		if ( !$this->hasSuperthread() ) {
			return null;
		} elseif ( $this->superthread ) {
			return $this->superthread;
		} else {
			$this->dieIfHistorical();
			$this->superthread = Threads::withId( $this->parentId );
			return $this->superthread;
		}
	}

	function hasSuperthread() {
		return !$this->isTopmostThread();
	}

	function topmostThread() {
		if ( $this->isTopmostThread() ) {
			return $this->ancestor = $this;
		} elseif ( $this->ancestor ) {
			return $this->ancestor;
		} else {
			$this->dieIfHistorical();

			$thread = Threads::withId( $this->ancestorId );

			if ( !$thread ) {
				$thread = $this->fixMissingAncestor();
			}

			$this->ancestor = $thread;

			return $thread;
		}
	}

	function setAncestor( $newAncestor ) {
		if ( is_object( $newAncestor ) ) {
			$this->ancestorId = $newAncestor->id();
		} else {
			$this->ancestorId = $newAncestor;
		}
	}

	// Due to a bug in earlier versions, the topmost thread sometimes isn't there.
	// Fix the corruption by repeatedly grabbing the parent until we hit the topmost thread.
	function fixMissingAncestor() {
		$thread = $this;

		$this->dieIfHistorical();

		while ( !$thread->isTopmostThread() ) {
			$thread = $thread->superthread();
		}

		$this->ancestorId = $thread->id();

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'thread', array( 'thread_ancestor' => $thread->id() ),
				array( 'thread_id' => $this->id() ), __METHOD__ );

		return $thread;
	}

	function isTopmostThread() {
		return $this->ancestorId == $this->id ||
				$this->parentId == 0;
	}

	function setArticle( $a ) {
		$this->articleId = $a->getID();
		$this->articleNamespace = $a->getTitle()->getNamespace();
		$this->articleTitle = $a->getTitle()->getDBkey();
		$this->touch();
	}

	function touch() {
		// Nothing here yet
	}

	function article() {
		if ( $this->article ) return $this->article;

		if ( !is_null( $this->articleId ) ) {
			if ( isset( self::$articleCacheById[$this->articleId] ) ) {
				return self::$articleCacheById[$this->articleId];
			}

			if ( isset( self::$titleCacheById[$this->articleId] ) ) {
				$title = self::$titleCacheById[$this->articleId];
			} else {
				$title = Title::newFromID( $this->articleId );
			}

			if ( $title ) {
				$article = new Article( $title );
				self::$articleCacheById[$this->articleId] = $article;
			}
		}

		if ( isset( $article ) && $article->exists() ) {
			$this->article = $article;
			return $article;
		} else {
			$title = Title::makeTitle( $this->articleNamespace, $this->articleTitle );
			return new Article( $title );
		}
	}

	function id() {
		return $this->id;
	}

	function ancestorId() {
		return $this->ancestorId;
	}

	// The 'root' is the page in the Thread namespace corresponding to this thread.
	function root( ) {
		if ( !$this->rootId ) return null;
		if ( !$this->root ) {
			if ( isset( self::$articleCacheById[$this->rootId] ) ) {
				$this->root = self::$articleCacheById[$this->rootId];
				return $this->root;
			}

			if ( isset( self::$titleCacheById[$this->rootId] ) ) {
				$title = self::$titleCacheById[$this->rootId];
			} else {
				$title = Title::newFromID( $this->rootId );
			}

			if ( !$title && $this->type() != Threads::TYPE_DELETED ) {
				if ( ! $this->isHistorical() ) {
					$this->delete('', false /* !commit */);
				} else {
					$this->type = Threads::TYPE_DELETED;
				}
			}
			
			if ( !$title ) {
				return null;
			}

			$this->root = new Article( $title );
		}
		return $this->root;
	}

	function editedness() {
		return $this->editedness;
	}

	function summary() {
		if ( !$this->summaryId )
			return null;

		if ( !$this->summary ) {
			$title = Title::newFromID( $this->summaryId );

			if ( !$title ) {
				wfDebug( __METHOD__ . ": supposed summary doesn't exist" );
				$this->summaryId = null;
				return null;
			}

			$this->summary = new Article( $title );

		}

		return $this->summary;
	}

	function hasSummary() {
		return $this->summaryId != null;
	}

	function setSummary( $post ) {
		// Weird -- this was setting $this->summary to NULL before I changed it.
		// If there was some reason why, please tell me! -- Andrew
		$this->summary = $post;
		$this->summaryId = $post->getID();
	}

	function title() {
		if ( is_object( $this->root() ) ) {
			return $this->root()->getTitle();
		} else {
			// wfWarn( "Thread ".$this->id()." has no title." );
			return null;
		}
	}

	static function splitIncrementFromSubject( $subject_string ) {
		preg_match( '/^(.*) \((\d+)\)$/', $subject_string, $matches );
		if ( count( $matches ) != 3 )
			throw new MWException( __METHOD__ . ": thread subject has no increment: " . $subject_string );
		else
			return $matches;
	}

	function subject() {
		return $this->subject;
	}

	function formattedSubject() {
		return LqtView::formatSubject( $this->subject() );
	}

	function setSubject( $subject ) {
		$this->subject = $subject;

		foreach ( $this->replies() as $reply ) {
			$reply->setSubject( $subject );
		}
	}

	// Deprecated, use subject().
	function subjectWithoutIncrement() {
		return $this->subject();
	}

	// Currently equivalent to isTopmostThread.
	function hasDistinctSubject() {
		return $this->isTopmostThread();
	}

	function hasSubthreads() {
		return count( $this->replies() ) != 0;
	}

	// Synonym for replies()
	function subthreads() {
		return $this->replies();
	}

	function modified() {
		return $this->modified;
	}

	function created() {
		return $this->created;
	}

	function type() {
		return $this->type;
	}

	function setType( $t ) {
		$this->type = $t;
	}

	function redirectThread() {
		$rev = Revision::newFromId( $this->root()->getLatest() );
		$rtitle = Title::newFromRedirect( $rev->getRawText() );
		if ( !$rtitle ) return null;

		$this->dieIfHistorical();
		$rthread = Threads::withRoot( new Article( $rtitle ) );
		return $rthread;
	}

	// This only makes sense when called from the hook, because it uses the hook's
	// default behavior to check whether this thread itself is protected, so you'll
	// get false negatives if you use it from some other context.
	function getRestrictions( $action, &$result ) {
		if ( $this->hasSuperthread() ) {
			$parent_restrictions = $this->superthread()->root()->getTitle()->getRestrictions( $action );
		} else {
			$parent_restrictions = $this->getTitle()->getRestrictions( $action );
		}

		// TODO this may not be the same as asking "are the parent restrictions more restrictive than
		// our own restrictions?", which is what we really want.
		if ( count( $parent_restrictions ) == 0 ) {
			return true; // go to normal protection check.
		} else {
			$result = $parent_restrictions;
			return false;
		}

	}

	function getAnchorName() {
		$wantedId = $this->subject() . "_{$this->id()}";
		return Sanitizer::escapeId( $wantedId );
	}

	function updateHistory() {
	}

	function setAuthor( $user ) {
		$this->authorId = $user->getId();
		$this->authorName = $user->getName();
	}

	// Load all lazy-loaded data in prep for (e.g.) serialization.
	function loadAllData() {
		// Make sure superthread and topmost thread are loaded.
		$this->superthread();
		$this->topmostThread();

		// Make sure replies, and all the data therein, is loaded.
		foreach ( $this->replies() as $reply ) {
			$reply->loadAllData();
		}
	}

	// On serialization, load all data because it will be different in the DB when we wake up.
	function __sleep() {
		$this->loadAllData();

		$fields = array_keys( get_object_vars( $this ) );

		// Filter out article objects, there be dragons (or unserialization problems)
		$fields = array_diff( $fields, array( 'root', 'article', 'summary', 'sleeping',
							'dbVersion' ) );

		return $fields;
	}

	function __wakeup() {
		// Mark as historical.
		$this->isHistorical = true;
	}

	// This is a safety valve that makes sure that the DB is NEVER touched by a historical
	//  thread (even for reading, because the data will be out of date).
	function dieIfHistorical() {
		if ( $this->isHistorical() ) {
			throw new MWException( "Attempted write or DB operation on historical thread" );
		}
	}

	function rootRevision() {
		if ( !$this->isHistorical() ||
			!isset( $this->topmostThread()->threadRevision ) ||
			! $this->root() ) {
			return null;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$revision = $this->topmostThread()->threadRevision;
		$timestamp = $dbr->timestamp( $revision->getTimestamp() );

		$conds = array(
			'rev_timestamp<=' . $dbr->addQuotes( $timestamp ),
			'page_namespace' => $this->root()->getTitle()->getNamespace(),
			'page_title' => $this->root()->getTitle()->getDBKey(),
		);

		$join_conds = array( 'page' => array( 'JOIN', 'rev_page=page_id' ) );

		$row = $dbr->selectRow( array( 'revision', 'page' ), '*', $conds, __METHOD__,
				array( 'ORDER BY' => 'rev_timestamp DESC' ), $join_conds );

		return $row->rev_id;
	}

	function sortkey() {
		return $this->sortkey;
	}

	function setSortKey( $k = null ) {
		if ( is_null( $k ) ) {
			$k = wfTimestamp( TS_MW );
		}

		$this->sortkey = $k;
	}

	function replyWithId( $id ) {
		if ( $this->id() == $id ) {
			return $this;
		}

		foreach ( $this->replies() as $reply ) {
			if ( $obj = $reply->replyWithId( $id ) ) {
				return $obj;
			}
		}

		return null;
	}

	static function createdSortCallback( $a, $b ) {
		$a = $a->created();
		$b = $b->created();

		if ( $a == $b ) {
			return 0;
		} elseif ( $a > $b ) {
			return 1;
		} else {
			return - 1;
		}
	}

	public function split( $newSubject, $reason = '', $newSortkey = null ) {
		$oldTopThread = $this->topmostThread();
		$oldParent = $this->superthread();

		$original = $this->dbVersion;

		self::recursiveSet( $this, $newSubject, $this, null );

		$oldParent->removeReply( $this );

		$bump = null;
		if ( !is_null( $newSortkey ) ) {
			$this->setSortkey( $newSortkey );
			$bump = false;
		}

		// For logging purposes, will be reset by the time this call returns.
		$this->dbVersion = $original;

		$this->commitRevision( Threads::CHANGE_SPLIT, null, $reason, $bump );
		$oldTopThread->commitRevision( Threads::CHANGE_SPLIT_FROM, $this, $reason );
	}

	public function moveToParent( $newParent, $reason = '' ) {
		$newSubject = $newParent->subject();

		$original = $this->dbVersion;

		$oldTopThread = $newParent->topmostThread();
		$oldParent = $this->superthread();
		$newTopThread = $newParent->topmostThread();

		Thread::recursiveSet( $this, $newSubject, $newTopThread, $newParent );

		$newParent->addReply( $this );

		if ( $oldParent ) {
			$oldParent->removeReply( $this );
		}

		$this->dbVersion = $original;

		$oldTopThread->commitRevision( Threads::CHANGE_MERGED_FROM, $this, $reason );
		$newParent->commitRevision( Threads::CHANGE_MERGED_TO, $this, $reason );
	}

	static function recursiveSet( $thread, $subject, $ancestor, $superthread = false ) {
		$thread->setSubject( $subject );
		$thread->setAncestor( $ancestor->id() );

		if ( $superthread !== false ) {
			$thread->setSuperThread( $superthread );
		}

		$thread->save();

		foreach ( $thread->replies() as $subThread ) {
			self::recursiveSet( $subThread, $subject, $ancestor );
		}
	}

	static function validateSubject( $subject, &$title, $replyTo, $article ) {
		$t = null;
		$ok = true;

		while ( !$t ) {
			try {
				global $wgUser;

				if ( !$replyTo && $subject ) {
					$t = Threads::newThreadTitle( $subject, $article );
				} elseif ( $replyTo ) {
					$t = Threads::newReplyTitle( $replyTo, $wgUser );
				}

				if ( $t )
					break;
			} catch ( Exception $e ) { }

			$subject = md5( mt_rand() ); // Just a random title
			$ok = false;
		}

		$title = $t;

		return $ok;
	}

	/* N.B. Returns true, or a string with either thread or talkpage, noting which is
	   protected */
	public function canUserReply( $user ) {
		$threadRestrictions = $this->topmostThread()->title()->getRestrictions( 'reply' );
		$talkpageRestrictions = $this->getTitle()->getRestrictions( 'reply' );

		$threadRestrictions = array_fill_keys( $threadRestrictions, 'thread' );
		$talkpageRestrictions = array_fill_keys( $talkpageRestrictions, 'talkpage' );

		$restrictions = array_merge( $threadRestrictions, $talkpageRestrictions );

		foreach ( $restrictions as $right => $source ) {
			if ( $right == 'sysop' ) $right = 'protect';
			if ( !$user->isAllowed( $right ) ) {
				return $source;
			}
		}

		return self::canUserCreateThreads( $user );
	}

	public static function canUserPost( $user, $talkpage ) {
		$restrictions = $talkpage->getTitle()->getRestrictions( 'newthread' );

		foreach ( $restrictions as $right ) {
			if ( !$user->isAllowed( $right ) ) {
				return false;
			}
		}

		return self::canUserCreateThreads( $user );
	}

	// Generally, not some specific page
	public static function canUserCreateThreads( $user ) {
		$userText = $user->getName();

		static $canCreateNew = array();
		if ( !isset( $canCreateNew[$userText] ) ) {
			$title = Title::makeTitleSafe( NS_LQT_THREAD, 'Test title for LQT thread creation check' );
			$canCreateNew[$userText] = $title->userCan( 'create' ) && $title->userCan( 'edit' );
		}

		return $canCreateNew[$userText];
	}

	public function signature() {
		return $this->signature;
	}

	public function setSignature( $sig ) {
		$sig = LqtView::signaturePST( $sig, $this->author() );
		$this->signature = $sig;
	}
	
	public function editors() {
		if ( is_null( $this->editors ) ) {
			if ( $this->editedness() < Threads::EDITED_BY_AUTHOR ) {
				return array();
			} elseif ( $this->editedness == Threads::EDITED_BY_AUTHOR ) {
				return array( $this->author()->getName() );
			}
			
			// Load editors
			$this->editors = array();
			
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'revision', 'rev_user_text',
				array( 'rev_page' => $this->root()->getId(),
				'rev_parent_id != ' . $dbr->addQuotes( 0 ) ), __METHOD__ );
			
			foreach ( $res as $row ) {
				$this->editors[$row->rev_user_text] = 1;
			}
			
			$this->editors = array_keys( $this->editors );
		}
		
		return $this->editors;
	}
	
	public function setEditors( $e ) {
		$this->editors = $e;
	}
	
	public function addEditor( $e ) {
		$this->editors[] = $e;
		$this->editors = array_unique( $this->editors );
	}

	/**
	 * Return the Title object for the article this thread is attached to.
	 */
	public function getTitle() {
		return $this->article()->getTitle();
	}
	
	public function getReactions( $requestedType = null ) {
		if ( is_null( $this->reactions ) ) {
			if ( isset( self::$reactionCacheById[$this->id()] ) ) {
				$this->reactions = self::$reactionCacheById[$this->id()];
			} else {
				$reactions = array();

				$dbr = wfGetDB( DB_SLAVE );

				$res = $dbr->select( 'thread_reaction',
						array( 'tr_thread' => $this->id() ),
						__METHOD__ );
			
				foreach( $res as $row ) {
					$thread_id = $row->tr_thread;
					$user = $row->tr_user_text;
					$type = $row->tr_type;
					$info = array(
						'type' => $type,
						'user-id' => $row->tr_user,
						'user-name' => $row->tr_user_text,
						'value' => $row->tr_value,
					);
					
					if ( ! isset( $reactions[$type] ) ) {
						$reactions[$type] = array();
					}
					
					$reactions[$type][$user] = $info;
				}
				
				$this->reactions = $reactions;
			}
		}
		
		if ( is_null($requestedType) )  {
			return $this->reactions;
		} else {
			return $this->reactions[$requestedType];
		}
	}
	
	public function addReaction( $user, $type, $value ) {
		$info = array(
			'type' => $type,
			'user-id' => $user->getId(),
			'user-name' => $user->getName(),
			'value' => $value,
		);
		
		if ( ! isset( $this->reactions[$type] ) ) {
			$this->reactions[$type] = array();
		}
		
		$this->reactions[$type][$user->getName()] = $info;
		
		$row = array(
			'tr_type' => $type,
			'tr_thread' => $this->id(),
			'tr_user' => $user->getId(),
			'tr_user_text' => $user->getName(),
			'tr_value' => $value,
		);
		
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->insert( 'thread_reaction', $row, __METHOD__ );
	}
	
	public function deleteReaction( $user, $type ) {
		$dbw = wfGetDB( DB_MASTER );
		
		if ( isset( $this->reactions[$type][$user->getName()] ) ) {
			unset( $this->reactions[$type][$user->getName()] );
		}
		
		$dbw->delete( 'thread_reaction',
				array( 'tr_thread' => $this->id(),
					'tr_user' => $user->getId(),
					'tr_type' => $type ),
				__METHOD__ );
	}
}
