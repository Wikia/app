<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeTitle extends Node {
	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getValueWithDefault( $this->xmlNode ) ];
		}

		return $this->data;
	}
}
