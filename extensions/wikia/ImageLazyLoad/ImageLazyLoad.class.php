<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

class ImageLazyLoad  {

	const START_LAZY_LOADED_IMAGE = 4;
	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';
	const IMG_ONLOAD = "if(typeof ImgLzy==='object'){ImgLzy.load(this)}";

	private static $enabled = null;

	private static function isEnabled(): bool {
		if ( is_null( self::$enabled ) ) {
			self::$enabled = !F::app()->checkSkin( 'wikiamobile' );
		}

		return self::$enabled;
	}

	/**
	 * Disable image loading for the scope of the current request
	 */
	public static function disable() {
		self::$enabled = false;
	}

	public static function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file, &$html ) {
		if ( false ) {
			$origImgAlt = Xml::element( 'img', $attribs, '', true );

			// Remove empty alt attributes (messes up string replace later if not removed)
			if ( isset( $attribs[ 'alt' ] ) && empty( $attribs[ 'alt' ] ) ) {
				unset( $attribs[ 'alt' ] );
			}

			$origImg = Xml::element( 'img', $attribs, '', true );

			$lazyImageAttribs = $attribs;
			$lazyImageAttribs[ 'data-src' ] = $lazyImageAttribs[ 'src' ];
			$lazyImageAttribs[ 'src' ] = wfBlankImgUrl();
			$lazyImageAttribs[ 'class' ] = self::getImgClass( $lazyImageAttribs );
			/* for AJAX requests - makes sure that they are handled properly */
			/* ImgLzy.load is not executed for main content because ImgLzy object is initiated on DOM ready event and those images */
			/* are base64 encoded so they are "loaded" with the content itself */
			$lazyImageAttribs[ 'onload' ] = self::IMG_ONLOAD;

			$count = 0;
			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html, $count );
			if ( $count == 0 ) {
				$html = str_replace( $origImgAlt, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );
			}
		}

		return true;
	}

	public static function onGalleryBeforeRenderImage( &$image ) {
		global $wgParser;

		if ( false ) {

			// Don't lazy-load data elements
			if ( startsWith( $image[ 'thumbnail' ], 'data:' ) ) {
				return true;
			}

			if ( !empty( $wgParser ) ) {
				if ( empty( $wgParser->lazyLoadedImagesCount ) ) {
					$wgParser->lazyLoadedImagesCount = 0;
				}

				// not used here, still important for regular images
				// which are not part of galleries
				$wgParser->lazyLoadedImagesCount += 1;
			}

			$image['thumbnail-src'] = wfBlankImgUrl();
			$image['thumbnail-classes'] = self::LAZY_IMAGE_CLASSES;
			$image['thumbnail-onload'] = 'if(typeof ImgLzy=="object"){ImgLzy.load(this)}';

		}

		return true;

	}

	public static function onParserClearState( Parser $parser ) {
		if ( !empty( $parser->lazyLoadedImagesCount ) ) {
			$parser->lazyLoadedImagesCount = 0;
		}
		return true;
	}

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
		global $wgExtensionsPath;
		if ( self::isEnabled() ) {
			$out->addHtml( '<noscript><link rel="stylesheet" href="' . $wgExtensionsPath . '/wikia/ImageLazyLoad/css/ImageLazyLoadNoScript.css" /></noscript>' );
		}
		return true;
	}

	/**
	 * Update thumbnail img attributes when lazy loading
	 * @param WikiaDispatchableObject $controller
	 */
	public static function setLazyLoadingAttribs( WikiaDispatchableObject $controller ) {
		$controller->onLoad = self::IMG_ONLOAD;
		$controller->imgClass = array_merge( $controller->imgClass, explode( ' ', self::LAZY_IMAGE_CLASSES ) );
		$controller->dataSrc = $controller->imgSrc;
		$controller->imgSrc = wfBlankImgUrl();
	}

	/**
	 * Check whether or not the image is valid for lazy loading
	 * @param string $imgSrc
	 * @return boolean
	 */
	public static function isValidLazyLoadedImage( $imgSrc ) {
		global $wgParser;

		if ( self::isEnabled() ) {
			// Don't lazy-load data elements
			if ( startsWith( $imgSrc, 'data:' ) ) {
				return false;
			}

			// Use empty as wgParser is wrapped with StubObject so the object may not be initized yet.
			if ( !empty( $wgParser ) && !empty( $wgParser->mIsMainParse ) ) {
				if ( empty( $wgParser->lazyLoadedImagesCount ) ) {
					$wgParser->lazyLoadedImagesCount = 0;
				}

				$wgParser->lazyLoadedImagesCount += 1;

				// Skip first few images in article
				if ( $wgParser->lazyLoadedImagesCount < self::START_LAZY_LOADED_IMAGE ) {
					return false;
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Get class attribute for img tag
	 * @param array $attrbs
	 * @return string
	 */
	protected static function getImgClass( $attrbs ) {
		return ( empty( $attrbs['class'] ) ? '' : $attrbs['class'] . ' ' ) . self::LAZY_IMAGE_CLASSES;
	}

}
