<?php
namespace Wikia\PortableInfobox\Parser\Nodes;
use Wikia\PortableInfobox\Parser\Parser;

class NodeGroup extends Node {

	public function getData() {
		$nodeFactory = new Parser( $this->infoboxData );
		$data = $nodeFactory->getDataFromNodes( $this->xmlNode );
		return $data;
	}
}
