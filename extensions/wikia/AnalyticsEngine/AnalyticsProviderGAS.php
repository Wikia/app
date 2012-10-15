<?php
class AnalyticsProviderGAS implements iAnalyticsProvider {

	public function getSetupHtml($params=array()){
		global $wgProto;

		static $called = false;
		if($called == true){
			return '';
		}
		$called = true;

		$script = '';

		return $script;
	}

	public function trackEvent($event, $eventDetails=array()){
		switch ($event){
			case "lyrics":
				return $this->lyrics();

			case AnalyticsEngine::EVENT_PAGEVIEW:
				return '';

			case 'hub':
				return '';

			case 'onewiki':
				return $this->onewiki($eventDetails[0]);

			case 'pagetime':
			 	return $this->pagetime($eventDetails[0]);

			case "varnish-stat":
				return $this->varnishstat();

			case "usertiming":
				return $this->userTiming();

			default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

	static public function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ){
		//should be added unprocessed as per Cardinal Path's request
		//but screw it, that's an additional single request that adds overhead
		//and the main experiment is done on Oasis :P
		$jsHeadPackages[] = 'analytics_gas_js';
		return true;
	}

	static public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ){
		$app = F::app();

		//do not proceed if skin is WikiaMobile, see onWikiaMobileAssetsPackages
		if ( !( $app->checkSkin( 'wikiamobile', $skin ) ) ) {
			//needs to be added unprocessed as per Cardinal Path's request
			//so AssetsManager is not an option here
			$scripts .= "\n<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/AnalyticsEngine/js/analytics_prod.js\"></script>";
		}

		return true;
	}

	private function onewiki($city_id){
		return '';
	}

	private function pagetime($skin){
		return '';
	}

	private function varnishstat() {
		return '';
	}

	private function lyrics() {
		return '';
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
