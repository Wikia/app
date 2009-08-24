<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

// TODO get rid of this class. sheesh.
class Post extends Article {
	/**
	* Return the User object representing the author of the first revision
	* (or null, if the database is screwed up).
	*/
	function originalAuthor() {
		$dbr =& wfGetDB( DB_SLAVE );

		$line = $dbr->selectRow( array( 'revision', 'page' ), 'rev_user_text',
			array( 'rev_page = page_id',
			'page_id' => $this->getID() ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp',
			'LIMIT'   => '1' ) );
		if ( $line )
			return User::newFromName( $line->rev_user_text, false );
		else
			return null;
	}
}
