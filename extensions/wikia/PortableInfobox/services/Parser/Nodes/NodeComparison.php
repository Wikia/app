<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeComparison extends  Node {

	const SINGLE_GROUP_TYPE_NAME = 'comparision_group';

	public function getData() {
		$data = [];
		$data['value'] = [];
		$nodeFactory = new XmlParser( $this->infoboxData );
		$nodeFactory->setExternalParser( $this->externalParser );
		foreach ( $this->xmlNode as $set ) {
			$value = $nodeFactory->getDataFromNodes( $set );
			$data['value'][] = [ 'type' => self::SINGLE_GROUP_TYPE_NAME,
								 'value'=> $value,
								 'isEmpty' => $this->isComparisionSetEmpty( $value )
			];

		}
		return $data;
	}

	protected function isComparisionSetEmpty( $data ) {
		foreach ( $data as $elem ) {
			if ( $elem['type'] != 'header' && $elem['isEmpty'] == false ) {
				return false;
			}
		}
		return true;
	}

	public function isEmpty( $data ) {
		foreach ( $data['value'] as $group ) {
			if ( $group['isEmpty'] == false ) {
				return false;
			}
		}
		return true;
	}


}
