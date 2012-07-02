<?php

class UniwikiAutoCreateCategoryPages {
	public function UW_AutoCreateCategoryPages_Save ( &$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags, $revision ) {
		global $wgDBprefix;

		/* after the page is saved, get all the categories
		 * and see if they exists as "proper" pages; if not
		 * then create a simple page for them automatically */

		// Extract the categories on this page
		//
		// FIXME: this obviously only works for the English namespaces
		//
		$category = wfMsg("nstab-category");
		$regex = "/\[\[{$category}:(.+?)(?:\|.*)?\]\]/i";
		preg_match_all ( $regex, $text, $matches );

		// array of the categories on the page (in db form)
		$on_page = array();
		foreach ( $matches[1] as $cat )
			$on_page[] = Title::newFromText ( $cat )->getDBkey();

		$regex = "/\[\[category:(.+?)(?:\|.*)?\]\]/i";
		preg_match_all ( $regex, $text, $matches );

		foreach ( $matches[1] as $cat )
			$on_page[] = Title::newFromText ( $cat )->getDBkey();

		// array of the categories in the db
		$db = wfGetDB ( DB_MASTER );
		$results = $db->resultObject ( $db->query(
			"select distinct page_title from {$wgDBprefix}page " .
			"where page_namespace = '" . NS_CATEGORY . "'" )
		);

		$in_db = array();
		while ( $r = $results->next() )
			$in_db[] = $r->page_title;

		/* loop through the categories in the page and
		* see if they already exist as a category page */
		foreach ( $on_page as $db_key ) {
			if ( !in_array( $db_key, $in_db ) ) {

				

				// Create a user object for the editing user and add it to the database
				// if it is not there already
				$editor = User::newFromName( wfMsgForContent( 'autocreatecategorypages-editor' ) );
				if ( !$editor->isLoggedIn() ) {
					$editor->addToDatabase();
				}

				// if it does not exist, then create it here
				$page_title = Title::newFromDBkey ( $db_key )->getText();
				$stub = wfMsgForContent ( 'autocreatecategorypages-stub', $page_title );
				$summary = wfMsgForContent ( 'autocreatecategorypages-createdby' );
				$article = new Article ( Title::newFromDBkey( "Category:$db_key" ) );

				try {
					$article->doEdit ( $stub, $summary, EDIT_NEW & EDIT_SUPPRESS_RC, false, $editor );

				} catch ( MWException $e ) {
					/* fail silently...
					* todo: what can go wrong here? */
				}
			}
		}

		return true;
	}

	public function UW_OnUserGetReservedNames( &$names ) {
		
		$names[] = 'msg:autocreatecategorypages-editor';
		return true;
	}
}
