<?php

namespace Wikia\PortableInfobox\Helpers;

use Wikia\Logger\WikiaLogger;
use Wikia\Template\MustacheEngine;

class PortableInfoboxMustacheEngine {
	const TYPE_NOT_SUPPORTED_MESSAGE = 'portable-infobox-render-not-supported-type';

	protected static $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'header' => 'PortableInfoboxItemHeader.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'image-mobile' => 'PortableInfoboxItemImageMobile.mustache',
		'image-mobile-wikiamobile' => 'PortableInfoboxItemImageMobileWikiaMobile.mustache',
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'smart-group' => 'PortableInfoboxItemSmartGroup.mustache',
		'horizontal-group-content' => 'PortableInfoboxHorizontalGroupContent.mustache',
		'navigation' => 'PortableInfoboxItemNavigation.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache',
		'hero-mobile-wikiamobile' => 'PortableInfoboxItemHeroMobileWikiaMobile.mustache',
		'image-collection' => 'PortableInfoboxItemImageCollection.mustache',
		'image-collection-mobile' => 'PortableInfoboxItemImageCollectionMobile.mustache',
		'image-collection-mobile-wikiamobile' => 'PortableInfoboxItemImageCollectionMobileWikiaMobile.mustache'
	];
	protected $templateEngine;

	public function __construct() {
		$this->templateEngine = ( new MustacheEngine )
			->setPrefix( self::getTemplatesDir() );
	}

	public static function getTemplatesDir() {
		return dirname( __FILE__ ) . '/../../templates';
	}

	public static function getTemplates() {
		return self::$templates;
	}

	public function render( $type, array $data ) {
		return $this->templateEngine->clearData()
			->setData( $data )
			->render( self::getTemplates()[ $type ] );
	}

	/**
	 * check if item type is supported and logs unsupported types
	 *
	 * @param string $type - template type
	 *
	 * @return bool
	 */
	public static function isSupportedType( $type ) {
		$result = isset( static::$templates[ $type ] );
		if ( !$result ) {
			WikiaLogger::instance()->info( self::TYPE_NOT_SUPPORTED_MESSAGE, [ 'type' => $type ] );
		}
		return $result;
	}
}
