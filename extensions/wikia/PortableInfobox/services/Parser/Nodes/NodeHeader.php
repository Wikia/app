<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeHeader extends Node {

	public function getData() {
		return [ 'value' => $this->getExternalParser()->parseRecursive( (string)$this->xmlNode ) ];
	}
}
