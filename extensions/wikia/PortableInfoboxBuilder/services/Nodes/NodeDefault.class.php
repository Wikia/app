<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeDefault extends Node {
	public function asJson() {
		return [ 'defaultValue' => (string)$this->xmlNode ];
	}

	public function hasValidContent() {
		if( strcmp((string)$this->xmlNode, '{{PAGENAME}}') != 0) {
			return false;
		}
		return true;
	}
}
