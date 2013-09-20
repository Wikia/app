<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

class ImageLazyLoad  {
	static private $isWikiaMobile = null;
	static private $enabled = null;
	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';

	static public function isEnabled() {
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

	static public function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file, &$html ) {
		global $wgRTEParserEnabled, $wgParser;

		if ( self::isEnabled() && empty( $wgRTEParserEnabled ) ) {

			// Don't lazy-load data elements
			if ( startsWith( $attribs[ 'src' ], 'data:' ) ) {
				return true;
			}

			if ( !empty( $wgParser ) ) {
				if ( empty( $wgParser->lazyLoadedImagesCount ) ) {
					$wgParser->lazyLoadedImagesCount = 0;
				}

				$wgParser->lazyLoadedImagesCount += 1;

				// Skip first few images in article
				if ( $wgParser->lazyLoadedImagesCount < 4 ) {
					return true;
				}
			}

			$origImgAlt = Xml::element( 'img', $attribs, '', true );

			// Remove empty alt attributes (messes up string replace later if not removed)
			if ( isset( $attribs[ 'alt' ] ) && empty( $attribs[ 'alt' ] ) ) {
				unset( $attribs[ 'alt' ] );
			}

			$origImg = Xml::element( 'img', $attribs, '', true );

			$lazyImageAttribs = $attribs;
			$lazyImageAttribs[ 'data-src' ] = $lazyImageAttribs[ 'src' ];
			$lazyImageAttribs[ 'src' ] = wfBlankImgUrl();
			$lazyImageAttribs[ 'class' ] = ( ( !empty( $lazyImageAttribs[ 'class' ] ) ) ? $lazyImageAttribs[ 'class' ] . ' ' : '' ) . self::LAZY_IMAGE_CLASSES;
			/* for AJAX requests - makes sure that they are handled properly */
			/* ImgLzy.load is not executed for main content because ImgLzy object is initiated on DOM ready event and those images */
			/* are base64 encoded so they are "loaded" with the content itself */
			$lazyImageAttribs[ 'onload' ] = 'if(typeof ImgLzy=="object"){ImgLzy.load(this)}';

			$count = 0;
			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html, $count );
			if($count == 0) {
				$html = str_replace( $origImgAlt, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );
			} else {
			}

		}

		return true;
	}

	static public function onGalleryBeforeRenderImage( &$image ) {
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

	static function onParserClearState( &$parser ) {
		if ( !empty( $parser->lazyLoadedImagesCount ) ) {
			$parser->lazyLoadedImagesCount = 0;
		}
		return true;
	}

	static function onBeforePageDisplay( OutputPage &$out, &$skin ) {
		global $wgExtensionsPath;
		if ( self::isEnabled() ) {
			$out->addHtml( '<noscript><link rel="stylesheet" href="' . $wgExtensionsPath . '/wikia/ImageLazyLoad/css/ImageLazyLoadNoScript.css" /></noscript>' );
		}
		return true;
	}
}
