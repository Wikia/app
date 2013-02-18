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
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/WikiCreationBlock.class.php';
		// $ret = WikiCreationBlock::isAllowedText( $this->text, '', '' );
		return true;
	}
}
