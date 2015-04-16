<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodePair extends Node {

	public function getData() {
		$data = [];
		$data['label'] = (string) $this->xmlNode->{self::LABEL_TAG_NAME};
		$data['value'] = $this->getValueWithDefault( $this->xmlNode );
		return $data;
	}
}
