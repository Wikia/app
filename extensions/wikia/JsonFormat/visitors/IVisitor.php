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
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'i' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$this->iterate( $currentNode->childNodes );
	}
}
