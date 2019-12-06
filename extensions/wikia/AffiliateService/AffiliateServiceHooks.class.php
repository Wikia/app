<?php

class AffiliateServiceHooks {
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		$out->addModules( 'ext.wikia.AffiliateService' );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onWikiaSkinTopScripts( Array &$vars, &$scripts ) {
		wfProfileIn( __METHOD__ );
		$vars['wgAffiliateEnabled'] = Wikia::isDevEnv();
		wfProfileOut( __METHOD__ );
		return true;
	}
}
