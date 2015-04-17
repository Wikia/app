<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\Parser;

class NodeComparison extends  Node {

	public function getData() {
		$data = [];
		$data['value'] = [];
		$nodeFactory = new Parser( $this->infoboxData );
		foreach ( $this->xmlNode as $set ) {
			$data['value'][] = $nodeFactory->getDataFromNodes( $set );
		}
		return $data;
	}

}
