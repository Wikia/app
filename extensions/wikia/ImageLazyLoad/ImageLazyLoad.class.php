<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

class ImageLazyLoad  {

	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';

	private static $isWikiaMobile = null;
	private static $enabled = null;

	private static $onload = "if(typeof ImgLzy=='object'){ImgLzy.load(this)}";

	public static function isEnabled() {
		if ( is_null( self::$enabled ) ) {
			$app = F::app();
			self::$enabled = false;

			if ( self::$isWikiaMobile === null ) {
				self::$isWikiaMobile = $app->checkSkin( 'wikiamobile' );
			}

			if ( !self::$isWikiaMobile && empty( $app->wg->RTEParserEnabled ) ) {
				self::$enabled = true;
			}
		}

		return self::$enabled;
	}

	public static function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file, &$html ) {
		if ( self::isValidLazyLoadedImage( $attribs[ 'src' ] ) ) {
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
			$lazyImageAttribs[ 'onload' ] = self::$onload;

			$count = 0;
			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html, $count );
			if ( $count == 0 ) {
				$html = str_replace( $origImgAlt, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );
			}
		}

		return true;
	}

	public static function onGalleryBeforeRenderImage( &$image ) {
		global $wgRTEParserEnabled, $wgParser;

		if ( self::isEnabled() && empty( $wgRTEParserEnabled ) ) {

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

	public static function onParserClearState( &$parser ) {
		if ( !empty( $parser->lazyLoadedImagesCount ) ) {
			$parser->lazyLoadedImagesCount = 0;
		}
		return true;
	}

	public static function onBeforePageDisplay( OutputPage &$out, &$skin ) {
		global $wgExtensionsPath;
		if ( self::isEnabled() ) {
			$out->addHtml( '<noscript><link rel="stylesheet" href="' . $wgExtensionsPath . '/wikia/ImageLazyLoad/css/ImageLazyLoadNoScript.css" /></noscript>' );
		}
		return true;
	}

	/**
	 * Add wgEnableWebPSupportStats and wgEnableWebPThumbnails global JS variables
	 *
	 * wgEnableWebPSupportStats: report WebP support when enabled
	 * wgEnableWebPThumbnails: request WebP thumbnails if enabled (and supported by the browser)
	 *
	 * @param array $vars JS variables
	 * @return bool true
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		global $wgEnableWebPSupportStats, $wgEnableWebPThumbnails;

		if ( self::isEnabled() ) {
			if ( !empty( $wgEnableWebPSupportStats ) ) {
				$vars['wgEnableWebPSupportStats'] = true;
			}

			if ( !empty( $wgEnableWebPThumbnails ) ) {
				$vars['wgEnableWebPThumbnails'] = true;
			}
		}
		return true;
	}

	/**
	 * Set attributes for lazy loading (for video thumbnail)
	 * @param string $dataSrc
	 * @param string $imgSrc
	 * @param string $imgClass
	 * @param array $imgAttribs
	 * @return boolean
	 */
	public static function setLazyLoadingAttribs( &$dataSrc, &$imgSrc, &$imgClass, &$imgAttribs ) {
		if ( self::isValidLazyLoadedImage( $imgSrc ) ) {
			$imgClass = self::getImgClass( [ 'class' => $imgClass ] );
			$dataSrc = $imgSrc;
			$imgSrc = wfBlankImgUrl();
			$imgAttribs['onload'] = self::$onload;
		}

		return true;
	}


	/**
	 * Check for valid lazy loaded image
	 * @global boolean $wgRTEParserEnabled
	 * @global type $wgParser
	 * @param string $imgSrc
	 * @return boolean
	 */
	public static function isValidLazyLoadedImage( $imgSrc ) {
		global $wgRTEParserEnabled, $wgParser;

		if ( self::isEnabled() && empty( $wgRTEParserEnabled ) ) {
			// Don't lazy-load data elements
			if ( startsWith( $imgSrc, 'data:' ) ) {
				return false;
			}

			if ( !empty( $wgParser ) ) {
				if ( empty( $wgParser->lazyLoadedImagesCount ) ) {
					$wgParser->lazyLoadedImagesCount = 0;
				}

				$wgParser->lazyLoadedImagesCount += 1;

				// Skip first few images in article
				if ( $wgParser->lazyLoadedImagesCount < 4 ) {
					return false;
				}
			}
		}

		return true;
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
