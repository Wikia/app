<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		global $wgContLang;

		$title = \Title::newFromText(
			ImageFilenameSanitizer::getInstance()->sanitizeImageFileName(
				$this->getRawValueWithDefault( $this->xmlNode ),
				$wgContLang
			),
			NS_FILE
		);


		return [
			'url' => $this->resolveImageUrl( $title ),
			'name' => ( $title ) ? $title->getDBkey() : '',
			'alt' => $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} )
		];
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'url' ] ) ) || empty( $data[ 'url' ] );
	}

	public function resolveImageUrl( $title ) {
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle( $title )->getUrlGenerator()->url();
		} else {
			return "";
		}
	}
}
