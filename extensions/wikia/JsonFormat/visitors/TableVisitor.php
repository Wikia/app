<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 15:20
 */

class TableVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement($currentNode, 'table');
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$table = new JsonFormatTableNode( );
		$this->getJsonFormatBuilder()->pushNode( $table );
		for( $i = 0; $i < $currentNode->childNodes->length; $i++ ) {
			$childNode = $currentNode->childNodes->item($i);
			$this->tryVisitTBody( $childNode );
			$this->tryVisitRow( $childNode );
		}
		$this->getJsonFormatBuilder()->popNode( $table );
	}

	protected function tryVisitTBody( $currentNode ) {
		if ( DomHelper::isElement( $currentNode, 'tbody' ) ) {
			/** @var DOMElement $currentNode */
			for( $i = 0; $i < $currentNode->childNodes->length; $i++ ) {
				$childNode = $currentNode->childNodes->item($i);
				$this->tryVisitRow( $childNode );
			}
		}
	}

	protected function tryVisitRow( $currentNode ) {
		if ( DomHelper::isElement( $currentNode, 'tr' ) ) {
			/** @var DOMElement $currentNode */
			$row = new JsonFormatTableRowNode( );
			$this->getJsonFormatBuilder()->pushNode( $row );

			for( $i = 0; $i < $currentNode->childNodes->length; $i++ ) {
				$childNode = $currentNode->childNodes->item($i);
				$this->tryVisitCell( $childNode );
			}

			$this->getJsonFormatBuilder()->popNode( $row );
		}
	}

	protected function tryVisitCell( DOMNode $currentNode ) {
		if ( DomHelper::isElement( $currentNode, 'td' )
			|| DomHelper::isElement( $currentNode, 'th' )) {
			$cell = new JsonFormatTableCellNode( );
			$this->getJsonFormatBuilder()->pushNode( $cell );

			if ( $this->hasSingleDiv( $currentNode ) ) {
				// special case: if single div, ignore it but get all the contents.
				// tables cells often contain div wrapper
				$this->iterate( $currentNode->childNodes->item(0)->childNodes );
			} else {
				$this->iterate( $currentNode->childNodes );
			}

			$this->getJsonFormatBuilder()->popNode( $cell );
		}
	}

	protected function hasSingleDiv( DOMNode $currentNode ) {
		return DomHelper::isElement( $currentNode, 'td' )
			&& $currentNode->childNodes->length == 1
			&& DomHelper::isElement( $currentNode->childNodes->item(0), 'div' );
	}
}
