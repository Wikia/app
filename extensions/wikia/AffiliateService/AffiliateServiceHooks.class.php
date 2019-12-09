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

		global $wgTitle;
		// Proper namespace => Article (NS 0) and not Main Pages
		$isProperNamespace = is_object( $wgTitle )
			&& ( !$wgTitle->isMainPage() )
			&& ( $wgTitle->getNamespace() === NS_MAIN );

		// TODO: Hardocde community IDs here (CAKE-5379)
		$isProperCommunity = Wikia::isDevEnv();

		// only enable it onNS 0 AND dev env
		$vars['wgAffiliateEnabled'] = $isProperNamespace && $isProperCommunity;

		wfProfileOut( __METHOD__ );
		return true;
	}
}
