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

		global $wgTitle, $wgCityId;
		// Proper namespace => Article (NS 0) and not Main Pages
		$isProperNamespace = is_object( $wgTitle )
			&& ( !$wgTitle->isMainPage() )
			&& ( $wgTitle->getNamespace() === NS_MAIN );

		// generated list to continue soft rollout
		$allowedCityIds = [
			1000000311,
			113,
			1163770,
			119,
			1249,
			125,
			13346,
			1456064,
			147,
			1544,
			1706,
			174,
			175043,
			177996,
			2061,
			20780,
			2154,
			2233,
			2237,
			250551,
			2520,
			2569,
			277,
			283,
			2860,
			3035,
			3124,
			3125,
			31618,
			323,
			3469,
			3510,
			374,
			376,
			4097,
			410,
			4541,
			462,
			48473,
			490,
			509,
			530,
			5975,
			663,
			673,
			68170,
			691,
			74,
			78127,
			831,
			833670,
			835,
			916058,
			932,
			95,
			984,
		];
		$isProperCommunity = Wikia::isDevEnv() || in_array( $wgCityId, $allowedCityIds );

		// only enable it onNS 0 AND dev env
		$vars['wgAffiliateEnabled'] = $isProperNamespace && $isProperCommunity;

		// add translations from AffiliateService.i18n.php
		$vars['disclaimerMessage'] = wfMessage('affiliate-service-disclaimer')->escaped();

		wfProfileOut( __METHOD__ );
		return true;
	}
}
