<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeComparison extends Node {

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
		foreach ( $data[ 'value' ] as $group ) {
			if ( $group[ 'isEmpty' ] == false ) {
				return false;
			}
		}

		return true;
	}
}
