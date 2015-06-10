<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeGroup extends Node {
	const DATA_LAYOUT_ATTR_NAME = 'layout';
	const GROUP_LAYOUT_PREFIX = 'group-layout-';
	const DEFAULT_LAYOUT_NAME = 'default';

	private $supportedGroupLayouts = [
		'default',
		'horizontal'
	];

	public function getData() {
		$nodeFactory = new XmlParser( $this->infoboxData );
		if ( $this->externalParser ) {
			$nodeFactory->setExternalParser( $this->externalParser );
		}

		$layout = $this->getGroupLayout();
		$value = $nodeFactory->getDataFromNodes( $this->xmlNode, $this );
		return [ 'value' =>  $value, 'layout' => $layout ];
	}

	public function isEmpty( $data ) {
		foreach ( $data[ 'value' ] as $elem ) {
			if ( $elem[ 'type' ] != 'header' && !( $elem[ 'isEmpty' ] ) ) {
				return false;
			}
		}
		return true;
	}

	private function getGroupLayout() {
		$layoutName = $this->getXmlAttribute( $this->xmlNode, self::DATA_LAYOUT_ATTR_NAME );
		if ( isset($layoutName) && in_array( $layoutName, $this->supportedGroupLayouts ) ) {
			return $layoutName;
		}
		return self::DEFAULT_LAYOUT_NAME;
	}
}
