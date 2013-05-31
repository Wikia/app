<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 19:33
 */

class AVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		return DomHelper::isElement( $currentNode, 'a' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		$href = $currentNode->attributes->getNamedItem('href')->textContent;
		$this->getJsonFormatBuilder()->add(
			new JsonFormatLinkNode( $currentNode->textContent, $href ) );
	}
}
