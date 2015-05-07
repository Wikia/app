<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		return [
			'value' => $this->resolveImageUrl( $this->getValueWithDefault( $this->xmlNode ) ),
			'alt' => $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} )
		];
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
