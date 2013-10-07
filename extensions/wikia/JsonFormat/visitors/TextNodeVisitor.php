<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 19:22
 */

class TextNodeVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		return $currentNode instanceof DOMText;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		/** @var DOMText $currentNode */
		echo("text:" . $currentNode->nodeValue);
		$text = $currentNode->textContent;
		$this->getJsonFormatBuilder()->appendText( $text );
	}
}
