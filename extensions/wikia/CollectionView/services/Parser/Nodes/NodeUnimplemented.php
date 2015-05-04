<?php
namespace Wikia\CollectionView\Parser\Nodes;

class NodeUnimplemented extends Node {
	public function getType() {
		return parent::getType() . '(unimplemented)';
	}

	public function getData() {
		throw new UnimplementedNodeException('Unimplemented node type');
	}
}

class UnimplementedNodeException extends \Exception {
}