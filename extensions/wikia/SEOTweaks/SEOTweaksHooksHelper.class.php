<?php

/**
 * SEOTweaks Hooks Helper
 * @author mech
 * @author ADi
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

}
