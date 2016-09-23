<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeHeader extends Node {

	public function getType() {
		return 'section-header';
	}

	public function asJsonObject() {
		$object = new \StdClass();
		$object->data = (string)$this->xmlNode;
		$object->type = $this->getType();
		return $object;
	}
}
