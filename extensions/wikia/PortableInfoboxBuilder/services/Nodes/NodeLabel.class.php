<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeLabel extends Node {
	public function asJson() {
		return [ 'label' => (string)$this->xmlNode ];
	}
}
