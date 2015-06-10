<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeGroup extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$nodeFactory = new XmlParser( $this->infoboxData );
			if ( $this->externalParser ) {
				$nodeFactory->setExternalParser( $this->externalParser );
			}
			$this->data = [ 'value' => $nodeFactory->getDataFromNodes( $this->xmlNode, $this ) ];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		foreach ( $data[ 'value' ] as $elem ) {
			if ( $elem[ 'type' ] != 'header' && !( $elem[ 'isEmpty' ] ) ) {
				return false;
			}
		}

		return true;
	}
}
