<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 17:20
 */

class BrVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return DomHelper::isElement( $currentNode, 'br' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$this->getJsonFormatBuilder()->appendText("\n");
	}
}
