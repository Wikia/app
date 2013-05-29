<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 12:01
 */

class IVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return $this->isElement( $currentNode, 'i' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$this->iterate( $currentNode->childNodes );
	}
}
