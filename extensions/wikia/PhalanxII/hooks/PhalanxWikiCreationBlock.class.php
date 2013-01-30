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
	
	public function isAllowedText( $text, $where, $split ) {
		wfProfileIn( __METHOD__ );

		$text = trim($text);
		$phalanxModel = F::build('PhalanxTextModel', array( $text ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		$result = $phalanxModel->match( "wiki_creation" );
		if ( $result !== false ) {
			if ( 
				is_object( $result ) && 
				isset( $result->id ) &&
				$result->id > 0 
			) {
				$phalanxModel->setBlockId( $result->id )->logBlock();
				$ret = false;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/WikiCreationBlock.class.php';
			// $ret = WikiCreationBlock::isAllowedText( $text, $where, $split );
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
