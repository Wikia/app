<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

use HtmlHelper;
use WikiaFileHelper;

class NodeImage extends Node {
	const ALT_TAG_NAME = 'alt';
	const CAPTION_TAG_NAME = 'caption';
	const MEDIA_TYPE_VIDEO = 'VIDEO';

	public static function getMarkers( $value, $ext ) {
		if ( preg_match_all('/\x7fUNIQ[A-Z0-9]*-' . $ext . '-[A-F0-9]{8}-QINU\x7f/is', $value, $out ) ) {
			return $out[0];
		} else {
			return [];
		}
	}

	public static function getGalleryData( $html ) {
		global $wgArticleAsJson;
		$data = array();
		if ( $wgArticleAsJson ) {
			if ( preg_match( '/data-ref=\'([^\']+)\'/', $html, $out ) ) {
				$media = \ArticleAsJson::$media[$out[1]];
				for( $i = 0; $i < count( $media ); $i++ ) {
					$data[] = array( 'label' => strip_tags( $media[$i]['caption'] ), 'title' => $media[$i]['title'] );
				}
			}
		} else {
			if ( preg_match( '#\sdata-model="([^"]+)"#', $html, $galleryOut ) ) {
				$model = json_decode( htmlspecialchars_decode( $galleryOut[1] ), true );
				for( $i = 0; $i < count( $model ); $i++ ) {
					$data[] = array( 'label' => strip_tags( $model[$i][ 'caption' ] ), 'title' => $model[$i][ 'title' ] );
				}
			}
			if ( preg_match_all('#data-(video|image)-key="([^"]+)".*?\s<h2>(.*?)<\/h2>#is', $html, $galleryOut ) ) {
				for( $i = 0; $i < count( $galleryOut[0] ); $i++ ) {
					$data[] = array( 'label' => $galleryOut[3][$i], 'title' => $galleryOut[2][$i] );
				}
			}
			if ( preg_match_all('#data-(video|image)-key="([^"]+)".*?<div class="lightbox-caption"[^>]*>(.*?)<\/div>#is', $html, $galleryOut ) ) {
				for( $i = 0; $i < count( $galleryOut[0] ); $i++ ) {
					$data[] = array( 'label' => $galleryOut[3][$i], 'title' => $galleryOut[2][$i] );
				}
			}
		}
		return $data;
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
		// TODO: Consider more robust approach (UNIQ...QINU)
		$strLower = strtolower( $str );
		if ( strpos( $strLower, '-tabber-' ) !== false || strpos( $strLower, '-gallery-' ) !== false ) {
			return true;
		}
		return false;
	}

	private function getImagesData( $value ) {
		$data = array();
		$items = array_merge( $this->getGalleryItems( $value ), $this->getTabberItems( $value ) );
		for( $i = 0; $i < count( $items ); $i++ ) {
			$data[] = $this->getImageData( $items[$i]['title'], $items[$i]['label'], $items[$i]['label'] );
		}
		return $data;
	}

	private function getGalleryItems( $value ) {
		$galleryItems = array();
		$galleryMarkers = self::getMarkers( $value, 'GALLERY' );
		for ( $i = 0; $i < count ( $galleryMarkers ); $i++ ) {
			$galleryHtml = $this->getExternalParser()->parseRecursive( $galleryMarkers[$i] );
			$galleryItems = array_merge( $galleryItems, self::getGalleryData( $galleryHtml ) );
		}
		return $galleryItems;
	}

	private function getTabberItems( $value ) {
		$tabberItems = array();
		$tabberMarkers = self::getMarkers( $value, 'TABBER' );
		for ( $i = 0; $i < count ( $tabberMarkers ); $i++ ) {
			$tabberHtml = $this->getExternalParser()->parseRecursive( $tabberMarkers[$i] );
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
			'caption' => $caption,
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
