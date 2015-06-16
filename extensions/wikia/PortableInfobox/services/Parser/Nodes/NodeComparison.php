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
		foreach ( $data[ 'value' ] as $set ) {

			//only 'set' node can be a direct child of the comparison tag.
			if ($set['type'] !== 'set') {
				continue;
			}

			if ( $set[ 'isEmpty' ] == false ) {
				return false;
			}
		}
		return true;
	}
}
