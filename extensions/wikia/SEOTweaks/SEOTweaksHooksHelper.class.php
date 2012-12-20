<?php

/**
 * SEOTweaks Hooks Helper
 * @author mech
 * @author ADi
 * @author Jacek Jursza <jacek at wikia-inc.com>
 */

class SEOTweaksHooksHelper extends WikiaModel {
	const DELETED_PAGES_STATUS_CODE = 410;

	/**
	 * @author mech
	 * @param OutputPage $out
	 * @return bool true
	 */
	function onBeforePageDisplay( $out ) {
		if ( !empty( $this->wg->SEOGoogleSiteVerification ) ) {
			$out->addMeta( 'google-site-verification', $this->wg->SEOGoogleSiteVerification );
		}
		if ( !empty( $this->wg->SEOGooglePlusLink ) ) {
			$out->addLink( array( 'href' => $this->wg->SEOGooglePlusLink, 'rel' => 'publisher' ) );
		}
		return true;
	}

	/**
	 * set appropriate status code for deleted pages
	 *
	 * @author ADi
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	public function onArticleFromTitle( &$title, &$article ) {
		if( !$title->exists() && $title->isDeleted() ) {
			$this->wg->Out->setStatusCode( SEOTweaksHooksHelper::DELETED_PAGES_STATUS_CODE );
		}
		return true;
	}

	/**
	 * change title tag for Video Page and Image Page
	 * @author Jacek Jursza
	 * @param ImagePage $imgPage
	 * @param $html
	 * @return bool
	 */
	function onImagePageAfterImageLinks( $imgPage, $html ) {

		$file = $imgPage->getDisplayedFile(); /* @var $file LocalRepo */
		$title = $imgPage->getTitle();  /* @var $title Title */
		$newTitle = '';

		if ( !empty( $file ) && !empty( $title ) ) {

			if ( F::build( 'WikiaFileHelper' )->isFileTypeVideo( $file ) ) {

				$newTitle = $this->wf->Msg('seotweaks-video') . ' - ' . $title->getBaseText();
			} else {

				// It's not Video so lets check if it is Image
				if ( $file instanceof LocalFile && $file->getHandler() instanceof BitmapHandler ) {

					$newTitle = $this->wf->Msg('seotweaks-image') . ' - ' . $title->getBaseText();
				}
			}

			if ( !empty( $newTitle ) ) {
				$this->wg->Out->setPageTitle( $newTitle );
			}
		}
		return true;
	}
	
	/**
	 * Prepends alt text for an image if that image does not have that option set
	 * @param  Parser $parser
	 * @param  Title  $title
	 * @param  Array  $options
	 * @param  bool   $descQuery
	 * @return bool
	 */
	public function onBeforeParserMakeImageLinkObjOptions( $parser, $title, &$parts, &$params, &$time, &$descQuery, $options ) {
		$grepped = preg_grep( '/^alt=/', (array) $parts);
		if ( $title->getNamespace() == NS_FILE && empty( $grepped ) ) {
			$text = $title->getText();
			$alt = implode( '.', array_slice( explode( '.', $text ), 0, -1 ) ); // lop off text after the ultimate dot (e.g. JPG)
			$parts[] = "alt={$alt}";
		}
		
		return true;
		
	}

}
