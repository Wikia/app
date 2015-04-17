<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		$node = [];
		$imageName = $this->getInfoboxData( $this->getXmlAttribute($this->xmlNode, self::DATA_SRC_ATTR_NAME ) );
		$node['value'] = $this->resolveImageUrl( $imageName );
		$node['alt'] = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );
		return $node;
	}

	private function resolveImageUrl( $filename ) {
		$title = \Title::newFromText( $filename, NS_FILE );
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle($title)->getUrlGenerator()->url();
		}
		return "";
	}
}
