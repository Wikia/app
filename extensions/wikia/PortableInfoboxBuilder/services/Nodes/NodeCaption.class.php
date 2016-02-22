<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeCaption extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' ];

	public function asJson() {
		return [ 'caption' => [ 'source' => (string)$this->xmlNode->attributes()['source'] ] ];
	}
}
