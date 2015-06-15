<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeGroup extends Node {
	const DATA_LAYOUT_ATTR_NAME = 'layout';
	const DEFAULT_TAG_NAME = 'default';

	private $supportedGroupLayouts = [
		'default',
		'horizontal'
	];

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [ 'value' => $this->getDataForChildren(),
							'layout' => $this->getXmlAttributeFromSupported( $this->xmlNode,
								self::DATA_LAYOUT_ATTR_NAME, $this->supportedGroupLayouts) ];
		}

		return $this->data;
	}

	public function getRenderData() {
		return [
			'type' => $this->getType(),
			'data' => [ 'value' => $this->getRenderDataForChildren(), 
						'layout' => $this->getXmlAttributeFromSupported( $this->xmlNode, 
							self::DATA_LAYOUT_ATTR_NAME, $this->supportedGroupLayouts) ],
		];
	}

	public function isEmpty() {
		/** @var Node $item */
		foreach ( $this->getChildNodes() as $item ) {
			if ( !$item->isType( 'header' ) && !$item->isEmpty() ) {
				return false;
			}
		}

		return true;
	}

	public function getSource() {
		return $this->getSourceForChildren();
	}
}
