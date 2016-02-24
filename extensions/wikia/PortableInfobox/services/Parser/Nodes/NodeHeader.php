<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeHeader extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getInnerValue( $this->xmlNode ) ];
		}

		return $this->data;
	}
}
