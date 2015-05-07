<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		return [
			'url' => $this->resolveImageUrl( $imageName ),
			'name' => $this->getValueWithDefault( $this->xmlNode ),
			'alt' => $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} )
		];
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'url' ] ) ) || empty( $data[ 'url' ] );
	}

	public function resolveImageUrl( $filename ) {
		global $wgContLang;
		$title = \Title::newFromText(
			ImageFilenameSanitizer::getInstance()->sanitizeImageFileName( $filename, $wgContLang ),
			NS_FILE
		);
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle( $title )->getUrlGenerator()->url();
		} else {
			return "";
		}
	}
}
