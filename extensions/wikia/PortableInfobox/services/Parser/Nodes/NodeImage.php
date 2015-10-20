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

	private function getTabberMarkers( $value ) {
		if ( preg_match_all('/\x7fUNIQ[A-Z0-9]*-TABBER-[0-9]{8}-QINU\x7f/is', $value, $out) ) {
			return $out[0];
		} else {
			return [];
		}
	}

	private function getTabberHtml( $marker ) {
		return $this->getExternalParser()->parseRecursive( $marker );
	}

	private function getTabberItems( $html ) {
		global $wgArticleAsJson;

		$doc = new \DOMDocument();
		$doc->loadHTML($html);
		$sxml = simplexml_import_dom($doc);
		$divs = $sxml->xpath('//div[@class=\'tabbertab\']');

		$items = array();

		foreach ($divs as $div) {
			$tabTitle = (string) $div['title'];
			if ( $wgArticleAsJson ) {
				if ( preg_match( '/data-ref="([^"]+)"/', $div->p->asXML(), $out ) ) {
					$items[] = array( 'label' => $tabTitle, 'title' => \ArticleAsJson::$media[$out[1]]['title'] );
				}
			} else {
				if ( preg_match( '/data-image-key="([^"]+)"/', $div->p->asXML(), $out ) ) {
					$items[] = array( 'label' => $tabTitle, 'title' => $out[1] );
				}
			}
		}

		return $items;
	}

	private function getImagesData( $value ) {
		$tabberItems = array();
		$tabberMarkers = $this->getTabberMarkers( $value );
		for ( $i = 0; $i < count ( $tabberMarkers ); $i++ ) {
			$tabberHtml = $this->getTabberHtml( $tabberMarkers[$i] );
			$tabberItems = array_merge($tabberItems, $this->getTabberItems($tabberHtml));
		}
		$data = array();
		for( $i = 0; $i < count( $tabberItems ); $i++ ) {
			$data[] = $this->getImageData( $tabberItems[$i]['title'], $tabberItems[$i]['label'], $tabberItems[$i]['label'] );
		}
		return $data;
	}


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
