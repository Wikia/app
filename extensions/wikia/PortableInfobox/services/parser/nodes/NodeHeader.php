<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodePair extends Node {
	public function getData() {
		return $this->getValueWithDefault( $this->xmlNode );
	}

}