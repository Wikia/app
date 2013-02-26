<?php
class PhalanxTextModel extends PhalanxModel {
	public function __construct( $text, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'text' => $text, 'lang' => $lang, 'id' => $id ) );
	}
	
	public function isOk() { 
		return empty( $this->text );
	}
	
	public function wiki_creation() {
		return $this->match( "wiki_creation" );
	}
	
	public function wiki_creation_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension */
		return WikiCreationBlock::isAllowedText( $this->getText(), '', '' );
	}
}
