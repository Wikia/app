<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 17:31
 */

class ImageNoScriptVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'a' )
			&& DomHelper::hasClass( $currentNode, 'image' )
			&& $currentNode->childNodes->length == 2
			&& DomHelper::isElement( $currentNode->childNodes->item(1), 'noscript' )
			&& DomHelper::isElement( $currentNode->childNodes->item(1)->childNodes->item(0), 'img' )
			;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		/** @noinspection PhpUndefinedMethodInspection we check that in canVisit */
		$src = $currentNode->childNodes->item(1)->childNodes->item(0)->getAttribute('src');
		$this->getJsonFormatBuilder()->add( new JsonFormatImageNode($src) );
	}
}
