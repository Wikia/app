<?php
/**
 * User: artur
 * Date: 03.06.13
 * Time: 11:31
 */

class InfoboxTableVisitor extends DOMNodeVisitorBase {

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */

		return DomHelper::isElement( $currentNode, 'table' )
			&& DomHelper::hasClass( $currentNode,'infobox' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit(DOMNode $currentNode) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$table = new JsonFormatInfoboxNode( );
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
		if ( DomHelper::isElement( $currentNode, 'tr' )
			&& $currentNode->childNodes->length == 2 ) {
			/** @var DOMElement $currentNode */
			$keyValue = new JsonFormatInfoboxKeyValueNode( $currentNode->childNodes->item(0)->textContent );
			$this->getJsonFormatBuilder()->pushInfoboxKeyValue( $keyValue );

			$this->tryVisitCell( $currentNode->childNodes->item(1) );

			$this->getJsonFormatBuilder()->popInfoboxKeyValue( $keyValue );
		}
	}

	protected function tryVisitCell( DOMNode $currentNode ) {
		if ( DomHelper::isElement( $currentNode, 'td' ) ) {
			if ( $this->hasSingleDiv( $currentNode ) ) {
				// special case: if single div, ignore it but get all the contents.
				// tables cells often contain div wrapper
				$this->iterate( $currentNode->childNodes->item(0)->childNodes );
			} else {
				$this->iterate( $currentNode->childNodes );
			}
		}
	}

	protected function hasSingleDiv( DOMNode $currentNode ) {
		return DomHelper::isElement( $currentNode, 'td' )
			&& $currentNode->childNodes->length == 1
			&& DomHelper::isElement( $currentNode->childNodes->item(0), 'div' );
	}
}
