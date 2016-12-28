<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxMustacheEngine;
use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxRenderService extends WikiaService {
	protected $templateEngine;
	protected $imagesWidth;
	protected $inlineStyles;

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

		$helper = new PortableInfoboxRenderServiceHelper();
		$this->inlineStyles = $this->getInlineStyles( $accentColor, $accentColorText );
		$infoboxHtmlContent = '';

		// decide on image width, if europa go with bigger images! else default size
		$this->imagesWidth = $helper->isEuropaTheme() ? PortableInfoboxRenderServiceHelper::EUROPA_THUMBNAIL_WIDTH :
			PortableInfoboxRenderServiceHelper::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;

		foreach ( $infoboxdata as $item ) {
			$type = $item[ 'type' ];

			if ( $this->templateEngine->isSupportedType( $type ) ) {
				if ( $type === 'title' || $type === 'header' ) {
					$item[ 'data' ][ 'inlineStyles' ] = $this->inlineStyles;
				}

				$infoboxHtmlContent .= $this->renderItem( $type, $item[ 'data' ] );
			}
		}

		if ( !empty( $infoboxHtmlContent ) ) {
			$output = $this->renderItem( 'wrapper', [
				'content' => $infoboxHtmlContent,
				'theme' => $theme,
				'layout' => $layout,
				'isEuropaEnabled' => $helper->isEuropaTheme()
			] );
		} else {
			$output = '';
		}

		return $output;
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
		if ( $type === 'group' ) {
			return $this->renderGroup( $data );
		}
		if ( $type === 'image' ) {
			return $this->renderImage( $data );
		}

		return $this->render( $type, $data );
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
		$helper = new PortableInfoboxRenderServiceHelper();
		$groupHTMLContent = '';
		$dataItems = $groupData[ 'value' ];
		$layout = $groupData[ 'layout' ];
		$collapse = $groupData[ 'collapse' ];

		if ( $layout === 'horizontal' ) {
			$groupHTMLContent .= $this->renderItem(
				'horizontal-group-content',
				$helper->createHorizontalGroupData( $dataItems )
			);
		} else {
			foreach ( $dataItems as $item ) {
				$type = $item[ 'type' ];

				if ( $this->templateEngine->isSupportedType( $type ) ) {
					if ( $type === 'title' || $type === 'header' ) {
						$item[ 'data' ][ 'inlineStyles' ] = $this->inlineStyles;
					}

					$groupHTMLContent .= $this->renderItem( $type, $item[ 'data' ] );
				}
			}
		}

		if ( $collapse !== null && count( $dataItems ) > 0 && $dataItems[ 0 ][ 'type' ] === 'header' ) {
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
		$helper = new PortableInfoboxRenderServiceHelper();
		$images = [ ];

		for ( $i = 0; $i < count( $data ); $i++ ) {
			$data[ $i ] = $helper->extendImageData( $data[ $i ], $this->imagesWidth );

			if ( !!$data[ $i ] ) {
				$images[] = $data[ $i ];
			}
		}

		if ( count( $images ) === 0 ) {
			return '';
		}

		if ( count( $images ) === 1 ) {
			$data = $images[ 0 ];
			$templateName = 'image';
		} else {
			// More than one image means image collection
			$data = $helper->extendImageCollectionData( $images );
			$templateName = 'image-collection';
		}

		return $this->render( $templateName, $data );
	}

	private function getInlineStyles( $accentColor, $accentColorText ) {
		$backgroundColor = empty( $accentColor ) ? '' : "background-color:{$accentColor};";
		$color = empty( $accentColorText ) ? '' : "color:{$accentColorText};";

		return "{$backgroundColor}{$color}";
	}
}
