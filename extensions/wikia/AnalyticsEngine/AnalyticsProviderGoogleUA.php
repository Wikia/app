<?php
class AnalyticsProviderGoogleUA implements iAnalyticsProvider {
	public function getSetupHtml($params=array()){
		return '';
	}

    public function trackEvent($event, $eventDetails=array()){
        return '';
    }

	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ){
		//should be added unprocessed as per Cardinal Path's request
		//but screw it, that's an additional single request that adds overhead
		//and the main experiment is done on Oasis :P
		array_unshift( $jsStaticPackages, 'universal_analytics_js' );

		return true;
	}

	static public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ){
		global $wgDevelEnvironment, $wgGAUserIdSalt, $wgStagingEnvironment;

		$app = F::app();

		//do not proceed if skin is WikiaMobile, see onWikiaMobileAssetsPackages
		if ( !( $app->checkSkin( array( 'wikiamobile', 'oasis' ), $skin ) ) ) {
			//needs to be added unprocessed as per Cardinal Path's request
			//so AssetsManager is not an option here
			$scripts .= "\n<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/AnalyticsEngine/js/universal_analytics.js\"></script>";
		}

		// setup User-ID hash for Universal Analytics user tracking across different devices
		$user = $app->wg->User;

		if (!$user->isAnon()) {
			$vars['wgGAUserIdHash'] = md5($user->getId() . $wgGAUserIdSalt);
		}

		// Enable collecting stats to staging accounts on all dev and staging environments
		if ($wgDevelEnvironment || $wgStagingEnvironment) {
			$vars['wgGaStaging'] = true;
		}

		return true;
	}

	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		// this is only called in Oasis, so there's no need to double-check it
		$jsAssetGroups[] = 'universal_analytics_js';

		return true;
	}
}
