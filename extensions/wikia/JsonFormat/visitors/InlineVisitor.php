<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 15:09
 */

class InlineVisitor extends DOMNodeVisitorBase {
	private $tags;

	/**
	 * @param IDOMNodeVisitor $childrenVisitor
	 * @param JsonFormatBuilder $jsonFormatTraversingState
	 * @param array $tags
	 */
	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatBuilder $jsonFormatTraversingState, array $tags ) {
		parent::__construct( $childrenVisitor, $jsonFormatTraversingState );
		$this->tags = $tags;
	}

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */

		foreach ( $this->tags as $tagName ) {
			if ( DomHelper::isElement( $currentNode, $tagName ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		$this->iterate( $currentNode->childNodes );
	}
}
