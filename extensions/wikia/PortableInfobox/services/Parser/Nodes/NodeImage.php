<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use HtmlHelper;
use Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag;
use WikiaFileHelper;

class NodeImage extends Node {
	const GALLERY = 'GALLERY';
	const TABBER = 'TABBER';

	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';
	const MEDIA_TYPE_VIDEO = 'VIDEO';

	public static function getMarkers( $value, $ext ) {
		if ( preg_match_all('/\x7f\'"`UNIQ[A-Z0-9]*-' . $ext . '-[A-F0-9]{8}-QINU`"\'\x7f/is', $value, $out ) ) {
			return $out[0];
		} else {
			return [];
		}
	}

	public static function getGalleryData( $marker ) {
		$galleryData = PortableInfoboxDataBag::getInstance()->getGallery( $marker );
		return isset( $galleryData['images'] ) ? array_map( function ( $image ) {
			return [
				'label' => $image['caption'],
				'title' => $image['name']
			];
		}, $galleryData['images'] ) : [ ];
	}

	public static function getTabberData( $html ) {
		global $wgArticleAsJson;
		$data = array();
		$doc = HtmlHelper::createDOMDocumentFromText( $html );
		$sxml = simplexml_import_dom( $doc );
		$divs = $sxml->xpath( '//div[@class=\'tabbertab\']' );
		foreach ( $divs as $div ) {
			if ( $wgArticleAsJson ) {
				if ( preg_match( '/data-ref="([^"]+)"/', $div->asXML(), $out ) ) {
					$data[] = array( 'label' => (string) $div['title'], 'title' => \ArticleAsJson::$media[$out[1]]['title'] );
				}
			} else {
				if ( preg_match( '/data-(video|image)-key="([^"]+)"/', $div->asXML(), $out ) ) {
					$data[] = array( 'label' => (string) $div['title'], 'title' => $out[2] );
				}
			}
		}
		return $data;
	}

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = array();

			// value passed to source parameter (or default)
			$value = $this->getRawValueWithDefault( $this->xmlNode );

			if ( $this->containsTabberOrGallery( $value ) ) {
				$this->data = $this->getImagesData( $value );
			} else {
				$this->data = array( $this->getImageData(
					$value,
					$this->getValueWithDefault( $this->xmlNode->{self::ALT_TAG_NAME} ),
					$this->getValueWithDefault( $this->xmlNode->{self::CAPTION_TAG_NAME} )
				) );
			}
		}
		return $this->data;
	}

	/**
	 * @desc Checks if parser preprocessed string containg Tabber or Gallery extension
	 * @param string $str String to check
	 * @return bool
	 */
	private function containsTabberOrGallery( $str ) {
		return !empty( self::getMarkers( $str, self::TABBER ) ) || !empty( self::getMarkers( $str, self::GALLERY ) );
	}

	private function getImagesData( $value ) {
		$data = array();
		$items = array_merge( $this->getGalleryItems( $value ), $this->getTabberItems( $value ) );
		foreach( $items as $item ) {
			$data[] = $this->getImageData( $item['title'], $item['label'], $item['label'] );
		}
		return $data;
	}

	private function getGalleryItems( $value ) {
		$galleryItems = [];
		$galleryMarkers = self::getMarkers( $value, self::GALLERY );
		foreach ( $galleryMarkers as $marker ) {
			$galleryItems = array_merge( $galleryItems, self::getGalleryData( $marker ) );

		}
		return $galleryItems;
	}

	private function getTabberItems( $value ) {
		$tabberItems = array();
		$tabberMarkers = self::getMarkers( $value, self::TABBER );
		foreach ( $tabberMarkers as $marker ) {
			$tabberHtml = $this->getExternalParser()->parseRecursive( $marker );
			$tabberItems = array_merge( $tabberItems, self::getTabberData( $tabberHtml ) );
		}
		return $tabberItems;
	}

	/**
	 * @desc prepare infobox image node data.
	 *
	 * @param $title
	 * @param $alt
	 * @param $caption
	 * @return array
	 */
	private function getImageData( $title, $alt, $caption ) {
		$titleObj = $this->getImageAsTitleObject( $title );
		$fileObj = $this->getFilefromTitle( $titleObj );

		if ( $titleObj instanceof \Title ) {
			$this->getExternalParser()->addImage( $titleObj->getDBkey() );
		}

		$image = [
			'url' => $this->resolveImageUrl( $fileObj ),
			'name' => $titleObj ? $titleObj->getText() : '',
			'key' => $titleObj ? $titleObj->getDBKey() : '',
			'alt' => $alt,
			'caption' => \SanitizerBuilder::createFromType( 'image' )
				->sanitize( [ 'caption' => $caption ] )['caption'],
			'isVideo' => false
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

	public function getSources() {
		$sources = $this->extractSourcesFromNode( $this->xmlNode );
		if ( $this->xmlNode->{self::ALT_TAG_NAME} ) {
			$sources = array_merge( $sources,
				$this->extractSourcesFromNode( $this->xmlNode->{self::ALT_TAG_NAME} ) );
		}
		if ( $this->xmlNode->{self::CAPTION_TAG_NAME} ) {
			$sources = array_merge( $sources,
				$this->extractSourcesFromNode( $this->xmlNode->{self::CAPTION_TAG_NAME} ) );
		}

		return array_unique( $sources );
	}

	private function getImageAsTitleObject( $imageName ) {
		global $wgContLang;
		$title = \Title::makeTitleSafe(
			NS_FILE,
			\FileNamespaceSanitizeHelper::getInstance()->sanitizeImageFileName( $imageName, $wgContLang )
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
