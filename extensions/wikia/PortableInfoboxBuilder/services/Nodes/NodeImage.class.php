<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeImage extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' => [ ] ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'caption' ];

	/**
	 * At the moment caption is the only supported child node and there can be only one of such
	 */
	public function getChildrenAsJsonObjects() {
		$data = null;

		if ( $this->xmlNode->caption ) {
			$builderNode = NodeBuilder::createFromNode( $this->xmlNode->caption );
			$data = $builderNode->asJsonObject();
		}
		return $data;
	}
}
