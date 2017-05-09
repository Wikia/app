<?php
class PhalanxTextModel extends PhalanxModel {
	public function __construct( string $text ) {
		parent::__construct();
		$this->text = $text;
	}

	public function match_wiki_creation() {
		return $this->match( "wiki_creation" );
	}

	public function match_wiki_creation_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return WikiCreationBlock::isAllowedText( $this->getText(), $this->block );
	}
}
