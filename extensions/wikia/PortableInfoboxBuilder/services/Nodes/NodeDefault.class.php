<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeDefault extends Node {
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

	public function asJson() {
		return [ 'defaultValue' => (string)$this->xmlNode ];
	}
}
