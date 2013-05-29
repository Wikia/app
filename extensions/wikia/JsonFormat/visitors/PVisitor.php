<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 11:35
 */

class PVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return $this->isElement( $currentNode, 'p' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$this->iterate( $currentNode->childNodes );
	}
}
