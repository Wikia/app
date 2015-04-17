<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeTitle extends  Node {
	public function getData() {
		return [ "value" => $this->getValueWithDefault( $this->xmlNode ) ];
	}
}
