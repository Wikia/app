<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;
use Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag;
use WikiaFileHelper;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';
	const MEDIA_TYPE_VIDEO = 'VIDEO';

	public function getData() {
		if ( !isset( $this->data ) ) {
			$imageData = $this->getRawValueWithDefault( $this->xmlNode );

			if( is_string($imageData) && PortableInfoboxDataBag::getInstance()->getGallery($imageData)) {
				$imageData = PortableInfoboxDataBag::getInstance()->getGallery($imageData);
			}

			$title = $this->getImageAsTitleObject( $imageData );
			$file = $this->getFilefromTitle( $title );
			$this->getExternalParser()->addImage( $title ? $title->getDBkey() : $imageData );
			$ref = null;
			$alt = $this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} );
			$caption = $this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} );

			wfRunHooks( 'PortableInfoboxNodeImage::getData', [ $title, &$ref, $alt ] );

			$this->data = [
				'url' => $this->resolveImageUrl( $file ),
				'name' => ( $title ) ? $title->getText() : '',
				'key' => ( $title ) ? $title->getDBKey() : '',
				'alt' => $alt,
				'caption' => $caption,
				'ref' => $ref
			];

			if ( $this->isVideo( $file ) ) {
				$this->data = $this->videoDataDecorator( $this->data, $file );
			}
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
	 * @desc get file object from title object
	 * @param Title|null $title
	 * @return File|null
	 */
	private function getFilefromTitle( $title ) {
		return $title ? WikiaFileHelper::getFileFromTitle( $title ) : null;
	}

	/**
	 * @desc returns image url for given image title
	 * @param File|null $file
	 * @return string url or '' if image doesn't exist
	 */
	public function resolveImageUrl( $file ) {
		return $file ? $file->getUrl() : '';
	}

	/**
	 * @desc checks if file media type is VIDEO
	 * @param File|null $file
	 * @return bool
	 */
	private function isVideo( $file ) {
		return $file ? $file->getMediaType() === self::MEDIA_TYPE_VIDEO : false;
	}

	/**
	 * @desc add addtional data required for video media type
	 * @param array $data
	 * @param File $file
	 * @return array
	 */
	private function videoDataDecorator( $data, $file ) {
		$data['isVideo'] = true;
		$data['duration'] = WikiaFileHelper::formatDuration( $file->getMetadataDuration());

		return $data;
	}
}
