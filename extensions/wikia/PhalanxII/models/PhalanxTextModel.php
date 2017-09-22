<?php
class PhalanxTextModel extends PhalanxModel {
	public function __construct( string $text ) {
		parent::__construct();
		$this->text = $text;
	}

	public function match_wiki_creation() {
		return $this->match( "wiki_creation" );
	}
}
