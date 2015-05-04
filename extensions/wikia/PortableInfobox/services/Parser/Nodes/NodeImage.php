<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		$node = [];

		$imageName = $this->getValueWithDefault( $this->xmlNode );
		$node['value'] = $this->resolveImageUrl( $imageName );
		$node['alt'] = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );

		return $node;
	}

	public function resolveImageUrl( $filename ) {
		$title = \Title::newFromText( \Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer::getInstance()
			->sanitizeImageFileName($filename), NS_FILE );
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle( $title )->getUrlGenerator()->url();
		} else {
			return "";
		}
	}
}
