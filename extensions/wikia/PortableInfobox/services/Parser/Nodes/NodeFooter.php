<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeFooter extends Node {

	public function getData() {
		return [ 'value' => $this->getExternalParser()->parseRecursive(
			\Wikia\PortableInfobox\Helpers\SimpleXmlUtil::getInstance()->getInnerXML( $this->xmlNode )
		) ];
	}

	public function isEmpty( $data ) {
		$links = trim( $data['value'] );
		return empty( $links ) && $links != '0';
	}
}
