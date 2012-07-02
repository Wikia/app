<?php
#
# Comment represents comments, i.e. text in <!-- -->
#

class POMComment extends POMElement {

	protected $nodeText = '';

	public function POMComment( $text ) {
		$text = substr( $text, 4, strlen( $text ) - 7 );
		$this->nodeText = $text;
		$this->children = null; // forcefully ignore children
	}

	public function asString() {
		if ( $this->hidden() ) return "";
		return '<!--' . $this->nodeText . '-->';
	}
}
