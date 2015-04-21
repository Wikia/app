<?php
namespace Wikia\CollectionView\Parser\Nodes;

use Wikia\CollectionView\Parser\XmlParser;

class NodeComparison extends  Node {

	public function getData() {
		$data = [];
		$data['value'] = [];
		$nodeFactory = new XmlParser( $this->collectionViewData );
		foreach ( $this->xmlNode as $set ) {
			$data['value'][] = $nodeFactory->getDataFromNodes( $set );
		}
		return $data;
	}

	public function isEmpty( $data ) {
		return !is_array( $data[ 'value' ] ) || !count( $data[ 'value' ] );
	}


}
