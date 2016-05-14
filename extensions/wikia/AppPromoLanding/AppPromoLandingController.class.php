<?php

/**
 * Main class for the AppPromoLanding screen.  This comandeers /wiki/Community_App and displays
 * a page with very-little chrome on it that will let a user send the app link to their phone.
 *
 * @author Sean Colombo
 */
class AppPromoLandingController extends WikiaController {
	
	private static $extraBodyClasses = []; // TODO: REMOVE - ONLY DURING THE TEMPORARY COPYING OF OASISCONTROLLER

	const RESPONSE_OK = 200;
	const APP_CONFIG_SERVICE_URL = "http://prod.deploypanel.service.sjc.consul/api/app-configuration/";
	
	protected static $CACHE_KEY = "mobileAppConfigs";
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_EXPIRY = 86400;

	/**
	 * Render HTML for whole App Promo Landing page.
	 */
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		// Since this "Community_App" article won't be found, we need to manually say it's okay so that it's not a 404.
		$this->response->setCode(self::RESPONSE_OK);
		
		// Pull in the app-configuration (has data for all apps)
		$appConfig = [];
		$memcKey = wfMemcKey( static::$CACHE_KEY, static::$CACHE_KEY_VERSION );
		$response = F::app()->wg->memc->get( $memcKey );
		if ( empty( $response ) ){
			$req = MWHttpRequest::factory( self::APP_CONFIG_SERVICE_URL, array( 'noProxy' => true ) );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException( self::APP_CONFIG_SERVICE_URL );
				} else {
					// Request was successful. Cache it in memcached (faster than going over network-card even on our internal network).
					F::app()->wg->memc->set( $memcKey, $response, static::$CACHE_EXPIRY );
				}
			}
		}

		$appConfig = json_decode( $response );
		if(empty($appConfig)){

			// TODO: How should we handle the error of not having an appConfig? We won't be able to link the user to the apps.

		}

		$config = $this->getConfigForWiki($appConfig, $this->wg->CityId);

		// Create the direct-link URLs for the apps on each store.
		$this->androidUrl = $this->getAndroidUrl($config);
		$this->iosUrl = $this->getIosUrl($config);

		// Inject the JS
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'app_promo_landing_js' );
		foreach( $srcs as $src ) {
			$this->wg->Out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$src}\"></script>" );
		}

		// render the custom App Promo Landing body (this includes the nav bar and the custom content).
		$body = F::app()->renderView('AppPromoLanding', 'Content', [
			"androidUrl" => $this->androidUrl,
			"iosUrl" => $this->iosUrl
		]);

		// page has one column
		OasisController::addBodyClass('oasis-one-column');

		// adding 'appPromo' class as a CSS helper
		OasisController::addBodyClass('appPromo');

		// temporary grid transition code, remove after transition
		OasisController::addBodyClass('WikiaGrid');

		// render Oasis module to the 'html' var which the AppPromoLanding_index template will just dump out.
		$this->html = F::app()->renderView( 'Oasis', 'Index', [ 'body' => $body ] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * This part of the controller is responsible for dumping the "body" of the page which
	 * will include both the standard Wikia GlobalNavigation
	 */
	public function executeContent($params){
		wfProfileIn( __METHOD__ );

		// render global and user navigation
		$this->header = F::app()->renderView( 'GlobalNavigation', 'index' );

		$this->androidUrl = $params["androidUrl"];
		$this->iosUrl = $params["iosUrl"];

		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * Given the huge JSON object containing the config for all apps,
	 * find and return just the config for the given cityId.
	 *
	 * @param $appConfig - assoc array returned by parsing the JSON of all app configurations
	 * @param $cityId - the wiki-cityId to get the config for.
	 * @return associative array containing the config for the given wiki.
	 */
	private function getConfigForWiki($appConfig, $cityId){
		wfProfileIn( __METHOD__ );
		$desiredConfig = [];
		
		// The wiki_ids are in the "languages" section of each app's config. Compare against those.
		foreach($appConfig as $currentApp){
			foreach($currentApp->languages as $lang){
				if($lang->wikia_id == $cityId){
					$desiredConfig = $currentApp;
					break;
				}
			}
			
			if(!empty($desiredConfig)){
				break;
			}
		}

		wfProfileOut( __METHOD__ );
		return $desiredConfig;
	}

	/**
	 * @param config - associative array containing the config for a single wiki, as parsed 
	 *                 from APP_CONFIG_SERVICE_URL.
	 * @return string containing the URL of the app for android devices (eg: on Google Play Store).
	 */
	private function getAndroidUrl($config){
		return "https://play.google.com/store/apps/details?id={$config->android_release}&utm_source=General&utm_medium=Site&utm_campaign=AppPromoLanding";
	}
	
	/**
	 * @param config - associative array containing the config for a single wiki, as parsed 
	 *                 from APP_CONFIG_SERVICE_URL.
	 * @return string containing the URL of the app for iOS devices (on the iTunes App Store).
	 */
	private function getIosUrl($config){
		return "https://itunes.apple.com/us/app/id{$config->ios_release}?utm_source=General&utm_medium=Site&utm_campaign=AppPromoLanding";
	}

	/**
	 * We use the same general trick that Special:Chat uses to basically redirect rendering
	 * to be done by a specific Oasis module.  However, instead of being located inside of
	 * a special page, we are doing this by stealing the "Community_App" article title.
	 */
	public static function onOutputPageBeforeHTML( OutputPage &$out, &$text ){
		$title = $out->getTitle();
		$origTitle = $title->getDBkey();
		if($origTitle == "Community_App"){
			Wikia::setVar( 'OasisEntryControllerName', 'AppPromoLanding' );

			// TODO: CREATE AppPromoLanding MODULE IN ResourceLoader IF WE NEED JS i18n (probably won't).
			//$out->addModules( 'ext.AppPromoLanding' );
		}
		return $out;
	}
}
