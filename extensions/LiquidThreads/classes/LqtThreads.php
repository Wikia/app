<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

/** Module of factory methods. */
class Threads {

	const TYPE_NORMAL = 0;
	const TYPE_MOVED = 1;
	const TYPE_DELETED = 2;
	static $VALID_TYPES = array( self::TYPE_NORMAL, self::TYPE_MOVED, self::TYPE_DELETED );

	const CHANGE_NEW_THREAD = 0;
	const CHANGE_REPLY_CREATED = 1;
	const CHANGE_EDITED_ROOT = 2;
	const CHANGE_EDITED_SUMMARY = 3;
	const CHANGE_DELETED = 4;
	const CHANGE_UNDELETED = 5;
	const CHANGE_MOVED_TALKPAGE = 6;
	static $VALID_CHANGE_TYPES = array( self::CHANGE_EDITED_SUMMARY, self::CHANGE_EDITED_ROOT,
		self::CHANGE_REPLY_CREATED, self::CHANGE_NEW_THREAD, self::CHANGE_DELETED, self::CHANGE_UNDELETED,
		self::CHANGE_MOVED_TALKPAGE );

	// Possible values of Thread->editedness.
	const EDITED_NEVER = 0;
	const EDITED_HAS_REPLY = 1;
	const EDITED_BY_AUTHOR = 2;
	const EDITED_BY_OTHERS = 3;

	static $cache_by_root = array();
	static $cache_by_id = array();

    static function newThread( $root, $article, $superthread = null, $type = self::TYPE_NORMAL ) {
		// SCHEMA changes must be reflected here.
		// TODO: It's dumb that the commitRevision code isn't used here.

        $dbw =& wfGetDB( DB_MASTER );

		if ( !in_array( $type, self::$VALID_TYPES ) ) {
			throw new MWException( __METHOD__ . ": invalid type $type." );
		}

		if ( $superthread ) {
			$change_type = self::CHANGE_REPLY_CREATED;
		} else {
			$change_type = self::CHANGE_NEW_THREAD;
		}

		global $wgUser; // TODO global.

		$timestamp = wfTimestampNow();

		// TODO PG support
		$newid = $dbw->nextSequenceValue( 'thread_thread_id' );

		$row = array( 'thread_root' => $root->getID(),
			'thread_parent' => $superthread ? $superthread->id() : null,
			'thread_article_namespace' => $article->getTitle()->getNamespace(),
			'thread_article_title' => $article->getTitle()->getDBkey(),
			'thread_modified' => $timestamp,
			'thread_created' => $timestamp,
			'thread_change_type' => $change_type,
			'thread_change_comment' => "", // TODO
			'thread_change_user' => $wgUser->getID(),
			'thread_change_user_text' => $wgUser->getName(),
			'thread_type' => $type,
			'thread_editedness' => self::EDITED_NEVER );

		if ( $superthread ) {
			$row['thread_ancestor'] = $superthread->ancestorId();
			$row['thread_change_object'] = $newid;
		} else {
			$row['thread_change_object'] = null;
		}

        $res = $dbw->insert( 'thread', $row, __METHOD__ );

		$newid = $dbw->insertId();

		$row['thread_id'] = $newid;

		// Ew, we have to do a SECOND update
		if ( $superthread ) {
			$row['thread_change_object'] = $newid;
			$dbw->update( 'thread',
				array( 'thread_change_object' => $newid ),
				array( 'thread_id' => $newid ),
				__METHOD__ );
		}

		// Sigh, convert row to an object
		$rowObj = new stdClass();
		foreach ( $row as $key => $value ) {
			$rowObj->$key = $value;
		}

		// We just created the thread, it won't have any children.
		$newthread = new Thread( $rowObj, array() );

		if ( !$newthread )
			throw new MWException( "No new thread with ID $newid\n" );

		if ( $superthread ) {
			$superthread->addReply( $newthread );
		}

		self::createTalkpageIfNeeded( $article );

		NewMessages::writeMessageStateForUpdatedThread( $newthread );

		return $newthread;
	}

	/**
	 * Create the talkpage if it doesn't exist so that links to it
	 * will show up blue instead of red. For use upon new thread creation.
	*/
	protected static function createTalkpageIfNeeded( $subjectPage ) {
		$talkpage_t = $subjectPage->getTitle()->getTalkpage();
		$talkpage = new Article( $talkpage_t );
		if ( ! $talkpage->exists() ) {
			try {
				wfLoadExtensionMessages( 'LiquidThreads' );
				$talkpage->doEdit( "", wfMsg( 'lqt_talkpage_autocreate_summary' ), EDIT_NEW | EDIT_SUPPRESS_RC );

			} catch ( DBQueryError $e ) {
				// The article already existed by now. No need to do anything.
				wfDebug( __METHOD__ . ": Article already existed by the time we tried to create it." );
			}
		}
	}

