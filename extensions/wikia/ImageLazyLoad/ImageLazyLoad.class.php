<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */


class ImageLazyLoad extends WikiaObject {

	static private $isWikiaMobile = null;
	static private $enabled = false;
	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';

	function __construct(){
		parent::__construct();

		if ( self::$isWikiaMobile === null ) {
			self::$isWikiaMobile = $this->app->checkSkin( 'wikiamobile' );
		}

		if( ! self::$isWikiaMobile && !$this->app->wg->RTEParserEnabled ) {
				self::$enabled = true;
		}
	}

	public function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file,  &$html ) {

		if( self::$enabled ) {

			if( startsWith($attribs['src'], 'data:') ) {
				// dont lazy-load data elements
				return true;
			}


			if ( !empty($this->app->wg->Parser) ) {
				if ( empty($this->app->wg->Parser->lazyLoadedImagesCount) ) $this->app->wg->Parser->lazyLoadedImagesCount = 0;
				$this->app->wg->Parser->lazyLoadedImagesCount += 1;

				// skip first few images in article
				if ( $this->app->wg->Parser->lazyLoadedImagesCount < 5 ) return true;
			}

			$origImg = Xml::element( 'img', $attribs, '', true );
			$lazyImageAttribs = $attribs;
			$lazyImageAttribs['data-src'] = $lazyImageAttribs['src'];
			$lazyImageAttribs['src'] = $this->wf->BlankImgUrl();
			$lazyImageAttribs['class'] = ( ( !empty( $lazyImageAttribs['class'] ) ) ? "{$lazyImageAttribs['class']} " : '' ) . self::LAZY_IMAGE_CLASSES;
			/* for AJAX requests - makes sure that they are handled properly */
			/* ImgLzy.load is not executed for main content because ImgLzy object is initiated on DOM ready event and those images */
			/* are base64 encoded so they are "loaded" with the content itself */
			$lazyImageAttribs['onload'] = 'if(typeof ImgLzy=="object")ImgLzy.load(this);';

			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );

		}

		return true;
	}

	function onParserClearState(&$parser) {
		if ( !empty($parser->lazyLoadedImagesCount) ) {
			$parser->lazyLoadedImagesCount = 0;
		}
		return true;
	}

	function onBeforePageDisplay(&$out, &$skin) {
		if( self::$enabled) {
			$url = "{$this->app->wg->ExtensionsPath}/wikia/ImageLazyLoad/css/ImageLazyLoadNoScript.css";
			$out->addHtml('<noscript><link rel="stylesheet" href="'.$url.'"/></noscript>');
		}
		return true;
	}

}