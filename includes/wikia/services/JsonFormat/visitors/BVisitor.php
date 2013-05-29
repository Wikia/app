<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 11:58
 */

class BVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return $this->isElement( $currentNode, 'b' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$this->iterate( $currentNode->childNodes );
	}
}
