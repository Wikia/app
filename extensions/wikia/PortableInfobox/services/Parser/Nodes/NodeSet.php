<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeSet extends Node {

	public function getData() {
		$nodeFactory = new XmlParser( $this->infoboxData );
		if ( $this->externalParser ) {
			$nodeFactory->setExternalParser( $this->externalParser );
		}
		return [ 'value' => $nodeFactory->getDataFromNodes( $this->xmlNode ) ];
	}

	public function isEmpty( $data ) {
		foreach ( $data[ 'value' ] as $elem ) {
			if ( $elem[ 'type' ] != 'header' && !( $elem[ 'isEmpty' ] ) ) {
				return false;
			}
		}
		return true;
	}
}
