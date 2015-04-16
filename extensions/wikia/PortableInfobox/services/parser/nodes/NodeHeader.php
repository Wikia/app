<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeHeader extends Node {
	public function getData() {
		return (string) $this->xmlNode->{self::VALUE_TAG_NAME};
	}

}
