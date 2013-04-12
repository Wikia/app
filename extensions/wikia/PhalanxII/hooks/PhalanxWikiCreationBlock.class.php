<?php

/**
 * This filter blocks a wiki from being created,
 * if it's name contains unwanted phrases.
 *
 * @see extensions/wikia/AutoCreateWiki/
 */

class PhalanxWikiCreationBlock extends WikiaObject {
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	public function isAllowedText( $text, $where = '', $split = '' ) {
		$this->wf->profileIn( __METHOD__ );

		$text = trim( $text );
		$phalanxModel = F::build( 'PhalanxTextModel', array( $text ) );
		$ret = $phalanxModel->match_wiki_creation();
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
