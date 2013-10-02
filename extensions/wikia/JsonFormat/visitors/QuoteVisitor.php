<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 15:14
 */

class QuoteVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'dl' )
			&& $currentNode->childNodes->length == 2
			&& DomHelper::isElement( $currentNode->childNodes->item(0), 'dd')
			&& DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(0), 'span')
			&& DomHelper::isElement( $currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(1), 'i')
			&& DomHelper::isElement( $currentNode->childNodes->item(1), 'dd')
			;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$author = $currentNode->childNodes->item(1)->textContent;
		$text = $currentNode->childNodes->item(0)->childNodes->item(0)->childNodes->item(1)->textContent;
		$quoteNode = new JsonFormatQuoteNode( $author, $text );
		$this->getJsonFormatBuilder()->add($quoteNode);
	}
}
