<?php

/**
 * TitleBlock
 *
 * This filter prevents a page from being created,
 * if its title matches any of the blacklisted phrases.
 * It does not prevent a pre-existing page from being edited.
 * 
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-25
 */

class PhalanxTitleBlock extends WikiaObject {

	/**
	 * handler for beforeMove hook
	 *
	 * @static
	 *
	 * @param MovePageForm $move -- Special::Move class instance
	 *
	 * @return bool true -- pass hook further
	 */
	static public function beforeMove( &$move ) {
		wfProfileIn( __METHOD__ );

		/* title object */
		$title = Title::newFromURL( $move->newTitle );

		/* check title */
		$ret = PhalanxTitleBlock::checkTitle( $title );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * handler for editFilter hook
	 *
	 * @param EditPage $editPage -- edit page instance
	 * @static
	 */
	static public function editFilter( $editPage, $text, $section, &$hookError, $summary ) {
		wfProfileIn( __METHOD__ );

		$title = $editPage->getTitle();
		/* 
		 * Hook is called for both page creations and edits. We should only check
		 * if the page is created = page does not exist (RT#61104)
		 */
		if( $title->exists() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		/**
		 * pass to check title method
		 */
		$ret = PhalanxTitleBlock::checkTitle( $title );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * handler for checkTitle hook
	 *
	 * @static
	 *
	 * @param Title $title -- title instance
	 * @param Bool $displayBlock -- shoould block be displayed or not
	 *
	 * @return bool true -- pass hook further
	 */
	static public function checkTitle( $title, $displayBlock = true ) {
		wfProfileIn( __METHOD__ );

		$phalanxModel = new PhalanxContentModel( $title );
		$ret = $phalanxModel->match_title();
		
		if ( $ret === false && $displayBlock ) {
			$phalanxModel->displayBlock();
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/**
	 * handler for pageTitleFilter hook
	 *
	 * @static
	 *
	 * @param Title $title -- title for checking
	 * @param String $error_msg -- returned message, by reference
	 *
	 * @return bool true -- pass hook further
	 */
	static public function pageTitleFilter( $title, &$error_msg ) {
		wfProfileIn( __METHOD__ );

		$phalanxModel = new PhalanxContentModel( $title );
		$ret = $phalanxModel->match_title();
		
		if ( $ret === false ) {
			$error_msg = $phalanxModel->contentBlock();
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
