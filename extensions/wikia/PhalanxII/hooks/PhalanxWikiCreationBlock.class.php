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
	}
	
	static public function isAllowedText( $text, $where = '', $split = '' ) {
		wfProfileIn( __METHOD__ );

		$text = trim( $text );
		$phalanxModel = new PhalanxTextModel( $text );
		$ret = $phalanxModel->match_wiki_creation();
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
