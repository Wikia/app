<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 19:33
 */

class VideoVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'a' )
				&& DomHelper::hasClass( $currentNode, 'video' )
				&& DomHelper::hasChildTag( $currentNode, 'img' )
			;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		//TODO: IGNORE FOR NOW
	}
}
