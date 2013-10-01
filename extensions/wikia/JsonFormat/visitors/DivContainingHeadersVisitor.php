<?php


//namespace Wikia\JsonFormat\visitors;


class DivContainingHeadersVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		return DomHelper::isElement( $currentNode, 'div' ) &&
			\DomHelper::hasAncestorTag( $currentNode, [ "h1", "h2", "h3", "h4","h5", "h6" ]);
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		$this->iterate( $currentNode->childNodes );
	}
}
