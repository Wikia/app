<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';

	public function getData() {
		$imageName = $this->getRawValueWithDefault( $this->xmlNode );
		$title = $this->getImageAsTitleObject( $imageName );
		$this->getExternalParser()->addImage( $imageName );
		$ref = null;
		$alt = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );
		$caption = $this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} );

		wfRunHooks( 'PortableInfoboxNodeImage::getData', [ $title, &$ref, $alt ] );

		return [
			'url' => $this->resolveImageUrl( $title ),
			'name' => ( $title ) ? $title->getText() : '',
			'key' => ( $title ) ? $title->getDBKey() : '',
			'alt' => $alt,
			'caption' => $caption,
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

	/**
	 * @desc returns image url for given image title
	 * @param string $title
	 * @return string url or '' if image doesn't exist
	 */
	public function resolveImageUrl( $title ) {
		if ( $title ) {
			$file = \WikiaFileHelper::getFileFromTitle( $title );
			if ( $file ) {
				return $file->getUrl();
			}
		}
		return '';
	}
}
