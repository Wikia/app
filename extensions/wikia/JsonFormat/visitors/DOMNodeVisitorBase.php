<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:41
 */

abstract class DOMNodeVisitorBase implements IDOMNodeVisitor {
	/**
	 * @var JsonFormatBuilder
	 */
	private $jsonFormatBuilder;

	/**
	 * @var IDOMNodeVisitor
	 */
	private $childrenVisitor;

	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatBuilder $jsonFormatTraversingState) {
		$this->childrenVisitor = $childrenVisitor;
		$this->jsonFormatBuilder = $jsonFormatTraversingState;
	}

	/**
	 * @param $jsonFormatTraversingState
	 */
	public function setJsonFormatBuilder($jsonFormatTraversingState) {
		$this->jsonFormatBuilder = $jsonFormatTraversingState;
	}

	/**
	 * @return JsonFormatBuilder
	 */
	public function getJsonFormatBuilder() {
		return $this->jsonFormatBuilder;
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
