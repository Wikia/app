<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeCaption extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' ];

	public function asJsonObject() {
		$object = new \StdClass();
		$object->caption = [ 'source' => (string)$this->xmlNode->attributes()['source'] ];
		return $object;
	}
}
