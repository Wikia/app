<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxRenderService extends WikiaService {
	protected static $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'header' => 'PortableInfoboxItemHeader.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'image-mobile' => 'PortableInfoboxItemImageMobile.mustache',
		'image-mobile-wikiamobile' => 'PortableInfoboxItemImageMobileWikiaMobile.mustache',
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'horizontal-group-content' => 'PortableInfoboxHorizontalGroupContent.mustache',
		'navigation' => 'PortableInfoboxItemNavigation.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache',
		'hero-mobile-wikiamobile' => 'PortableInfoboxItemHeroMobileWikiaMobile.mustache',
		'image-collection' => 'PortableInfoboxItemImageCollection.mustache',
		'image-collection-mobile' => 'PortableInfoboxItemImageCollectionMobile.mustache',
		'image-collection-mobile-wikiamobile' => 'PortableInfoboxItemImageCollectionMobileWikiaMobile.mustache'
	];
	protected $templateEngine;
	protected $imagesWidth;

	function __construct() {
		parent::__construct();
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( self::getTemplatesDir() );
	}

	public static function getTemplatesDir() {
		return dirname( __FILE__ ) . '/../templates';
	}

	public static function getTemplates() {
		return self::$templates;
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 *
	 * @param $theme
	 * @param $layout
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata, $theme, $layout ) {
		wfProfileIn( __METHOD__ );

		$helper = new PortableInfoboxRenderServiceHelper();
		$infoboxHtmlContent = '';

		// decide on image width, if europa go with bigger images! else default size
		$this->imagesWidth = $helper->isEuropaTheme() ? PortableInfoboxRenderServiceHelper::EUROPA_THUMBNAIL_WIDTH :
			PortableInfoboxRenderServiceHelper::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;

		foreach ( $infoboxdata as $item ) {
			$type = $item[ 'type' ];

			if ( $helper->isTypeSupportedInTemplates( $type, self::getTemplates() ) ) {
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

		wfProfileOut( __METHOD__ );

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
		return $this->templateEngine->clearData()
			->setData( $data )
			->render( self::getTemplates()[ $type ] );
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

				if ( $helper->isTypeSupportedInTemplates( $type, self::getTemplates() ) ) {
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
}
