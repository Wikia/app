<?php
/**
 * @file
 * @ingroup Watchlist
 */

/**
 * @ingroup Watchlist
 *
 * Note: MediaWiki works with the assumption that when people watch pages they either watch both the talk page
 * and the normal page, or neither. That means that for each watched page MediaWiki always automatically adds
 * two entries: One for the page and one for its talk page. E.g. when the user watches the Main Page, then there
 * will be two rows in the database table: One for the Main Page in namespace 0 and one for the Main Page in
 * namespace 1 (which is the according talk page).
 *
 * More information: http://www.mediawiki.org/wiki/Manual:Watchlist_table
 */
class WatchedItem {

	/* @var Title $mTitle */
	public $mTitle;

	/* @var User $mUser  */
	public $mUser;

	public $userID;

	public $nameSpace;

	public $databaseKey;

	/**
	 * Create a WatchedItem object with the given user and title
	 * @param $user User: the user to use for (un)watching
	 * @param $title Title: the title we're going to (un)watch
	 * @return WatchedItem object
	 */
	public static function fromUserTitle( $user, $title ) {
		$watchedItem = new WatchedItem;
		$watchedItem->mUser = $user;
		$watchedItem->mTitle = $title;
		$watchedItem->userID = $user->getId();
		# Patch (also) for email notification on page changes T.Gries/M.Arndt 11.09.2004
		# TG patch: here we do not consider pages and their talk pages equivalent - why should we ?
		# The change results in talk-pages not automatically included in watchlists, when their parent page is included
		# $wl->nameSpace = $title->getNamespace() & ~1;
		$watchedItem->nameSpace = $title->getNamespace();

		$watchedItem->databaseKey = $title->getDBkey();
		return $watchedItem;
	}

	/**
	 * Is mTitle being watched by mUser?
	 * @return bool
	 */
	public function isWatched() {
		# Pages and their talk pages are considered equivalent for watching;
		# remember that talk namespaces are numbered as page namespace+1.

		// Only loggedin user can have a watchlist
		if ( $this->mUser->isAnon() ) {
			return false;
		}

		// some pages cannot be watched
		if ( !$this->mTitle->isWatchable() ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'watchlist', 1, array( 'wl_user' => $this->userID, 'wl_namespace' => $this->nameSpace,
			'wl_title' => $this->databaseKey ), __METHOD__ );
		$iswatched = ($dbr->numRows( $res ) > 0) ? 1 : 0;
		return $iswatched;
	}

	/**
	 * Given a title and user (assumes the object is setup), add the watch to the
	 * database.
	 * @return bool (always true)
	 */
	public function addWatch() {

		// Only loggedin user can have a watchlist
		if ( wfReadOnly() || $this->mUser->isAnon() ) {
			return false;
		}

		$rows = array();

		// Use INSERT IGNORE to avoid overwriting the notification timestamp
		// if there's already an entry for this page
		$dbw = wfGetDB( DB_MASTER );
		$timestamp = null;
		
		$rows[] = array(
			'wl_user' => $this->userID,
			'wl_namespace' => MWNamespace::getSubject( $this->nameSpace ),
			'wl_title' => $this->databaseKey,
			'wl_notificationtimestamp' => $timestamp
		);
		
		$rows[] = array(
			'wl_user' => $this->userID,
			'wl_namespace' => MWNamespace::getTalk($this->nameSpace),
			'wl_title' => $this->databaseKey,
			'wl_notificationtimestamp' => $timestamp
		);
		
		$dbw->insert( 'watchlist', $rows, __METHOD__, 'IGNORE' );
		
		wfRunHooks( 'WatchedItem::addWatch', array ( $this ) );
		
		return true;
	}

	/**
	 * Same as addWatch, only the opposite.
	 * @return bool
	 */
	public function removeWatch() {

		// Only loggedin user can have a watchlist
		if ( wfReadOnly() || $this->mUser->isAnon() ) {
			return false;
		}

		$success = false;
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'watchlist',
			array(
				'wl_user' => $this->userID,
				'wl_namespace' => MWNamespace::getSubject($this->nameSpace),
				'wl_title' => $this->databaseKey
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
				'wl_user' => $this->userID,
				'wl_namespace' => MWNamespace::getTalk($this->nameSpace),
				'wl_title' => $this->databaseKey
			), __METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$success = true;
		}

		wfRunHooks( 'WatchedItem::removeWatch', array ( $this, $success ) );

		return $success;
	}

	/**
	 * Wikia changes: update watch in database
	 * @param $watchers Array: array of users IDs. If empty, $this->userID is taken
	 * @param $timestamp: update timestamp
	 * @return bool (always true)
	 */
	public function updateWatch( $watchers = null, $timestamp = null ) {
		$dbw = wfGetDB( DB_MASTER );
		
		$user = ( !empty($watchers) ) ? $watchers : $this->userID;
		$ts = ( !is_null( $timestamp ) ) ? $dbw->timestamp( $timestamp ) : null;

		$dbw->begin();
		$dbw->update( 'watchlist',
				array( /* SET */
					'wl_notificationtimestamp' => $ts
				), array( /* WHERE */
					'wl_title' => $this->databaseKey,
					'wl_namespace' => $this->nameSpace,
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
	 * @param $oldTitle Title
	 * @param $newTitle Title
	 *
	 * @return bool
	 * TODO Make sure that this logic is still the same!
	 */
	private static function doDuplicateEntries( $oldTitle, $newTitle ) {

		( new WikiaSQL() )
			->UPDATE( 'watchlist' )
			->SET( 'wl_title', $newTitle->getDBkey() )
			->SET( 'wl_namespace', $newTitle->getNamespace() )
			->WHERE( 'wl_title' )->EQUAL_TO( $oldTitle->getDBkey() )
			->AND_( 'wl_namespace' )->EQUAL_TO( $oldTitle->getNamespace() );

		wfRunHooks( 'WatchedItem::replaceWatch', [ $oldTitle, $newTitle ] );
				
		return true;
	}
}
