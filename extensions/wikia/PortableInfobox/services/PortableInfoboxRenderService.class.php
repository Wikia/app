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
		'image-mobile-experimental' => 'PortableInfoboxItemImageMobileExperimental.mustache',
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'horizontal-group-content' => 'PortableInfoboxHorizontalGroupContent.mustache',
		'navigation' => 'PortableInfoboxItemNavigation.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache',
		'hero-mobile-experimental' => 'PortableInfoboxItemHeroMobileExperimental.mustache',
		'image-collection' => 'PortableInfoboxItemImageCollection.mustache',
		'image-collection-mobile' => 'PortableInfoboxItemImageCollectionMobile.mustache',
		'image-collection-mobile-experimental' => 'PortableInfoboxItemImageCollectionMobile.mustache'
	];
	private $templateEngine;

	function __construct() {
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
		$heroData = [ ];

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
					if ( $helper->isWikiaMobile() && $helper->isValidHeroDataItem( $item, $heroData ) ) {
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
			$output = $this->renderItem( 'wrapper',
				[ 'content' => $infoboxHtmlContent, 'theme' => $theme, 'layout' => $layout ] );
		} else {
			$output = '';
		}

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
		$cssClasses = [];
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
			'cssClasses' => implode(' ', $cssClasses)
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
		global $wgEnableSeoFriendlyImagesForMobile;

		$helper = new PortableInfoboxRenderServiceHelper();

		if ( array_key_exists( 'image', $data ) ) {
			$image = $data[ 'image' ][ 0 ];
			$image[ 'context' ] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$image = $helper->extendImageData( $image );
			$data['image'] = $image;

			if ( !empty( $wgEnableSeoFriendlyImagesForMobile ) ) {
				$markup = $this->renderItem( 'hero-mobile-experimental', $data );
			} else {
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
		global $wgEnableSeoFriendlyImagesForMobile;

		$helper = new PortableInfoboxRenderServiceHelper();

		if ( $type === 'image' ) {
			$images = array();

			for ( $i = 0; $i < count($data); $i++ ) {
				$data[$i][ 'context' ] = self::MEDIA_CONTEXT_INFOBOX;
				$data[$i] = $helper->extendImageData( $data[$i] );

				if ( !!$data[$i] ) {
					$images[] = $data[$i];
				}
			}

			if ( count ( $images ) === 0 ) {
				return false;
			} else if ( count ( $images ) === 1 ) {
				$data = $images[0];
				$templateName = $type;
			} else {
				$images[0]['isFirst'] = true;
				$data = array( 'images' => $images );
				$templateName = 'image-collection';
			}

			if ( $helper->isWikiaMobile() ) {
				if ( !empty( $wgEnableSeoFriendlyImagesForMobile ) ) {
					$templateName = $templateName . self::MOBILE_TEMPLATE_POSTFIX . '-experimental';
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
		if ( $helper->isWikiaMobile() ) {
			$data = SanitizerBuilder::createFromType( $type )->sanitize( $data );
		}

		return $this->templateEngine->clearData()
			->setData( $data )
			->render( self::getTemplates()[ $templateName ] );
	}
}
