<?php
#
# Comment represents comments, i.e. text in <!-- -->
#

class POMComment extends POMElement {

	protected $nodeText = '';

	public function POMComment($text) {
		$this->nodeText = $text;
		$this->children = null; // forcefully ignore children
	}

	public function asString() {
		return '<!--' . $this->nodeText . '-->';
	}
}
