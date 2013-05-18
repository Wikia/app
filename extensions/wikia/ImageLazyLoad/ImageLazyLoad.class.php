<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

class ImageLazyLoad extends WikiaObject {
	static private $isWikiaMobile = null;
	static private $enabled = null;
	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';

	public function isEnabled() {
		if ( is_null( self::$enabled ) ) {
			self::$enabled = false;

			if ( self::$isWikiaMobile === null ) {
				self::$isWikiaMobile = $this->app->checkSkin( 'wikiamobile' );
			}

			if ( !self::$isWikiaMobile && empty( $this->app->wg->RTEParserEnabled ) ) {
				self::$enabled = true;
			}
		}

		return self::$enabled;
	}

	public function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file, &$html ) {
		global $wgRTEParserEnabled;

		if ( $this->isEnabled() && empty( $wgRTEParserEnabled ) ) {

			// Don't lazy-load data elements
			if ( startsWith( $attribs[ 'src' ], 'data:' ) ) {
				return true;
			}

			if ( !empty( $this->app->wg->Parser ) ) {
				if ( empty( $this->app->wg->Parser->lazyLoadedImagesCount ) ) {
					$this->app->wg->Parser->lazyLoadedImagesCount = 0;
				}

				$this->app->wg->Parser->lazyLoadedImagesCount += 1;

				// Skip first few images in article
				if ( $this->app->wg->Parser->lazyLoadedImagesCount < 4 ) {
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
			$lazyImageAttribs[ 'src' ] = $this->wf->BlankImgUrl();
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

	function onGalleryBeforeRenderImage( &$image ) {
		global $wgRTEParserEnabled;

		if ( $this->isEnabled() && empty( $wgRTEParserEnabled ) ) {

			// Don't lazy-load data elements
			if ( startsWith( $image[ 'thumbnail' ], 'data:' ) ) {
				return true;
			}

			if ( !empty( $this->app->wg->Parser ) ) {
				if ( empty( $this->app->wg->Parser->lazyLoadedImagesCount ) ) {
					$this->app->wg->Parser->lazyLoadedImagesCount = 0;
				}

				// not used here, still important for regular images
				// which are not part of galleries
				$this->app->wg->Parser->lazyLoadedImagesCount += 1;

			}

			$image['thumbnail-src'] = $this->wf->BlankImgUrl();
			$image['thumbnail-classes'] = self::LAZY_IMAGE_CLASSES;
			$image['thumbnail-onload'] = 'if(typeof ImgLzy=="object"){ImgLzy.load(this)}';

		}

		return true;

	}

	function onParserClearState( &$parser ) {
		if ( !empty( $parser->lazyLoadedImagesCount ) ) {
			$parser->lazyLoadedImagesCount = 0;
		}
		return true;
	}

	function onBeforePageDisplay( OutputPage &$out, &$skin ) {
		if ( $this->isEnabled() ) {
			$out->addHtml( '<noscript><link rel="stylesheet" href="' . $this->app->wg->ExtensionsPath . '/wikia/ImageLazyLoad/css/ImageLazyLoadNoScript.css" /></noscript>' );
		}
		return true;
	}
}
