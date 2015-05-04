<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeFooter extends Node {

	public function getData() {
		$data = [];
		$data['value'] = $this->parseWithExternalParser( (string) $this->xmlNode, true );
		return $data;
	}

	public function isEmpty( $data ) {
		$links = trim( $data['value'] );
		return empty( $links );
	}
}
