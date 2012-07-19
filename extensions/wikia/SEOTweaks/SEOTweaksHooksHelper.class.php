<?php

/**
 * SEOTweaks Hooks Helper
 * @author mech
 */

class SEOTweaksHooksHelper extends WikiaModel {

	function onBeforePageDisplay( $out ) {
		if ( !empty( F::app()->wg->SEOGoogleSiteVerification ) ) {
			$out->addMeta( 'google-site-verification', F::app()->wg->SEOGoogleSiteVerification );
		}
		return true;
	}

}