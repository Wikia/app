<?php

class AnalyticsProviderGAS implements iAnalyticsProvider {

	/**
	 * Hook for setting proper Google Analytics JS variables.
	 *
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @return bool return true - it's a hook
	 */
	public static function wfMakeGlobalVariablesScript(Array &$vars) {
		global $wgDevelEnvironment, $wgStagingEnvironment;

		// Enable collecting stats to staging accounts on all dev and staging environments
		if ($wgDevelEnvironment || $wgStagingEnvironment) {
			$vars['wgGaStaging'] = true;
		}

		return true;
	}

	public function getSetupHtml($params=array()){
		return '';
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
			case AnalyticsEngine::EVENT_PAGEVIEW:
			case 'hub':
			case 'onewiki':
			case 'pagetime':
			case "varnish-stat":
				return ''; // NOP

			case "usertiming":
				return $this->userTiming();

			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ){
		//should be added unprocessed as per Cardinal Path's request
		//but screw it, that's an additional single request that adds overhead
		//and the main experiment is done on Oasis :P
		array_unshift( $jsStaticPackages, 'analytics_gas_js' );
		return true;
	}

	static public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ){
		$app = F::app();

		//do not proceed if skin is WikiaMobile, see onWikiaMobileAssetsPackages
		if ( !( $app->checkSkin( array( 'wikiamobile', 'oasis', 'venus' ), $skin ) ) ) {
			//needs to be added unprocessed as per Cardinal Path's request
			//so AssetsManager is not an option here
			$scripts .= "\n<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/AnalyticsEngine/js/analytics.js\"></script>";
		}

		return true;
	}

	static public function onVenusAssetsPackages( &$jsHeadGroups, &$jsBodyGroups, &$cssGroups) {
		$jsHeadGroups[] = 'analytics_gas_js';
		return true;
	}

	static public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		// this is only called in Oasis, so there's no need to double-check it
		$jsAssetGroups[] = 'analytics_gas_js';
		return true;
	}

	/**
	 * GA UserTiming experiment
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 * Please ask before doing anything, thanks :)
	 */
	private function userTiming(){
		wfProfileIn( __METHOD__ );

		$app = F::app();
		//global Memcache key, this code doesn't change on a per-wiki base
		//uses cachebuster to allow for easier purging
		$key = implode( ':', array( __METHOD__, $app->wg->StyleVersion ) );
		$code = $app->wg->Memc->get( $key );

		if ( empty( $code ) ) {
			$code = <<<JSCODE
(function(c){
	var u,//shortcut for undefined :)
		e,
		l,
		p = c.performance,
		t = (p) ? p.timing : u,
		t2;

	/**
	 * @private
	 */
	function f(){
		setTimeout(function(){
			if(p){
				t2 = p.timing;
				e = t2.loadEventEnd - t2.domLoading;
				l = 'client';
			}else if(c.wgNow){
				e = (new Date()).getTime() - c.wgNow.getTime();
				l = 'client_approx';
			}

			_gaq.push(['_trackTiming', 'performance', l, e, c.skin]);
			p = t2 = e = l = null;//allow garbage collection
		}, 0);
	}

	if (c.addEventListener){
      c.addEventListener('load', f);
	}else if(c.attachEvent){
      c.attachEvent('onload', f);
	}

	t && _gaq.push(['_trackTiming', 'performance', 'server', t.responseEnd - t.requestStart, c.skin]);
}(window));
JSCODE;
			$code = Html::inlineScript( AssetsManagerBaseBuilder::minifyJs( $code ) );
			//cache it as minification is expensive
			$app->wg->Memc->set( $key, $code, 2592000 /* 30 days */);
		}

		wfProfileOut( __METHOD__ );
		return $code;
	}
}
