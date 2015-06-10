<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\SimpleXmlUtil;

class NodeData extends Node {

//	public function ignoreNodeWhenEmpty() {
//		$parent = $this->getParent();
//		if ( $parent instanceof NodeSet ) {
//			if ( $parent->getParent() instanceof NodeComparison ) {
//				// data tag inside comparison tag can not be ignored
//				return false;
//			}
//		}
//
//		return true;
//	}

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'label' => $this->getExternalParser()->parseRecursive(
					SimpleXmlUtil::getInstance()->getInnerXML(
						$this->xmlNode->{self::LABEL_TAG_NAME}
					)
				),
				'value' => $this->getValueWithDefault( $this->xmlNode )
			];
		}

		return $this->data;
	}
}
