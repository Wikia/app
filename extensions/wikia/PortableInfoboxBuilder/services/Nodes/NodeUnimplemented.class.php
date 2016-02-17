<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeUnimplemented extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ ];

	public function isValid() {
		return false;
	}
}
