<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeData extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' => [] ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'label' ];

	/**
	 * Mapping for the builder UI: 'data' => 'row'
	 */
	public function getType() {
		return 'row';
	}

	/**
	 * At the moment label is the only supported child node and there can be only one of such
	 */
	public function getChildrenAsJsonObjects() {
		$data = null;

		if($this->xmlNode->label) {
			$builderNode = NodeBuilder::createFromNode( $this->xmlNode->label );
			$data = $builderNode->asJsonObject();
		}
		return $data;
	}
}
