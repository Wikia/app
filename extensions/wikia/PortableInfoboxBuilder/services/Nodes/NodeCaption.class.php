<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeCaption extends Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' => [] ];

	public function asJsonObject() {
		$object = new \stdClass();
		$caption = new \stdClass();
		$caption->source = (string)$this->xmlNode->attributes()['source'];
		$object->caption = $caption;

		return $object;
	}
}
