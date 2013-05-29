<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 12:26
 */

class SpanVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		return $this->isElement( $currentNode, 'span' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$this->iterate( $currentNode->childNodes );
	}
}
