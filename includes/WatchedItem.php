<?php
/**
 * @file
 * @ingroup Watchlist
 */

/**
 * @ingroup Watchlist
 */
class WatchedItem {
	var $mTitle, $mUser, $id, $ns, $ti;

	/**
	 * Create a WatchedItem object with the given user and title
	 * @param $user User: the user to use for (un)watching
	 * @param $title Title: the title we're going to (un)watch
	 * @return WatchedItem object
	 */
	public static function fromUserTitle( $user, $title ) {
		$wl = new WatchedItem;
		$wl->mUser = $user;
		$wl->mTitle = $title;
		$wl->id = $user->getId();
		# Patch (also) for email notification on page changes T.Gries/M.Arndt 11.09.2004
		# TG patch: here we do not consider pages and their talk pages equivalent - why should we ?
		# The change results in talk-pages not automatically included in watchlists, when their parent page is included
		# $wl->ns = $title->getNamespace() & ~1;
		$wl->ns = $title->getNamespace();

		$wl->ti = $title->getDBkey();
		return $wl;
	}

	/**
	 * Is mTitle being watched by mUser?
	 * @return bool
	 */
	public function isWatched() {
		# Pages and their talk pages are considered equivalent for watching;
		# remember that talk namespaces are numbered as page namespace+1.

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'watchlist', 1, array( 'wl_user' => $this->id, 'wl_namespace' => $this->ns,
			'wl_title' => $this->ti ), __METHOD__ );
		$iswatched = ($dbr->numRows( $res ) > 0) ? 1 : 0;
		return $iswatched;
	}

	/**
	 * Given a title and user (assumes the object is setup), add the watch to the
	 * database.
	 * @return bool (always true)
	 */
	public function addWatch() {
		wfProfileIn( __METHOD__ );
		$rows = array();

		// Use INSERT IGNORE to avoid overwriting the notification timestamp
		// if there's already an entry for this page
		$dbw = wfGetDB( DB_MASTER );
		$timestamp = null;
		
		$rows[] = array(
			'wl_user' => $this->id,
			'wl_namespace' => MWNamespace::getSubject( $this->ns ),
			'wl_title' => $this->ti,
			'wl_notificationtimestamp' => $timestamp
		);
		
		$rows[] = array(
			'wl_user' => $this->id,
			'wl_namespace' => MWNamespace::getTalk($this->ns),
			'wl_title' => $this->ti,
			'wl_notificationtimestamp' => $timestamp
		);
		
		$dbw->insert( 'watchlist', $rows, __METHOD__, 'IGNORE' );
		
		wfRunHooks( 'WatchedItem::addWatch', array ( $this ) );
		
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Same as addWatch, only the opposite.
	 * @return bool
	 */
	public function removeWatch() {
		wfProfileIn( __METHOD__ );

		$success = false;
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'watchlist',
			array(
				'wl_user' => $this->id,
				'wl_namespace' => MWNamespace::getSubject($this->ns),
				'wl_title' => $this->ti
			), __METHOD__
		);
		if ( $dbw->affectedRows() ) {
			$success = true;
		}

		# the following code compensates the new behaviour, introduced by the
		# enotif patch, that every single watched page needs now to be listed
		# in watchlist namespace:page and namespace_talk:page had separate
		# entries: clear them
		$dbw->delete( 'watchlist',
			array(
				'wl_user' => $this->id,
				'wl_namespace' => MWNamespace::getTalk($this->ns),
				'wl_title' => $this->ti
			), __METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$success = true;
		}

		wfRunHooks( 'WatchedItem::removeWatch', array ( $this, $success ) );

		wfProfileOut( __METHOD__ );

		return $success;
	}

	/**
	 * Wikia changes: update watch in database
	 * @param $watchers Array: array of users IDs. If empty, $this->id is taken
	 * @param $timestamp: update timestamp
	 * @return bool (always true)
	 */
	public function updateWatch( /*Array*/$watchers = null, $timestamp = null ) {
		$dbw = wfGetDB( DB_MASTER );
		
		$user = ( !empty($watchers) ) ? $watchers : $this->id;
		$ts = ( !is_null( $timestamp ) ) ? $dbw->timestamp( $timestamp ) : null;
		
		$dbw->begin();
		$dbw->update( 'watchlist',
				array( /* SET */
					'wl_notificationtimestamp' => $ts
				), array( /* WHERE */
					'wl_title' => $this->ti,
					'wl_namespace' => $this->ns,
					'wl_user' => $user
				), __METHOD__
		);
		$dbw->commit();
		
		wfRunHooks( 'WatchedItem::updateWatch', array ( $this, $user, $ts ) );
		
		return true;	
	}
	
	/**
	 * Wikia changes: clear user's notification 
	 * @return bool (always true)
	 */
	public function clearWatch() {
		return $this->updateWatch();
	}

	/**
	 * Check if the given title already is watched by the user, and if so
	 * add watches on a new title. To be used for page renames and such.
	 *
	 * @param $ot Title: page title to duplicate entries from, if present
	 * @param $nt Title: page title to add watches on
	 */
	public static function duplicateEntries( $ot, $nt ) {
		WatchedItem::doDuplicateEntries( $ot->getSubjectPage(), $nt->getSubjectPage() );
		WatchedItem::doDuplicateEntries( $ot->getTalkPage(), $nt->getTalkPage() );
	}

	/**
	 * Handle duplicate entries. Backend for duplicateEntries().
	 *
	 * @param $ot Title
	 * @param $nt Title
	 *
	 * @return bool
	 */
	private static function doDuplicateEntries( $ot, $nt ) {	
		$oldnamespace = $ot->getNamespace();
		$newnamespace = $nt->getNamespace();
		$oldtitle = $ot->getDBkey();
		$newtitle = $nt->getDBkey();

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select( 'watchlist', 'wl_user',
			array( 'wl_namespace' => $oldnamespace, 'wl_title' => $oldtitle ),
			__METHOD__, 'FOR UPDATE'
		);
		# Construct array to replace into the watchlist
		$values = array();
		foreach ( $res as $s ) {
			$values[] = array(
				'wl_user' => $s->wl_user,
				'wl_namespace' => $newnamespace,
				'wl_title' => $newtitle
			);
		}

		if( empty( $values ) ) {
			// Nothing to do
			return true;
		}

		# Perform replace
		# Note that multi-row replace is very efficient for MySQL but may be inefficient for
		# some other DBMSes, mostly due to poor simulation by us
		$dbw->replace( 'watchlist', array( array( 'wl_user', 'wl_namespace', 'wl_title' ) ), $values, __METHOD__ );
		
		wfRunHooks( 'WatchedItem::replaceWatch', array ( $ot, $nt, $values ) );
				
		return true;
	}
}
