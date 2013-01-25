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
	static private $blocksData = null;

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

	public function listCallback( $editPage, $text, $section, &$hookError ) {
		$this->wf->profileIn( __METHOD__ );

		$ret = true;
		$title = $editPage->mTitle;

		$phalanxModel = F::build('PhalanxTitleModel', array( $title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* 
		 * Hook is called for both page creations and edits. We should only check
		 * if the page is created = page does not exist (RT#61104)
		 */
		if ( $title->exists() ) {
			$this->wf->profileOut( __METHOD__ );
			return $ret;
		}

		/* check title */
		$ret = $this->checkTitle( $title );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	public function checkTitle( $title ) {
		$phalanxModel = F::build('PhalanxTitleModel', array( $title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		/* check title name */
		$text = $title->getFullText();

		$result = PhalanxService::match( "title", $text );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result );
				// set output with block info
				$phalanxModel->displayBlock( $text );
				$ret = false;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/TitleBlock.class.php';
			// $ret = TitleBlock::genericTitleCheck( $title );		
		}
		
		return $ret;
	}
}
