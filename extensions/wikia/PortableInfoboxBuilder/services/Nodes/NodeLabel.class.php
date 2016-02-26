<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeLabel extends Node {
	public function asJsonObject() {
		return [ 'label' => (string)$this->xmlNode ];
	}
}
