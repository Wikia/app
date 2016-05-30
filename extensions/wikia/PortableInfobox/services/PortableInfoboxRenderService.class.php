<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxRenderService extends WikiaService {
	const MOBILE_TEMPLATE_POSTFIX = '-mobile';
	const MEDIA_CONTEXT_INFOBOX_HERO_IMAGE = 'infobox-hero-image';
	const MEDIA_CONTEXT_INFOBOX = 'infobox';

	private static $templates = [
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
	private $templateEngine;
	private $imagesWidth;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( self::getTemplatesDir() );
		$this->imagesWidth = PortableInfoboxRenderServiceHelper::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;
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
		$heroData = [ ];

		// decide on image width
		$this->imagesWidth = $helper->isMobile() ?
			PortableInfoboxRenderServiceHelper::MOBILE_THUMBNAIL_WIDTH :
			// if europa go with bigger images! else default size
			$helper->isEuropaTheme() ? PortableInfoboxRenderServiceHelper::EUROPA_THUMBNAIL_WIDTH :
				PortableInfoboxRenderServiceHelper::DEFAULT_DESKTOP_THUMBNAIL_WIDTH;

		foreach ( $infoboxdata as $item ) {
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];

			switch ( $type ) {
				case 'group':
					$infoboxHtmlContent .= $this->renderGroup( $data );
					break;
				case 'navigation':
					$infoboxHtmlContent .= $this->renderItem( 'navigation', $data );
					break;
				default:
					if ( $helper->isMobile() && $helper->isValidHeroDataItem( $item, $heroData ) ) {
						$heroData[ $type ] = $data;
						continue;
					}

					if ( $helper->isTypeSupportedInTemplates( $type, self::getTemplates() ) ) {
						$infoboxHtmlContent .= $this->renderItem( $type, $data );
					};
			}
		}

		if ( !empty( $heroData ) ) {
			$infoboxHtmlContent = $this->renderInfoboxHero( $heroData ) . $infoboxHtmlContent;
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

		\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setFirstInfoboxAlredyRendered( true );

		wfProfileOut( __METHOD__ );

		return $output;
	}

	/**
	 * renders group infobox component
	 *
	 * @param array $groupData
	 *
	 * @return string - group HTML markup
	 */
	private function renderGroup( $groupData ) {
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

		return $this->renderItem( 'group', [
			'content' => $groupHTMLContent,
			'cssClasses' => implode( ' ', $cssClasses )
		] );
	}

	/**
	 * renders infobox hero component
	 *
	 * @param array $data - infobox hero component data
	 *
	 * @return string
	 */
	private function renderInfoboxHero( $data ) {
		$helper = new PortableInfoboxRenderServiceHelper();

		if ( array_key_exists( 'image', $data ) ) {
			$image = $data[ 'image' ][ 0 ];
			$image[ 'context' ] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$image = $helper->extendImageData( $image, PortableInfoboxRenderServiceHelper::MOBILE_THUMBNAIL_WIDTH );
			$data[ 'image' ] = $image;

			if ( !$helper->isMercury() ) {
				$markup = $this->renderItem( 'hero-mobile-wikiamobile', $data );
			} elseif (
				\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->isFirstInfoboxAlredyRendered()
			) {
				$markup = $this->renderItem( 'hero-mobile', $data );
			}
		} else {
			$markup = $this->renderItem( 'title', $data[ 'title' ] );
		}

		return $markup;
	}

	/**
	 * renders part of infobox
	 * If image element has invalid thumbnail, doesn't render this element at all.
	 *
	 * @param string $type
	 * @param array $data
	 *
	 * @return bool|string - HTML
	 */
	private function renderItem( $type, array $data ) {
		$helper = new PortableInfoboxRenderServiceHelper();

		if ( $type === 'image' ) {
			$images = [ ];

			for ( $i = 0; $i < count( $data ); $i++ ) {
				$data[ $i ][ 'context' ] = self::MEDIA_CONTEXT_INFOBOX;
				$data[ $i ] = $helper->extendImageData( $data[ $i ], $this->imagesWidth );

				if ( !!$data[ $i ] ) {
					$images[] = $data[ $i ];
				}
			}

			if ( count( $images ) === 0 ) {
				return false;
			} else if ( count( $images ) === 1 ) {
				$data = $images[ 0 ];
				$templateName = $type;
			} else {
				// More than one image means image collection
				if ( $helper->isMobile() && !$helper->isMercury() ) {
					// Display only the first image on WikiaMobile
					$data = $images[ 0 ];
				} else {
					$data = $helper->extendImageCollectionData( $images );
				}
				$templateName = 'image-collection';
			}

			if ( $helper->isMobile() ) {
				if ( !$helper->isMercury() ) {
					$templateName = $templateName . self::MOBILE_TEMPLATE_POSTFIX . '-wikiamobile';
				} else {
					$templateName = $templateName . self::MOBILE_TEMPLATE_POSTFIX;
				}
			}
		} else {
			$templateName = $type;
		}

		/**
		 * Currently, based on business decision, sanitization happens ONLY on Mercury
		 */
		if ( $helper->isMobile() ) {
			$data = SanitizerBuilder::createFromType( $type )->sanitize( $data );
		}

		return $this->templateEngine->clearData()
			->setData( $data )
			->render( self::getTemplates()[ $templateName ] );
	}
}
