<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxMustacheEngine;
use Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper;

class PortableInfoboxRenderService extends WikiaService {
	const DEFAULT_DESKTOP_THUMBNAIL_WIDTH = 350;
	const EUROPA_THUMBNAIL_WIDTH = 310;

	protected $templateEngine;
	protected $imagesWidth = self::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;
	protected $inlineStyles;

	private $helper;

	function __construct() {
		parent::__construct();
		$this->templateEngine = new PortableInfoboxMustacheEngine();
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 *
	 * @param $theme
	 * @param $layout
	 * @param $accentColor
	 * @param $accentColorText
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata, $theme, $layout, $accentColor, $accentColorText ) {
		$this->inlineStyles = $this->getInlineStyles( $accentColor, $accentColorText );

		// decide on image width, if europa go with bigger images! else default size
		$this->imagesWidth = $this->isEuropaTheme() ? self::EUROPA_THUMBNAIL_WIDTH :
			self::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;

		$infoboxHtmlContent = $this->renderChildren( $infoboxdata );

		if ( !empty( $infoboxHtmlContent ) ) {
			$output = $this->renderItem( 'wrapper', [
				'content' => $infoboxHtmlContent,
				'theme' => $theme,
				'layout' => $layout,
				'isEuropaEnabled' => $this->isEuropaTheme()
			] );
		} else {
			$output = '';
		}

		return $output;
	}

	protected function getImageHelper() {
		if ( !isset( $this->helper ) ) {
			$this->helper = new PortableInfoboxImagesHelper();
		}
		return $this->helper;
	}

	/**
	 * Produces HTML output for item type and data
	 *
	 * @param $type
	 * @param array $data
	 * @return string
	 */
	protected function render( $type, array $data ) {
		return $this->templateEngine->render( $type, $data );
	}

	/**
	 * renders part of infobox
	 *
	 * @param string $type
	 * @param array $data
	 *
	 * @return string - HTML
	 */
	protected function renderItem( $type, array $data ) {
		switch ( $type ) {
			case 'group':
				$result = $this->renderGroup( $data );
				break;
			case 'header':
				$result = $this->renderHeader( $data );
				break;
			case 'image':
				$result = $this->renderImage( $data );
				break;
			case 'title':
				$result = $this->renderTitle( $data );
				break;
			default:
				$result = $this->render( $type, $data );
				break;
		}

		return $result;
	}

	/**
	 * renders group infobox component
	 *
	 * @param array $groupData
	 *
	 * @return string - group HTML markup
	 */
	protected function renderGroup( $groupData ) {
		$cssClasses = [ ];
		$groupHTMLContent = '';
		$dataItems = $groupData['value'];
		$layout = $groupData['layout'];
		$collapse = $groupData['collapse'];

		if ( $layout === 'horizontal' ) {
			$groupHTMLContent .= $this->renderItem(
				'horizontal-group-content',
				$this->createHorizontalGroupData( $dataItems )
			);
		} else {
			$groupHTMLContent .= $this->renderChildren( $dataItems );
		}

		if ( $collapse !== null && count( $dataItems ) > 0 && $dataItems[0]['type'] === 'header' ) {
			$cssClasses[] = 'pi-collapse';
			$cssClasses[] = 'pi-collapse-' . $collapse;
		}

		return $this->render( 'group', [
			'content' => $groupHTMLContent,
			'cssClasses' => implode( ' ', $cssClasses )
		] );
	}

	/**
	 * If image element has invalid thumbnail, doesn't render this element at all.
	 *
	 * @param $data
	 * @return string
	 */
	protected function renderImage( $data ) {
		$helper = $this->getImageHelper();
		$images = [ ];

		for ( $i = 0; $i < count( $data ); $i++ ) {
			$data[$i]['context'] = null;
			$data[$i] = $helper->extendImageData( $data[$i], $this->imagesWidth );

			if ( !!$data[$i] ) {
				$images[] = $data[$i];
			}
		}

		if ( count( $images ) === 0 ) {
			return '';
		}

		if ( count( $images ) === 1 ) {
			$data = $images[0];
			$templateName = 'image';
		} else {
			// More than one image means image collection
			$data = $helper->extendImageCollectionData( $images );
			$templateName = 'image-collection';
		}

		return $this->render( $templateName, $data );
	}

	protected function renderTitle( $data ) {
		$data['inlineStyles'] = $this->inlineStyles;

		return $this->render( 'title', $data );
	}

	protected function renderHeader( $data ) {
		$data['inlineStyles'] = $this->inlineStyles;

		return $this->render( 'header', $data );
	}

	protected function renderChildren( $children ) {
		$result = '';
		foreach ( $children as $child ) {
			$type = $child['type'];
			if ( $this->templateEngine->isSupportedType( $type ) ) {
				$result .= $this->renderItem( $type, $child['data'] );
			}
		}

		return $result;
	}

	private function getInlineStyles( $accentColor, $accentColorText ) {
		$backgroundColor = empty( $accentColor ) ? '' : "background-color:{$accentColor};";
		$color = empty( $accentColorText ) ? '' : "color:{$accentColorText};";

		return "{$backgroundColor}{$color}";
	}

	private function createHorizontalGroupData( $groupData ) {
		$horizontalGroupData = [
			'labels' => [ ],
			'values' => [ ],
			'renderLabels' => false
		];

		foreach ( $groupData as $item ) {
			$data = $item['data'];

			if ( $item['type'] === 'data' ) {
				array_push( $horizontalGroupData['labels'], $data['label'] );
				array_push( $horizontalGroupData['values'], $data['value'] );

				if ( !empty( $data['label'] ) ) {
					$horizontalGroupData['renderLabels'] = true;
				}
			} elseif ( $item['type'] === 'header' ) {
				$horizontalGroupData['header'] = $data['value'];
			}
		}

		return $horizontalGroupData;
	}

	private function isEuropaTheme() {
		global $wgEnablePortableInfoboxEuropaTheme;

		return !empty( $wgEnablePortableInfoboxEuropaTheme );
	}
}