	static function where( $where, $options = array(), $extra_tables = array(),
			$joins = "" ) {
		global $wgDBprefix;
		$dbr = wfGetDB( DB_SLAVE );
		if ( is_array( $where ) ) $where = $dbr->makeList( $where, LIST_AND );
		if ( is_array( $options ) ) $options = implode( ',', $options );

		if ( is_array( $extra_tables ) && count( $extra_tables ) != 0 ) {
			if ( !empty( $wgDBprefix ) ) {
				foreach ( $extra_tables as $tablekey => $extra_table )
					$extra_tables[$tablekey] = $wgDBprefix . $extra_table;
			}
			$tables = implode( ',', $extra_tables ) . ', ';
		} else if ( is_string( $extra_tables ) ) {
			$tables = $extra_tables . ', ';
		} else {
			$tables = "";
		}


		$selection_sql = <<< SQL
		SELECT DISTINCT thread.* FROM ($tables {$wgDBprefix}thread thread)
		$joins
		WHERE $where
		$options
SQL;
		$selection_res = $dbr->query( $selection_sql );

		$ancestor_conds = array();
		$selection_conds = array();
		while ( $line = $dbr->fetchObject( $selection_res ) ) {
			$ancestor_conds[] = $line->thread_ancestor;
			$selection_conds[] = $line->thread_id;
		}
		if ( count( $selection_conds ) == 0 ) {
			// No threads were found, so we can skip the second query.
			return array();
		} // List comprehensions, how I miss thee.
		$ancestor_clause = join( ', ', $ancestor_conds );
		$selection_clause = join( ', ', $selection_conds );

		$children_sql = <<< SQL
		SELECT DISTINCT thread.*, page.*,
			thread.thread_id IN($selection_clause) as selected
		FROM ({$wgDBprefix}thread thread, {$wgDBprefix}page page)
		WHERE thread.thread_ancestor IN($ancestor_clause)
			AND page.page_id = thread.thread_root
		$options
SQL;
		$res = $dbr->query( $children_sql );

		$threads = array();
		$top_level_threads = array();
		$thread_children = array();

		while ( $line = $dbr->fetchObject( $res ) ) {
			$new_thread = new Thread( $line, null );
			$threads[] = $new_thread;
			if ( $line->selected )
				// thread is one of those that was directly queried for.
				$top_level_threads[] = $new_thread;
			if ( $line->thread_parent !== null ) {
				if ( !array_key_exists( $line->thread_parent, $thread_children ) )
					$thread_children[$line->thread_parent] = array();
				// Can have duplicate if thread is both top_level and child of another top_level thread.
				if ( !self::arrayContainsThreadWithId( $thread_children[$line->thread_parent], $new_thread->id() ) )
					$thread_children[$line->thread_parent][] = $new_thread;
			}
		}

		foreach ( $threads as $thread ) {
			if ( array_key_exists( $thread->id(), $thread_children ) ) {
				$thread->initWithReplies( $thread_children[$thread->id()] );
			} else {
				$thread->initWithReplies( array() );
			}

			self::$cache_by_root[$thread->root()->getID()] = $thread;
			self::$cache_by_id[$thread->id()] = $thread;
		}

		return $top_level_threads;
	}

	private static function databaseError( $msg ) {
		// TODO tie into MW's error reporting facilities.
		throw new MWException( "Corrupt liquidthreads database: $msg" );
	}

	private static function assertSingularity( $threads, $attribute, $value ) {
		if ( count( $threads ) == 0 ) { return null; }
		if ( count( $threads ) == 1 ) { return $threads[0]; }
		if ( count( $threads ) > 1 ) {
			Threads::databaseError( "More than one thread with $attribute = $value." );
			return null;
		}
	}

	private static function arrayContainsThreadWithId( $a, $id ) {
		// There's gotta be a nice way to express this in PHP. Anyone?
		foreach ( $a as $t )
			if ( $t->id() == $id )
				return true;
		return false;
	}

	static function withRoot( $post ) {
		if ( $post->getTitle()->getNamespace() != NS_LQT_THREAD ) {
			// No articles outside the thread namespace have threads associated with them;
			// avoiding the query saves time during the TitleGetRestrictions hook.
			return null;
		}
		if ( array_key_exists( $post->getID(), self::$cache_by_root ) ) {
			return self::$cache_by_root[$post->getID()];
		}
		$ts = Threads::where( array( 'thread.thread_root' => $post->getID() ) );
		return self::assertSingularity( $ts, 'thread_root', $post->getID() );
	}

	static function withId( $id ) {
		if ( array_key_exists( $id, self::$cache_by_id ) ) {
			return self::$cache_by_id[$id];
		}
		$ts = Threads::where( array( 'thread.thread_id' => $id ) );
		return self::assertSingularity( $ts, 'thread_id', $id );
	}

	static function withSummary( $article ) {
		$ts = Threads::where( array( 'thread.thread_summary_page' => $article->getId() ) );
		return self::assertSingularity( $ts, 'thread_summary_page', $article->getId() );
	}

	/**
	* Horrible, horrible!
	* List of months in which there are >0 threads, suitable for threadsOfArticleInMonth. */
	static function monthsWhereArticleHasThreads( $article ) {
		$threads = Threads::where( Threads::articleClause( $article ) );
		$months = array();
		foreach ( $threads as $t ) {
			$m = substr( $t->modified(), 0, 6 );
			if ( !array_key_exists( $m, $months ) ) {
				if ( !in_array( $m, $months ) ) $months[] = $m;
			}
		}
		return $months;
	}

	static function articleClause( $article ) {
		$dbr = wfGetDB( DB_SLAVE );
		$q_article = $dbr->addQuotes( $article->getTitle()->getDBkey() );
		return <<<SQL
(thread.thread_article_title = $q_article
	AND thread.thread_article_namespace = {$article->getTitle()->getNamespace()})
SQL;
	}

	static function topLevelClause() {
		return 'thread.thread_parent is null';
	}
}
