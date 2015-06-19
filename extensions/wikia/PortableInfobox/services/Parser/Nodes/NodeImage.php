<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;
use Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';

	public function getData() {
		if ( !isset( $this->data ) ) {
			$imageData = $this->getRawValueWithDefault( $this->xmlNode );

			if( is_string($imageData) && PortableInfoboxDataBag::getInstance()->getGallery($imageData)) {
				$imageData = PortableInfoboxDataBag::getInstance()->getGallery($imageData);
			}

			$title = $this->getImageAsTitleObject( $imageData );
			$this->getExternalParser()->addImage( $title ? $title->getDBkey() : $imageData );
			$ref = null;
			$alt = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );
			$caption = $this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} );

			wfRunHooks( 'PortableInfoboxNodeImage::getData', [ $title, &$ref, $alt ] );

			$this->data = [
				'url' => $this->resolveImageUrl( $title ),
				'name' => ( $title ) ? $title->getText() : '',
				'key' => ( $title ) ? $title->getDBKey() : '',
				'alt' => $alt,
				'caption' => $caption,
				'ref' => $ref
			];
		}

		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();

		return empty( $data[ 'url' ] );
	}

	public function getSource() {
		$sources = $this->extractSourceFromNode( $this->xmlNode );
		if ( $this->xmlNode->{self::ALT_TAG_NAME} ) {
			$sources = array_merge( $sources,
				$this->extractSourceFromNode( $this->xmlNode->{self::ALT_TAG_NAME} ) );
		}
		if ( $this->xmlNode->{self::CAPTION_TAG_NAME} ) {
			$sources = array_merge( $sources,
				$this->extractSourceFromNode( $this->xmlNode->{self::CAPTION_TAG_NAME} ) );
		}

		return array_unique( $sources );
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
	 *
	 * @param string $title
	 *
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
