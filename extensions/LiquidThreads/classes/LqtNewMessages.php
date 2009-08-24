<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class NewMessages {

	static function markThreadAsUnreadByUser( $thread, $user ) {
		self::writeUserMessageState( $thread, $user, null );
	}

	static function markThreadAsReadByUser( $thread, $user ) {
		self::writeUserMessageState( $thread, $user, wfTimestampNow() );
	}

	private static function writeUserMessageState( $thread, $user, $timestamp ) {
		global $wgDBprefix;
		if ( is_object( $thread ) ) $thread_id = $thread->id();
		else if ( is_integer( $thread ) ) $thread_id = $thread;
		else throw new MWException( "writeUserMessageState expected Thread or integer but got $thread" );

		if ( is_object( $user ) ) $user_id = $user->getID();
		else if ( is_integer( $user ) ) $user_id = $user;
		else throw new MWException( "writeUserMessageState expected User or integer but got $user" );

		if ( $timestamp === null ) $timestamp = "NULL";

		// use query() directly to pass in 'true' for don't-die-on-errors.
		$dbr =& wfGetDB( DB_MASTER );
		$success = $dbr->query( "insert into {$wgDBprefix}user_message_state values ($user_id, $thread_id, $timestamp)",
			__METHOD__, true );

		if ( !$success ) {
			// duplicate key; update.
			$dbr->query( "update {$wgDBprefix}user_message_state set ums_read_timestamp = $timestamp" .
				" where ums_thread = $thread_id and ums_user = $user_id",
				__METHOD__ );
		}
	}

	/**
	 * Write a user_message_state for each user who is watching the thread.
	 * If the thread is on a user's talkpage, set that user's newtalk.
	*/
	static function writeMessageStateForUpdatedThread( $t ) {
		global $wgDBprefix, $wgUser;

		if ( $t->article()->getTitle()->getNamespace() == NS_USER ) {
			$name = $t->article()->getTitle()->getDBkey();
			list( $name ) = split( '/', $name ); // subpages
			$user = User::newFromName( $name );
			if ( $user && $user->getID() != $wgUser->getID() ) {
				$user->setNewtalk( true );
			}
		}

		$dbw =& wfGetDB( DB_MASTER );

		$talkpage_t = $t->article()->getTitle();
		$root_t = $t->root()->getTitle();

		$q_talkpage_t = $dbw->addQuotes( $talkpage_t->getDBkey() );
		$q_root_t = $dbw->addQuotes( $root_t->getDBkey() );

		// Select any applicable watchlist entries for the thread.
		$where_clause = <<<SQL
(
	(wl_namespace = {$talkpage_t->getNamespace()} and wl_title = $q_talkpage_t )
or	(wl_namespace = {$root_t->getNamespace()} and wl_title = $q_root_t )
)
SQL;

		// it sucks to not have 'on duplicate key update'. first update users who already have a ums for this thread
		// and who have already read it, by setting their state to unread.
		$dbw->query( "update {$wgDBprefix}user_message_state, {$wgDBprefix}watchlist set ums_read_timestamp = null where ums_user = wl_user and ums_thread = {$t->id()} and $where_clause" );

		$dbw->query( "insert ignore into {$wgDBprefix}user_message_state (ums_user, ums_thread) select user_id, {$t->id()} from {$wgDBprefix}user, {$wgDBprefix}watchlist where user_id = wl_user and $where_clause;" );
	}

	static function newUserMessages( $user ) {
		global $wgDBprefix;
		return Threads::where( array( 'ums_read_timestamp is null',
									Threads::articleClause( new Article( $user->getUserPage() ) ) ),
							 array(), array(), "left outer join {$wgDBprefix}user_message_state on ums_user is null or (ums_user = {$user->getID()} and ums_thread = thread.thread_id)" );
	}

	static function watchedThreadsForUser( $user ) {
		return Threads::where( array( 'ums_read_timestamp is null',
			'ums_user' => $user->getID(),
			'ums_thread = thread.thread_id',
			'NOT (' . Threads::articleClause( new Article( $user->getUserPage() ) ) . ')' ),
			array(), array( 'user_message_state' ) );
	}
}
