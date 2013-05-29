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
		return $this->isElement( $currentNode, 'ul' ) || $this->isElement( $currentNode, 'ol' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		$list = new JsonFormatListNode( $this->isElement( $currentNode, 'ol' ) );
		$this->getJsonFormatTraversingState()->pushNode( $list );
		for( $i = 0; $i < $currentNode->childNodes->length; $i++ ) {
			$childNode = $currentNode->childNodes->item($i);
			if ( $this->isElement( $childNode, 'li' ) ) {
				$this->visitListItem( $childNode );
			}
		}
		$this->getJsonFormatTraversingState()->popNode( $list );
	}

	public function visitListItem( DOMNode $li ) {
		$item = new JsonFormatListItemNode( );
		$this->getJsonFormatTraversingState()->pushNode( $item );
		$this->iterate( $li->childNodes );
		$this->getJsonFormatTraversingState()->popNode( $item );
	}
}
