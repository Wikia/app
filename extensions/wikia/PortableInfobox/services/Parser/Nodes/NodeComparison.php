<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeComparison extends  Node {

	public function getData() {
		$data = [];
		$data['value'] = [];
		$nodeFactory = new XmlParser( $this->infoboxData );
		foreach ( $this->xmlNode as $set ) {
			$data['value'][] = $nodeFactory->getDataFromNodes( $set );
		}
		return $data;
	}

	public function isEmpty( $data ) {
		return !is_array( $data[ 'value' ] ) || !count( $data[ 'value' ] );
	}


}
