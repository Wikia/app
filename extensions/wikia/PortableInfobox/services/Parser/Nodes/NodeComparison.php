<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeComparison extends Node {

	public function getData() {
		$nodeFactory = new XmlParser( $this->infoboxData );
		if ( $this->externalParser ) {
			$nodeFactory->setExternalParser( $this->externalParser );
		}
		return [ 'value' => $nodeFactory->getDataFromNodes( $this->xmlNode, $this ) ];
	}

	public function isEmpty( $data ) {
		foreach ( $data[ 'value' ] as $group ) {
			if ( $group[ 'isEmpty' ] == false ) {
				return false;
			}
		}
		return true;
	}
}
