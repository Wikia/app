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
			$this->data = array();

			$parameterValue = $this->getRawValueWithDefault( $this->xmlNode );

			if ( $this->containsTabberOrGallery( $parameterValue ) ) {
				$parsed = $this->getExternalParser()->parseRecursive( $parameterValue );

				$items = array_merge( $this->getGalleryItems( $parsed ), $this->getTabberItems( $parsed ) );
				for( $i = 0; $i < count( $items ); $i++ ) {
					$this->data[] = $this->getImage(
						$items[$i]['title'],
						$items[$i]['caption'],
						$items[$i]['caption']
					);
				}
			} else {
				$this->data[] = $this->getImage(
					$parameterValue,
					$this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} ),
					$this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} )
				);
			}
		}

		return $this->data;
	}

	private function getGalleryItems( $html ) {
		$items = array();

		if ( preg_match( '#\sdata-model="([^"]+)"#', $html, $galleryOut ) ) {
			$model = json_decode( htmlspecialchars_decode( $galleryOut[1] ), true );
			$items = array_map( function( $modelItem ) {
				return array(
					'title' => $modelItem['title'],
					'caption' => $modelItem[ 'caption' ]
				);
			}, $model );
		}

		if ( preg_match_all('#data-image-key="([^"]+)".*?\s<h2>(.*?)<\/h2>#is', $html, $galleryOut ) ) {
			for( $i = 0; $i < count( $galleryOut[0] ); $i++ ) {
				$items[] = array(
					'title' => $galleryOut[1][$i],
					'caption' => $galleryOut[2][$i]
				);
			}
		}

		return $items;
	}

	private function getTabberItems( $html ) {
		$items = array();

		if ( preg_match_all('/class="tabbertab" title="([^"]+)".*?\sdata-image-key="([^"]+)"/is', $parsed, $tabberOut) ) {
			for( $i = 0; $i < count( $tabberOut[0] ); $i++ ) {
				$items[] = array(
					'title' => $tabberOut[2][$i],
					'caption' => $tabberOut[1][$i]
				);
			}
		}

		return $items;
	}

	/**
	 * @desc Checks if parser preprocessed string containg Tabber or Gallery extension
	 * @param string $str String to check
	 * @return bool
	 */
	private function containsTabberOrGallery( $str ) {
		// TODO: Consider more robust approach (UNIQ...QINU)
		$strLower = strtolower( $str );
		if ( strpos( $strLower, '-tabber-' ) !== false || strpos( $strLower, '-gallery-' ) !== false ) {
			return true;
		}
		return false;
	}

	private function getImage( $parameterValue, $alt, $caption ) {
		$titleObj = $this->getImageAsTitleObject( $parameterValue );
		$fileObj = $this->getFilefromTitle( $titleObj );

		if ( $titleObj instanceof \Title ) {
			$this->getExternalParser()->addImage( $titleObj->getDBkey() );
		}

		$image = [
			'url' => $this->resolveImageUrl( $fileObj ),
			'name' => $titleObj ? $titleObj->getText() : '',
			'key' => $titleObj ? $titleObj->getDBKey() : '',
			'alt' => $alt,
			'caption' => $caption
		];

		if ( $this->isVideo( $fileObj ) ) {
			$image = $this->videoDataDecorator( $image, $fileObj );
		}

		return $image;
	}

	public function isEmpty() {
		$data = $this->getData();
		foreach ( $data as $dataItem ) {
			if ( !empty( $dataItem[ 'url' ] ) ) {
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
