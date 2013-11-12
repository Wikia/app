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
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'p' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$paragraphNode = new JsonFormatParagraphNode();
		$this->getJsonFormatBuilder()->pushNode( $paragraphNode );
		$this->iterate( $currentNode->childNodes );
		$this->getJsonFormatBuilder()->popNode( $paragraphNode );
	}
}
