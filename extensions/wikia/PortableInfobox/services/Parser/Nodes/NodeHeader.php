<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeHeader extends Node {
	public function getData() {
		return [ 'value' => $this->parseWithExternalParser( (string) $this->xmlNode, true ) ];
	}

}
