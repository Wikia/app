<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper;
use Wikia\PortableInfobox\Helpers\PortableInfoboxMustacheEngine;

class PortableInfoboxRenderService {
	// keep synced with scss variables ($infobox-width)
	const DEFAULT_DESKTOP_INFOBOX_WIDTH = 270;
	const DEFAULT_EUROPA_INFOBOX_WIDTH = 300;

	const DEFAULT_DESKTOP_THUMBNAIL_WIDTH = 350;
	const EUROPA_THUMBNAIL_WIDTH = 310;

	protected $templateEngine;
	protected $imagesWidth = self::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;
	protected $infoboxWidth = self::DEFAULT_DESKTOP_INFOBOX_WIDTH;
	protected $inlineStyles;

	private $helper;

	public function __construct() {
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
		if($this->isEuropaTheme()) {
			$this->imagesWidth = self::EUROPA_THUMBNAIL_WIDTH;
			$this->infoboxWidth = self::DEFAULT_EUROPA_INFOBOX_WIDTH;
		}

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
		$children = $groupData['value'];
		$layout = $groupData['layout'];
		$collapse = $groupData['collapse'];
		$rowItems = $groupData['row-items'];

		if ( $rowItems > 0 ) {
			$items = $this->createSmartGroups( $children, $rowItems );
			$groupHTMLContent .= $this->renderChildren( $items );
		} elseif ( $layout === 'horizontal' ) {
			$groupHTMLContent .= $this->renderItem(
				'horizontal-group-content',
				$this->createHorizontalGroupData( $children )
			);
		} else {
			$groupHTMLContent .= $this->renderChildren( $children );
		}

		if ( $collapse !== null && count( $children ) > 0 && $children[0]['type'] === 'header' ) {
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

		$data = $this->filterImageData( $data );
		$images = [ ];

		foreach ( $data as $dataItem ) {
			$extendedItem = $dataItem;
			$extendedItem['context'] = null;
			$extendedItem = $helper->extendImageData( $extendedItem, $this->imagesWidth, $this->infoboxWidth );

			if ( !!$extendedItem ) {
				$images[] = $extendedItem;
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

	private function filterImageData( $data ) {
		$dataWithCaption = array_filter($data, function( $item ) {
			return !empty( $item['caption'] );
		});

		$result = [];

		if ( !empty( $dataWithCaption ) ) {
			$result = $dataWithCaption;
		} elseif ( !empty( $data ) ) {
			$result = [ $data[0] ];
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

	private function createSmartGroups( $groupData, $rowCapacity ) {
		$result = [ ];
		$rowSpan = 0;
		$rowItems = [ ];

		foreach ( $groupData as $item ) {
			$data = $item['data'];

			if ( $item['type'] === 'data' && ( !isset( $data['layout'] ) || $data['layout'] !== 'default' ) ) {

				if ( !empty( $rowItems ) && $rowSpan + $data['span'] > $rowCapacity ) {
					$result[] = $this->createSmartGroupItem( $rowItems, $rowSpan );
					$rowSpan = 0;
					$rowItems = [ ];
				}
				$rowSpan += $data['span'];
				$rowItems[] = $item;
			} else {
				// smart wrapping works only for data tags
				if ( !empty( $rowItems ) ) {
					$result[] = $this->createSmartGroupItem( $rowItems, $rowSpan );
					$rowSpan = 0;
					$rowItems = [ ];
				}
				$result[] = $item;
			}
		}
		if ( !empty( $rowItems ) ) {
			$result[] = $this->createSmartGroupItem( $rowItems, $rowSpan );
		}

		return $result;
	}

	private function createSmartGroupItem( $rowItems, $rowSpan ) {
		return [
			'type' => 'smart-group',
			'data' => $this->createSmartGroupSections( $rowItems, $rowSpan )
		];
	}

	private function createSmartGroupSections( $rowItems, $capacity ) {
		return array_reduce( $rowItems, function ( $result, $item ) use ( $capacity ) {
			$styles = "width: calc({$item['data']['span']} / $capacity * 100%);";

			$label = $item['data']['label'] ?? "";
			if ( !empty( $label ) ) {
				$result['renderLabels'] = true;
			}
			$result['labels'][] = [ 'value' => $label, 'inlineStyles' => $styles ];
			$result['values'][] = [ 'value' => $item['data']['value'], 'inlineStyles' => $styles ];

			return $result;
		}, [ 'labels' => [ ], 'values' => [ ], 'renderLabels' => false ] );
	}
}
