<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:41
 */

abstract class DOMNodeVisitorBase implements IDOMNodeVisitor {
	/**
	 * @var JsonFormatTraversingState
	 */
	private $jsonFormatTraversingState;

	/**
	 * @var IDOMNodeVisitor
	 */
	private $childrenVisitor;

	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatTraversingState $jsonFormatTraversingState) {
		$this->childrenVisitor = $childrenVisitor;
		$this->jsonFormatTraversingState = $jsonFormatTraversingState;
	}

	/**
	 * @param $jsonFormatTraversingState
	 */
	public function setJsonFormatTraversingState($jsonFormatTraversingState) {
		$this->jsonFormatTraversingState = $jsonFormatTraversingState;
	}

	/**
	 * @return JsonFormatTraversingState
	 */
	public function getJsonFormatTraversingState() {
		return $this->jsonFormatTraversingState;
	}

	/**
	 * returns true if DOMNode is DOMElement with $tagName
	 * if $tagName is null (default) we don't check tagName.
	 * @param DOMNode $domNode
	 * @param string|null $tagName
	 * @return bool
	 */
	public function isElement( DOMNode $domNode, $tagName = null ) {
		if( $domNode instanceof DOMElement ) {
			if ( $tagName != null ) {
				return $domNode->tagName == $tagName;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param DOMNodeList $nodeList
	 */
	protected function iterate( DOMNodeList $nodeList ) {
		for( $i = 0; $i < $nodeList->length; $i++ ) {
			$node = $nodeList->item($i);
			$this->childrenVisitor->visit( $node );
		}
	}
}
