<?php
#
# TextNode represents simple text
#

class POMTextNode extends POMElement {

	protected $nodeText = '';

	public function POMTextNode($text)
	{
		$this->nodeText = $text;
		$this->children = null; // forcefully ignore children
	}

	public function asString()
	{
		return $this->nodeText;
	}
}

