<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeData extends Node {

	public function getData() {
		return [
			'label' => $this->getExternalParser()->parseRecursive( $this->getInnerXML( $this->xmlNode->{self::LABEL_TAG_NAME} ) ),
			'value' => $this->getValueWithDefault( $this->xmlNode )
		];
	}
}
