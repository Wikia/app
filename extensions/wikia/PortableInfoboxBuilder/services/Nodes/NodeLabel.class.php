<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeLabel extends Node {
	public function asJson() {
		return [ 'label' => (string)$this->xmlNode ];
	}

	public function hasValidContent() {
		if (preg_match('/[\[\]{};\'"=|#*<>]+/', (string)$this->xmlNode)) {
			return false;
		}

		return true;
	}
}
