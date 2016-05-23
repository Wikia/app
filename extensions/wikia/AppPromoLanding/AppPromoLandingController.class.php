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
	const BRANCH_API_URL = "https://api.branch.io/v1/app/";

	// Settings for the background image-grid.
	const MAX_TRENDING_ARTICLES = 40; // we need about 33 images, and not all articles have images.
	const THUMBS_PER_ROW = 11;
	const THUMBS_NUM_ROWS = 3;
	const IMG_HEIGHT = 184; // sizes directly from Zeplin.io mockup.
	const IMG_WIDTH = 184;

	protected static $CACHE_KEY = "mobileAppConfigs";
	protected static $CACHE_KEY_BRANCH = "branchioBranchKey";
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_KEY_VERSION_BRANCH = 0.1;
	protected static $CACHE_EXPIRY = 86400;

	/**
	 * Render HTML for whole App Promo Landing page.
	 */
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		// Since this "Community_App" article won't be found, we need to manually say it's okay so that it's not a 404.
		$this->response->setCode(self::RESPONSE_OK);

		// Inject the JS
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'app_promo_landing_js' );
		foreach( $srcs as $src ) {
			$this->wg->Out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$src}\"></script>" );
		}

		// render the custom App Promo Landing body (this includes the nav bar and the custom content).
		$body = F::app()->renderView('AppPromoLanding', 'Content', [ ]);

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

		// Get the config for this app, from the service.
		$this->config = AppPromoLandingController::getConfigForWiki($this->wg->CityId);

		// Create the direct-link URLs for the apps on each store.
		$this->androidUrl = $this->getAndroidUrl($this->config);
		$this->iosUrl = $this->getIosUrl($this->config);

		//Fetch Trending Articles images to use as the image-grid background.
		try {
			$trendingArticlesData = F::app()->sendRequest( 'ArticlesApi', 'getTop' )->getVal( 'items' );
		}
		catch ( Exception $e ) {
			$trendingArticlesData = false;
		}
		$trendingArticles = [];
		if ( !empty( $trendingArticlesData ) ) {
			$items = array_slice( $trendingArticlesData, 0, self::MAX_TRENDING_ARTICLES );
			//load data from response to template
			foreach( $items as $item ) {
				$img = $this->app->sendRequest( 'ImageServing', 'getImages', [
					'ids' => [ $item['id'] ],
					'height' => self::IMG_HEIGHT,
					'width' => self::IMG_WIDTH,
					'count' => 1
				] )->getVal( 'result' );

				$thumbnail = $img[$item['id']][0]['url'];

				if ( empty( $thumbnail ) ) {
					// If there is no thumbnail, then it's not useful for our grid.
					$thumbnail = false;
				} else {
					$trendingArticles[] = [
						//'url' => $item['url'],
						'title' => $item['title'],
						'imgUrl' => $thumbnail,
						'width' => self::IMG_WIDTH,
						'height' => self::IMG_HEIGHT
					];
				}
			}
		}

		// Not all articles will have images, so we may have more or less than we need. Here,
		// we will right-size the array.
		$numThumbsNeeded = (self::THUMBS_NUM_ROWS * self::THUMBS_PER_ROW);
		if(count($trendingArticles) > $numThumbsNeeded){
			$trendingArticles = array_slice($trendingArticles, 0, $numThumbsNeeded);
		} else if(count($trendingArticles) < $numThumbsNeeded){
			// There weren't enough thumbs, so fill the remainder of the array with duplicates
			// that are selected in a random order.
			while(count($trendingArticles) < $numThumbsNeeded){
				$trendingArticles[] = $trendingArticles[ rand(0, count($trendingArticles)-1) ];
			}
		}
		
		// The app configs store the branch_app_id but not the branch_key. We need to hit the Branch API to grab that.
		$branchKeyMemcKey = wfMemcKey( static::$CACHE_KEY_BRANCH, static::$CACHE_KEY_VERSION_BRANCH );
		$this->branchKey = F::app()->wg->memc->get( $branchKeyMemcKey );
		if ( empty( $this->branchKey ) ){
			$branchUrl = self::BRANCH_API_URL."{$this->config->branch_app_id}?user_id=".F::app()->wg->BranchUserId;
			$req = MWHttpRequest::factory( $branchUrl, array( 'noProxy' => true ) );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException( $branchUrl );
				} else {
					$branchData = json_decode( $response );
					$this->branchKey = $branchData->branch_key;
					if(!empty($this->branchKey)){
						// Request was successful. Cache the branch_key in memcached (faster than going over network).
						F::app()->wg->memc->set( $branchKeyMemcKey, $this->branchKey, static::$CACHE_EXPIRY );
					}
				}
			}
		}

		$this->thumbWidth = self::IMG_WIDTH;
		$this->thumbHeight = self::IMG_HEIGHT;
		$this->thumbRows = self::THUMBS_NUM_ROWS;
		$this->numThumbsPerRow = self::THUMBS_PER_ROW;
		$this->trendingArticles = $trendingArticles;
		$this->mainPageUrl = Title::newMainPage()->getFullUrl();
		$this->androidPhoneSrc = F::app()->wg->ExtensionsPath."/wikia/AppPromoLanding/images/nexus6.png";
		//$this->androidScreenShot = "http://s3.amazonaws.com/wikia-mobile/android-screenshots/{$this->config->app_tag}/1.png"; // using our own domain is faster & cheaper than s3.
		$this->androidScreenShot = "http://wikia-mobile.nocookie.net/wikia-mobile/android-screenshots/{$this->config->app_tag}/1.png";
		$this->iosPhoneSrc = F::app()->wg->ExtensionsPath."/wikia/AppPromoLanding/images/silverIphone.png";
		//$this->iosScreenShot = "http://s3.amazonaws.com/wikia-mobile/ios-screenshots/{$this->config->app_tag}/en/4.7/4.png.PNGCRUSH.png"; // using our own domain is faster & cheaper than s3.
		$this->iosScreenShot = "http://wikia-mobile.nocookie.net/wikia-mobile/ios-screenshots/{$this->config->app_tag}/en/4.7/4.png.PNGCRUSH.png";
		$this->androidStoreSrc = F::app()->wg->ExtensionsPath."/wikia/AppPromoLanding/images/playStoreButton.png";
		$this->iosStoreSrc = F::app()->wg->ExtensionsPath."/wikia/AppPromoLanding/images/appleAppStoreButton.png";
		$this->imgSpacing = 1; // spacing between the image-grid cells.

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Given the huge JSON object containing the config for all apps,
	 * find and return just the config for the given cityId.
	 *
	 * @param $cityId - the wiki-cityId to get the config for.
	 * @return stdClass object containing the config for the given wiki. If
	 *         there is no app configured for the given wiki, then null is returned.
	 */
	static private function getConfigForWiki($cityId){
		wfProfileIn( __METHOD__ );
		$desiredConfig = null;

		// Gets the configs for ALL apps.
		$appConfig = AppPromoLandingController::getAllAppConfigs();
		
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
	 * Gets the app configs from the service URL (or memcached, if it's available there) and returns
	 * it as a parsed object.
	 */
	static private function getAllAppConfigs(){
		wfProfileIn(__METHOD__);
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

		wfProfileOut( __METHOD__ );
		return $appConfig;
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
		// Only steal this page if the wiki has an app configured.
		$config = AppPromoLandingController::getConfigForWiki(F::app()->wg->CityId);
		if($config !== null){
			$title = $out->getTitle();
			$origTitle = $title->getDBkey();
			
			if($origTitle == "Community_App"){
				Wikia::setVar( 'OasisEntryControllerName', 'AppPromoLanding' );
			}
		}
		return $out;
	}
}
