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

		// only enable on proper namespaces
		$vars['wgAffiliateEnabled'] = $isProperNamespace;

		// add translations from AffiliateService.i18n.php
		$vars['disclaimerMessage'] = wfMessage('affiliate-service-disclaimer')->plain();

		wfProfileOut( __METHOD__ );
		return true;
	}
}
