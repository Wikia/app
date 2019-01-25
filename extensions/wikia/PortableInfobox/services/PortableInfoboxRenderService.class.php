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
	public function renderInfobox( array $infoboxdata, $theme, $layout, $accentColor, $accentColorText, $type, $name ) {
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
				'isEuropaEnabled' => $this->isEuropaTheme(),
				'type' => $type,
				'name' => $name,
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
			case 'panel':
				$result = $this->renderPanel( $data );
				break;
			case 'section':
				// we support section only as direct child of panel, therefore there is no point in rendering
				// it in other context
				$result = '';
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
			$groupHTMLContent .= $this->renderHorizontalGroupContent( $children );
		} else {
			$groupHTMLContent .= $this->renderChildren( $children );
		}

		if ( $collapse !== null && count( $children ) > 0 && $children[0]['type'] === 'header' ) {
			$cssClasses[] = 'pi-collapse';
			$cssClasses[] = 'pi-collapse-' . $collapse;
		}

		return $this->render( 'group', [
			'content' => $groupHTMLContent,
			'cssClasses' => implode( ' ', $cssClasses ),
			'item-name' => $groupData['item-name']
		] );
	}

	protected function renderHorizontalGroupContent( $groupContent ) {
		return $this->renderItem(
			'horizontal-group-content',
			$this->createHorizontalGroupData( $groupContent )
		);
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
			$data['source'] = $data['images'][0]['source'];
			$data['item-name'] = $data['images'][0]['item-name'];
			$templateName = 'image-collection';
		}

		return $this->render( $templateName, $data );
	}

	protected function renderPanel( $data, $type='panel' ) {
		$cssClasses = [];
		$tabToggles = [];
		$tabContents = [];
		$collapse = $data['collapse'];
		$header = '';
		$shouldShowToggles = false;

		foreach ( $data['value'] as $index => $child ) {
			switch ( $child['type'] ) {
				case 'header':
					if ( empty( $header ) ) {
						$header = $this->renderHeader( $child['data'] );
					}
					break;
				case 'section':
					$sectionData = $this->getSectionData( $child, $index );

					// section needs to have content in order to render it
					if ( !empty( $sectionData['content'] ) ) {
						$tabToggles[] = $sectionData['toggle'];
						$tabContents[] = $sectionData['content'];

						if ( !empty( $sectionData['toggle']['value'] ) ) {
							$shouldShowToggles = true;
						}
					}
					break;
				default:
					// we do not support any other tags than section and header inside panel
					break;
			}
		}

		if ( $collapse !== null && count( $tabContents ) > 0 && !empty( $header ) ) {
			$cssClasses[] = 'pi-collapse';
			$cssClasses[] = 'pi-collapse-' . $collapse;
		}

		if ( count( $tabContents ) > 0 ) {
			$tabContents[0]['active'] = true;
			$tabToggles[0]['active'] = true;
		} else {
			// do not render empty panel
			return '';
		}

		if ( !$shouldShowToggles ) {
			$tabContents = array_map(function($content) {
				$content['active'] = true;
				return $content;
			}, $tabContents);
		}

		return $this->render( $type, [
			'item-name' => $data['item-name'],
			'cssClasses' => implode( ' ', $cssClasses ),
			'header' => $header,
			'tabToggles' => $tabToggles,
			'tabContents' => $tabContents,
			'shouldShowToggles' => $shouldShowToggles,
		]);
	}

	private function getSectionData( $section, $index ) {
		$content = '';
		$itemName = $section['data']['item-name'];
		$toggle = [
			'value' => $section['data']['label'],
			'index' => $index,
			'item-name' => $itemName,
		];

		foreach ( $section['data']['value'] as $child ) {
			$content .= $this->renderItem( $child['type'], $child['data'] );
		}

		$content = !empty($content)
			? [
				'index' => $index,
				'content' => $content,
				'item-name' => $itemName,
			] : null;

		return [
			'toggle' => $toggle,
			'content' => $content,
		];
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

	protected function createHorizontalGroupData( $groupData ) {
		$horizontalGroupData = [
			'labels' => [ ],
			'values' => [ ],
			'renderLabels' => false
		];

		foreach ( $groupData as $item ) {
			$data = $item['data'];

			if ( $item['type'] === 'data' ) {
				$horizontalGroupData['labels'][] = [
					'text' => $data['label'],
					'item-name' => $data['item-name'],
					'source' => $data['source'],
				];

				$horizontalGroupData['values'][] = [
					'text' => $data['value'],
					'item-name' => $data['item-name'],
					'source' => $data['source']
				];

				if ( !empty( $data['label'] ) ) {
					$horizontalGroupData['renderLabels'] = true;
				}
			} elseif ( $item['type'] === 'image' ) {

				// Only one image is supported in a horizontal group
				$image = $data[0];

				$horizontalGroupData['labels'][] = [
					'text' => $image['caption'],
					'item-name' => $image['item-name'],
					'source' => $image['source'],
				];

				// Caption is used to display label in TH
				// Unset it so it is not rendered also as an image caption
				$image['caption'] = null;

				$horizontalGroupData['values'][] = [
					'text' => $this->renderImage( [ $image ] ),
					'item-name' => $image['item-name'],
					'source' => $image['source']
				];
			} elseif ( $item['type'] === 'header' ) {

				$horizontalGroupData['header'] = [
					'value' => $data['value'],
					'source' => $data['source'],
					'item-name' => $data['item-name'],
					'inline-styles' => $this->inlineStyles
				];
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
		return array_reduce(
			$rowItems,
			function ( $result, $item ) use ( $capacity ) {
				$styles = "width: calc({$item['data']['span']} / $capacity * 100%);";

				$label = $item['data']['label'] ?? "";
				if ( !empty( $label ) ) {
					$result['renderLabels'] = true;
				}

				$result['labels'][] = [
					'value' => $label,
					'inlineStyles' => $styles,
					'item-name' => $item['data']['item-name'],
					'source' => $item['data']['source']
				];

				$result['values'][] = [
					'value' => $item['data']['value'],
					'inlineStyles' => $styles,
					'item-name' => $item['data']['item-name'],
					'source' => $item['data']['source']
				];

				return $result;
			},
			[ 'labels' => [], 'values' => [], 'renderLabels' => false ]
		);
	}
}
