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

		// TODO: Hardocde community IDs here (CAKE-5379)
		$allowedCityIds = [
			"147", // https://starwars.fandom.com
			"374", // https://disney.fandom.com
			"2233", // https://marvel.fandom.com
			"177996", // https://marvelcinematicuniverse.fandom.com
			"673", // https://simpsons.fandom.com
			"4097", // https://pixar.fandom.com
			"691", // https://forgottenrealms.fandom.com
			"1163770", // https://criticalrole.fandom.com
		];
		$isProperCommunity = Wikia::isDevEnv() || in_array( $wgCityId, $allowedCityIds );

		// only enable it onNS 0 AND dev env
		$vars['wgAffiliateEnabled'] = $isProperNamespace && $isProperCommunity;

		wfProfileOut( __METHOD__ );
		return true;
	}
}
