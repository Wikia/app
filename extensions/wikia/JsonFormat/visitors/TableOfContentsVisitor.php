<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:33
 */

class TableOfContentsVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return
			DomHelper::isElement( $currentNode, 'table' )
			&& DomHelper::hasClass( $currentNode, 'toc' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		// do nothing
		// ignore table of contents
	}
}
