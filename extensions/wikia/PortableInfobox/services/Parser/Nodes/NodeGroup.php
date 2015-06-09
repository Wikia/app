<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Parser\XmlParser;

class NodeGroup extends Node {
	const DATA_THEME_ATTR_NAME = 'theme';

	public function getData() {
		$nodeFactory = new XmlParser( $this->infoboxData );
		if ( $this->externalParser ) {
			$nodeFactory->setExternalParser( $this->externalParser );
		}
		$theme = $this->getXmlAttribute( $this->xmlNode, self::DATA_THEME_ATTR_NAME );
		$value = $nodeFactory->getDataFromNodes( $this->xmlNode, $this );
		//var_dump("theme: ", $theme);
		return [ 'value' =>  $value, 'theme' => $theme ];
	}

	public function isEmpty( $data ) {
		foreach ( $data[ 'value' ] as $elem ) {
			if ( $elem[ 'type' ] != 'header' && !( $elem[ 'isEmpty' ] ) ) {
				return false;
			}
		}
		return true;
	}
}
