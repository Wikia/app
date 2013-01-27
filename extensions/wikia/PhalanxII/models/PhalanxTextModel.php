<?php
class PhalanxBlockModel extends PhalanxModel {
	public function __construct( $text, $id = 0 ) {
		parent::__construct( __CLASS__, array( 'text' => $text, 'id' => $id ) );
	}
	
	public function isOk() {
		return empty( $this->text );
	}
}
