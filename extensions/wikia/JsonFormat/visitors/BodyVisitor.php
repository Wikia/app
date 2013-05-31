<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:40
 */

class BodyVisitor extends DOMNodeVisitorBase {
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
		return DomHelper::isElement( $currentNode, 'body' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		$this->getJsonFormatBuilder()
			->pushNode( new JsonFormatRootNode() );
		$this->iterate( $currentNode->childNodes );
	}
}
