<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeDefault extends Node {
	public function asJsonObject() {
		$object = new \StdClass();
		$object->defaultValue = (string)$this->xmlNode;
		return $object;
	}

	public function hasValidContent() {
		if( strcmp(trim((string)$this->xmlNode), '{{PAGENAME}}') != 0) {
			return false;
		}
		return true;
	}
}
