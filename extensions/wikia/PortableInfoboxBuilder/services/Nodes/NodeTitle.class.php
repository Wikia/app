<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeTitle extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' => [ ] ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'default' ];

	/**
	 * At the moment default is the only supported child node and there can be only one of such
	 */
	public function getChildrenAsJsonObjects() {
		$data = null;

		if ( $this->xmlNode->default ) {
			$builderNode = NodeBuilder::createFromNode( $this->xmlNode->default );
			$data = $builderNode->asJsonObject();
		}
		return $data;
	}
}
