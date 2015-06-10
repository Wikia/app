<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\SimpleXmlUtil;

class NodeFooter extends Node {

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getExternalParser()->parseRecursive(
				SimpleXmlUtil::getInstance()->getInnerXML( $this->xmlNode )
			) ];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		$links = trim( $data[ 'value' ] );

		return empty( $links ) && $links != '0';
	}
}
