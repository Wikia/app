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
		if ( !empty( F::app()->wg->SEOGoogleSiteVerification ) ) {
			$out->addMeta( 'google-site-verification', F::app()->wg->SEOGoogleSiteVerification );
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
			F::app()->wg->Out->setStatusCode( SEOTweaksHooksHelper::DELETED_PAGES_STATUS_CODE );
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

			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {

				$newTitle = wfMsg('seotweaks-video') . ' - ' . $title->getBaseText();
			} else {

				// It's not Video so lets check if it is Image
				if ( $file instanceof LocalFile && $file->getHandler() instanceof BitmapHandler ) {

					$newTitle = wfMsg('seotweaks-image') . ' - ' . $title->getBaseText();
				}
			}

			if ( !empty( $newTitle ) ) {
				$this->wg->out->setPageTitle( $newTitle );
			}
		}
		return true;
	}

}
