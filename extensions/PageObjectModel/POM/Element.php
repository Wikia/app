<?php
#
# Element is an abstract class that represents any part distinguished within the page.
# All real elements must be a subclass of this class
#

abstract class POMElement {

	public $children = array();

	function asString() {
		$output = '';

		foreach ($this->children as $child)
		{
			$output.=$child->asString();
		}

		return $output;
	}

	function addChild(POMElement $el)
	{
		$this->children[] = $el;
	}
}

