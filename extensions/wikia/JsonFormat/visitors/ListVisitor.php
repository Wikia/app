<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 12:11
 */

class ListVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'ul' ) || DomHelper::isElement( $currentNode, 'ol' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$list = new JsonFormatListNode( DomHelper::isElement( $currentNode, 'ol' ) );
		$this->getJsonFormatBuilder()->pushNode( $list );
		for( $i = 0; $i < $currentNode->childNodes->length; $i++ ) {
			$childNode = $currentNode->childNodes->item($i);
			if ( DomHelper::isElement( $childNode, 'li' ) ) {
				$this->visitListItem( $childNode );
			}
		}
		$this->getJsonFormatBuilder()->popNode( $list );
	}

	public function visitListItem( DOMNode $li ) {
		$item = new JsonFormatListItemNode( );
		$this->getJsonFormatBuilder()->pushNode( $item );
		$this->iterate( $li->childNodes );
		$this->getJsonFormatBuilder()->popNode( $item );
	}
}
