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
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'horizontal-group-content' => 'PortableInfoboxHorizontalGroupContent.mustache',
		'navigation' => 'PortableInfoboxItemNavigation.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache',
		'gallery' => 'PortableInfoboxGallery.mustache'
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

		$galleryData = Array (
			Array (
				'url' => 'http://vignette.wikia-dev.com/visualeditor/images/b/b8/Challenger.jpg/revision/latest?cb=20140626002212',
				'name' => 'Challenger.jpg',
				'key' => 'Challenger.jpg',
				'alt' => '',
				'caption' => 'This is a caption'
			),
			Array (
				'url' => 'http://vignette.wikia-dev.com/visualeditor/images/1/1d/Challenger-1.jpg/revision/latest?cb=20140626002317',
				'name' => 'Challenger-1.jpg',
				'key' => 'Challenger-1.jpg',
				'alt' => '',
				'caption' => 'This is a caption for Challenger 1'
			),
			Array (
				'url' => 'http://vignette.wikia-dev.com/visualeditor/images/4/41/Challenger-0.jpg/revision/latest?cb=20140626002239',
				'name' => 'Challenger-0.jpg',
				'key' => 'Challenger-0.jpg',
				'alt' => '',
				'caption' => 'This is a caption for Challenger 0'
			)
		);
		$infoboxHtmlContent = $this->renderGallery($galleryData) . $infoboxHtmlContent;

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
		$helper = new PortableInfoboxRenderServiceHelper();;
		$groupHTMLContent = '';
		$dataItems = $groupData[ 'value' ];
		$layout = $groupData[ 'layout' ];

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

		return $this->renderItem( 'group', [ 'content' => $groupHTMLContent ] );
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
			$data[ 'image' ][ 'context' ] = self::MEDIA_CONTEXT_INFOBOX_HERO_IMAGE;
			$data[ 'image' ] = $helper->extendImageData( $data[ 'image' ] );
			$markup = $this->renderItem( 'hero-mobile', $data );
		} else {
			$markup = $this->renderItem( 'title', $data[ 'title' ] );
		}

		return $markup;
	}

	/**
	 * renders infobox gallery component
	 *
	 * @param array $data - array of images
	 *
	 * @return string
	 */
	private function renderGallery( $data ) {
		$helper = new PortableInfoboxRenderServiceHelper();

		$galleryData = Array();
		$hero = array_shift($data);
		$galleryData['hero'] = $helper->extendImageData( $hero );
		$galleryData['extras'] = $data;

		$markup = $this->renderItem( 'gallery', $galleryData );

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
			$data[ 'image' ][ 'context' ] = self::MEDIA_CONTEXT_INFOBOX;
			$data = $helper->extendImageData( $data );
			if ( !$data ) {
				return false;
			}

			if ( $helper->isWikiaMobile() ) {
				$type = $type . self::MOBILE_TEMPLATE_POSTFIX;
			}
		}

		if ( $helper->isWikiaMobile() ) {
			$data = $helper->sanitizeInfoboxTitle( $type, $data );
		}

		return $this->templateEngine->clearData()
			->setData( $data )
			->render( self::getTemplates()[ $type ] );
	}
}
