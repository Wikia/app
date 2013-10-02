<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 23:07
 */

class HeaderVisitor extends DOMNodeVisitorBase {
	/**
	 * @param IDOMNodeVisitor $childrenVisitor
	 * @param JsonFormatBuilder $jsonFormatTraversingState
	 */
	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatBuilder $jsonFormatTraversingState ) {
		parent::__construct( $childrenVisitor, $jsonFormatTraversingState );
	}

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		return DomHelper::isElement( $currentNode )
			&& in_array( $currentNode->tagName, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7'] );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		if( $this->verifyFirstChildHasClass( $currentNode, "mw-headline" ) ) {
			$text = $currentNode->childNodes->item(0)->textContent;
			$section = new JsonFormatSectionNode( intval($currentNode->tagName[1]), $text );
			$this->getJsonFormatBuilder()->pushSection($section);
		} else {
			$text = $currentNode->textContent;
			$this->getJsonFormatBuilder()->appendText( $text );
		}
	}

	private function verifyFirstChildHasClass( DOMElement $node, $className ) {
		if( $node->childNodes->length > 0 ) {
			$firstChild = $node->childNodes->item(0);
			if ( $firstChild->attributes ) {
				$firstChildClass = $firstChild->attributes->getNamedItem('class');
				if( $firstChildClass && $firstChildClass->nodeValue == $className ) {
					return true;
				}
			}
		}
		return false;
	}
}
