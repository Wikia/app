<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeDefault extends Node {
	public function asJson() {
		return [ 'defaultValue' => (string)$this->xmlNode ];
	}
}
