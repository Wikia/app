<?php
namespace Wikia\CollectionView\Parser\Nodes;
use Wikia\CollectionView\Parser\XmlParser;

class NodeGroup extends Node {

	public function getData() {
		$nodeFactory = new XmlParser( $this->collectionViewData );
		$data = [];
		$data['value'] = $nodeFactory->getDataFromNodes( $this->xmlNode );
		return $data;
	}

	public function isEmpty( $data ) {
		foreach ( $data['value'] as $elem ) {
			if ( $elem['type'] != 'header' && !($elem['isEmpty']) ) {
				return false;
			}
		}
		return true;
	}


}
