<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeUnimplemented extends Node {
	public function getType() {
		return parent::getType() . '(unimplemented)';
	}

	public function getData() {

	}
}
