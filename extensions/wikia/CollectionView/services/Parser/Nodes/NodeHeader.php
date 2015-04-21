<?php
namespace Wikia\CollectionView\Parser\Nodes;

class NodeHeader extends Node {
	public function getData() {
		return [ 'value' => $this->parseWithExternalParser( (string) $this->xmlNode->{self::VALUE_TAG_NAME}, true ) ];
	}

}
