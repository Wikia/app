<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeInfobox extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ ];

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
