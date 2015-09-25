<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer;
use Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag;
use WikiaFileHelper;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';
	const MEDIA_TYPE_VIDEO = 'VIDEO';

	private function getImage($key, $caption, $alt) {
		$title = $this->getImageAsTitleObject( $key );
		$file = $this->getFilefromTitle( $title );
		if ( $title instanceof \Title ) {
			$this->getExternalParser()->addImage( $title->getDBkey() );
		}
		$ref = null;
		wfRunHooks( 'PortableInfoboxNodeImage::getData', [ $title, &$ref, $caption ] );
		$item = [
			'url' => $this->resolveImageUrl( $file ),
			'name' => ( $title ) ? $title->getText() : '',
			'key' => ( $title ) ? $title->getDBKey() : '',
			'alt' => $alt,
			'caption' => $caption,
			'ref' => $ref
		];
		if ( $this->isVideo( $file ) ) {
			$item = $this->videoDataDecorator( $item, $file );
		}
		return $item;
	}

	public function getData() {
		if ( !isset( $this->data ) ) {
			$imageData = $this->getRawValueWithDefault( $this->xmlNode );
			$imageDataLower = strtolower($imageData);

			if ( strpos( $imageDataLower, '-tabber-' ) !== false || strpos( $imageDataLower, '-gallery-' ) !== false ) {
				$parsed = $this->getExternalParser()->parseRecursive( $imageData );

				// TODO: Move to separated function + error handling
				$galleryImages = array();
				if ( preg_match('#\sdata-model="([^"]+)"#', $parsed, $galleryOut) ) {
					$galleryImages = array_map(function($gallery) {
						return array('key' => $gallery['dbKey'], 'caption' => $gallery['caption']);
					}, json_decode(htmlspecialchars_decode($galleryOut[1]), true));
				}

				// TODO: Move to separated function + error handling
				$tabberImages = array();
				if ( preg_match_all('/class="tabbertab" title="([^"]+)".*?\sdata-image-key="([^"]+)"/is', $parsed, $tabberOut) ) {
					for( $i = 0; $i < count( $tabberOut[0] ); $i++ ) {
						$tabberImages[] = array('key' => $tabberOut[2][$i], 'caption' => $tabberOut[1][$i]);
					}
				}
				$this->data = [];
				$images = $galleryImages + $tabberImages;
				for( $i = 0; $i < count( $images ); $i++ ) {
					$this->data[] = $this->getImage(
						$images[$i]['key'],
						$images[$i]['caption'],
						$images[$i]['caption']
					);
				}
			} else {
				$this->data = array( $this->getImage(
					$imageData,
					$this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} ),
					$this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} )
				) );
			}
		}
		return $this->data;
	}

	public function isEmpty() {
		$data = $this->getData();
		for($i = 0; $i < count($data); $i++) {
			if(!empty( $data[$i]['url'])) {
				return false;
			}
		}
		return true;
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
		$title = \Title::makeTitleSafe(
			NS_FILE,
			ImageFilenameSanitizer::getInstance()->sanitizeImageFileName( $imageName, $wgContLang )
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
		$title = $file->getTitle();

		if ( $title ) {
			$data[ 'url' ] = $title->getFullURL();
		}

		$data[ 'isVideo' ] = true;
		$data[ 'duration' ] = WikiaFileHelper::formatDuration( $file->getMetadataDuration());

		return $data;
	}
}
