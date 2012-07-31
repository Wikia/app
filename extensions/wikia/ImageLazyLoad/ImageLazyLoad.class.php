<?php

/* Lazy loading for images inside articles (skips wikiamobile skin)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */


class ImageLazyLoad extends WikiaObject {

	static private $isWikiaMobile = null;
	const LAZY_IMAGE_CLASSES = 'lzy lzyPlcHld';

	function __construct(){
		parent::__construct();

		if ( self::$isWikiaMobile === null )
			self::$isWikiaMobile = $this->app->checkSkin( 'wikiamobile' );

	}

	public function onThumbnailImageHTML( $options, $linkAttribs, $attribs, $file,  &$html ) {

		if( ! self::$isWikiaMobile && !$this->app->wg->RTEParserEnabled ) {

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
			/* this is not executed for main content because ImgLzy object is initiated on DOM ready event and those images */
			/* are base64 encoded so they are "loaded" with the content itself */
			$lazyImageAttribs['onload'] = 'if(typeof ImgLzy=="object")ImgLzy.load(this);';

			$html = str_replace( $origImg, Xml::element( 'img', $lazyImageAttribs ) . "<noscript>{$origImg}</noscript>", $html );

		}

		return true;
	}


}