<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeLabel extends Node {
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
		return [ 'label' => (string)$this->xmlNode ];
	}
}
