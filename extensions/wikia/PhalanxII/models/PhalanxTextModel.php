<?php
class PhalanxTextModel extends PhalanxModel {
	public function __construct( $text, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'text' => $text, 'lang' => $lang, 'id' => $id ) );
	}
	
	public function match_wiki_creation() {
		return $this->match( "wiki_creation" );
	}
	
	public function match_wiki_creation_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return WikiCreationBlock::isAllowedText( $this->getText(), $this->block );
	}
}
