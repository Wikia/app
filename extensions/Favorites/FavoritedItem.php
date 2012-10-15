<?php
/**
 * @file
 * @ingroup Favoritelist
 */

/**
 * @ingroup Favoritelist
 */
class FavoritedItem {
	var $mTitle, $mUser, $id, $ns, $ti;

	/**
	 * Create a FavoritedItem object with the given user and title
	 * @param $user User: the user to use for (un)favoriting
	 * @param $title Title: the title we're going to (un)favorite
	 * @return FavoritedItem object
	 */
	public static function fromUserTitle( $user, $title ) {
		$fl = new FavoritedItem;
		$fl->mUser = $user;
		$fl->mTitle = $title;
		$fl->id = $user->getId();
		$fl->ns = $title->getNamespace();
		$fl->ti = $title->getDBkey();
		return $fl;
	}

	/**
	 * Is mTitle being favorited by mUser?
	 * @return bool
	 */
	public function isFavorited() {

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'favoritelist', 1, array( 'fl_user' => $this->id, 'fl_namespace' => $this->ns,
			'fl_title' => $this->ti ), __METHOD__ );
		$isfavorited = ($dbr->numRows( $res ) > 0) ? 1 : 0;
		return $isfavorited;
	}

	/**
	 * Given a title and user (assumes the object is setup), add the favorite to the
	 * database.
	 * @return bool (always true)
	 */
	public function addFavorite() {
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'favoritelist',
		  array(
			'fl_user' => $this->id,
			'fl_namespace' => MWNamespace::getSubject($this->ns),
			'fl_title' => $this->ti,
			'fl_notificationtimestamp' => null
		  ), __METHOD__, 'IGNORE' );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Same as addFavorite, only the opposite.
	 * @return bool
	 */
	public function removeFavorite() {
		$success = false;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'favoritelist',
			array(
				'fl_user' => $this->id,
				'fl_namespace' => MWNamespace::getSubject($this->ns),
				'fl_title' => $this->ti
			), __METHOD__
		);
		if ( $dbw->affectedRows() ) {
			$success = true;
		}
		return $success;
	}

	/**
	 * Check if the given title already is favorited by the user, and if so
	 * add favorite on a new title. To be used for page renames and such.
	 *
	 * @param $ot Title: page title to duplicate entries from, if present
	 * @param $nt Title: page title to add favorite on
	 */
	public static function duplicateEntries( $ot, $nt ) {
		FavoritedItem::doDuplicateEntries( $ot->getSubjectPage(), $nt->getSubjectPage() );
		//FavoritedItem::doDuplicateEntries( $ot->getTalkPage(), $nt->getTalkPage() );
	}

	/**
	 * Handle duplicate entries. Backend for duplicateEntries().
	 */
	private static function doDuplicateEntries( $ot, $nt ) {	
		$oldnamespace = $ot->getNamespace();
		$newnamespace = $nt->getNamespace();
		$oldtitle = $ot->getDBkey();
		$newtitle = $nt->getDBkey();

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select( 'favoritelist', 'fl_user',
			array( 'fl_namespace' => $oldnamespace, 'fl_title' => $oldtitle ),
			__METHOD__, 'FOR UPDATE'
		);
		# Construct array to replace into the favoritelist
		$values = array();
		while ( $s = $dbw->fetchObject( $res ) ) {
			$values[] = array(
				'fl_user' => $s->fl_user,
				'fl_namespace' => $newnamespace,
				'fl_title' => $newtitle
			);
		}
		$dbw->freeResult( $res );

		if( empty( $values ) ) {
			// Nothing to do
			return true;
		}

		# Perform replace
		# Note that multi-row replace is very efficient for MySQL but may be inefficient for
		# some other DBMSes, mostly due to poor simulation by us
		$dbw->replace( 'favoritelist', array( array( 'fl_user', 'fl_namespace', 'fl_title' ) ), $values, __METHOD__ );
		
		# Delete the old item - we don't need to have the old page on the list of favorites.
		$dbw->delete('favoritelist', array(
			'fl_namespace' => $oldnamespace,
			'fl_title' => $oldtitle), 
			$fname = 'Database::delete');
		return true;
	}
}
