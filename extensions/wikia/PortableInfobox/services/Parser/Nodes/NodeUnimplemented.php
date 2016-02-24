<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeUnimplemented extends Node {

	public function getData() {
		throw new UnimplementedNodeException( $this->getType() );
	}
}

class UnimplementedNodeException extends \Exception {
}