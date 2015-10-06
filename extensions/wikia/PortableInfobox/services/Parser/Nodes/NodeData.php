<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeData extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'label' => $this->getInnerValue( $this->xmlNode->{self::LABEL_TAG_NAME} ),
				'value' => $this->getValueWithDefault( $this->xmlNode )
			];
		}

		return $this->data;
	}
}
