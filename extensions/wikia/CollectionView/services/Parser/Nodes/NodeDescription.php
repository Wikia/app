<?php
namespace Wikia\CollectionView\Parser\Nodes;

class NodeDescription extends Node {
	public function getData() {
		return [ 'value' => $this->parseWithExternalParser( (string) $this->xmlNode, false ) ];
	}
}
