<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeTitle extends  Node {
	public function getData() {
		return $this->getValueWithDefault( $this->xmlNode );
	}
}
