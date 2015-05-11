<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';

	public function getData() {
		$title = $this->getImageAsTitleObject( $this->getRawValueWithDefault( $this->xmlNode ) );
		$ref = null;
		$alt = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );


		wfRunHooks( 'PortableInfoboxNodeImage::getData', [ $title, &$ref, $alt ] );
		
		return [
			'url' => $this->resolveImageUrl( $title ),
			'name' => ( $title ) ? $title->getDBkey() : '',
			'alt' => $alt,
			'ref' => $ref
		];
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'url' ] ) ) || empty( $data[ 'url' ] );
	}

	private function getImageAsTitleObject( $imageName ) {
		global $wgContLang;
		$title = \Title::newFromText(
			ImageFilenameSanitizer::getInstance()->sanitizeImageFileName( $imageName, $wgContLang ),
			NS_FILE
		);
		return $title;
	}

	public function resolveImageUrl( $title ) {
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle( $title )->getUrlGenerator()->url();
		} else {
			return '';
		}
	}
}
