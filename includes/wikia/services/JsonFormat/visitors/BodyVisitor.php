<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:40
 */

class BodyVisitor extends DOMNodeVisitorBase {
	/**
	 * @param IDOMNodeVisitor $childrenVisitor
	 * @param JsonFormatTraversingState $jsonFormatTraversingState
	 */
	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatTraversingState $jsonFormatTraversingState ) {
		parent::__construct( $childrenVisitor, $jsonFormatTraversingState );
	}

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		return $this->isElement( $currentNode, 'body' );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		$this->getJsonFormatTraversingState()
			->pushNode( new JsonFormatRootNode() );
		$this->iterate( $currentNode->childNodes );
	}
}
