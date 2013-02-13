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
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	public function beforeMove( &$move ) {
		$this->wf->profileIn( __METHOD__ );

		/* title object */
		$title = Title::newFromURL( $move->newTitle );

		/* check title */
		$ret = $this->checkTitle( $title );
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function editFilter( $editPage, $text, $section, &$hookError, $summary ) {
		$this->wf->profileIn( __METHOD__ );

		$title = $editPage->getTitle();

		/* 
		 * Hook is called for both page creations and edits. We should only check
		 * if the page is created = page does not exist (RT#61104)
		 */
		if ( $title->exists() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* check title */
		$ret = $this->checkTitle( $title );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	public function checkTitle( $title ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxContentModel', array( $title ) );
		$ret = $phalanxModel->match_title();
		
		if ( $ret === false ) {
			$phalanxModel->displayBlock();
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
