<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeData extends Node {

	public function ignoreNodeWhenEmpty() {
		$parent = $this->getParent();
		if ( $parent instanceof NodeSet ) {
			if ( $parent->getParent() instanceof NodeComparison ) {
				// data tag inside comparison tag can not be ignored
				return false;
			}
		}
		return true;
	}

	public function getData() {
		return [
			'label' => $this->getExternalParser()->parseRecursive(
				\Wikia\PortableInfobox\Helpers\SimpleXmlUtil::getInstance()->getInnerXML(
					$this->xmlNode->{self::LABEL_TAG_NAME}
				)
			),
			'value' => $this->getValueWithDefault( $this->xmlNode )
		];
	}
}
