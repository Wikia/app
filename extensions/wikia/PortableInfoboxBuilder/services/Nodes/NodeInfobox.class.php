<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeInfobox extends Node {
	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'data', 'image', 'title', 'group' ];

	protected $allowedAttributes = [ 'theme' => [ '' ] ];

	/**
	 * Parent node explicitly does NOT provide type
	 * @return null
	 */
	protected function getType() {
		return null;
	}
}
