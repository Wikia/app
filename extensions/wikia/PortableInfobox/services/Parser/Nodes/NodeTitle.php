<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeTitle extends Node {
	public function getData() {
		if ( !isset( $this->data ) ) {
			$title = $this->getValueWithDefault( $this->xmlNode );
			$this->data = [ 'value' => $title ];
		}

		return $this->data;
	}
}
