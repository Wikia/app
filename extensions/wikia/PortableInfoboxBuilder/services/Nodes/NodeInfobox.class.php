<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeInfobox extends Node {
	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'data', 'image', 'title' ];

	/**
	 * Parent node explicitly does NOT provide type
	 * @return null
	 */
	public function getType() {
		return null;
	}
}
