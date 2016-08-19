<?php

/**
 * Main class for the AppPromoLanding screen.  This comandeers /wiki/Community_App and displays
 * a page with very-little chrome on it that will let a user send the app link to their phone.
 *
 * @author Sean Colombo
 */
class AppPromoLandingController extends WikiaController {

	const RESPONSE_OK = 200;
	const APP_CONFIG_SERVICE_URL = 'http://prod.deploypanel.service.sjc.consul/api/app-configuration/';
	const BRANCH_API_URL = 'https://api.branch.io/v1/app/';
	const PROMO_PAGE_TITLE = 'Community_App';

	// Settings for the background image-grid.
	const MAX_TRENDING_ARTICLES = 40; // we need about 33 images, and not all articles have images.
	const THUMBS_PER_ROW = 11;
	const THUMBS_NUM_ROWS = 3;
	const IMG_HEIGHT = 184; // sizes directly from Zeplin.io mockup.
	const IMG_WIDTH = 184;

	protected static $CACHE_KEY = 'mobileAppConfigs';
	protected static $CACHE_KEY_BRANCH = 'branchioBranchKey';
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_KEY_VERSION_BRANCH = 0.1;
	protected static $CACHE_EXPIRY = 86400;

	/**
	 * Render HTML for whole App Promo Landing page.
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		// Since this "Community_App" article won't be found, we need to manually say it's okay so that it's not a 404.
		$this->response->setCode( static::RESPONSE_OK );
		
		// Pull in the app-configuration (has data for all apps)
		$appConfig = [];
		$memcKey = wfMemcKey( static::$CACHE_KEY, static::$CACHE_KEY_VERSION );
		$response = $this->wg->memc->get( $memcKey );
		if ( empty( $response ) ){
			$req = MWHttpRequest::factory( static::APP_CONFIG_SERVICE_URL, array( 'noProxy' => true ) );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException( static::APP_CONFIG_SERVICE_URL );
				} else {
					// Request was successful. Cache it in memcached (faster than going over network-card even on our internal network).
					$this->wg->memc->set( $memcKey, $response, static::$CACHE_EXPIRY );
				}
			}
		}

		$appConfig = json_decode( $response );
		if(empty($appConfig)){

			// TODO: How should we handle the error of not having an appConfig? We won't be able to link the user to the apps.

		}

		$config = $this->getConfigForWiki( $appConfig, $this->wg->CityId );

		// Create the direct-link URLs for the apps on each store.
		$this->androidUrl = $this->getAndroidUrl( $config );
		$this->iosUrl = $this->getIosUrl( $config );

		// Inject the JS
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'app_promo_landing_js' );
		foreach( $srcs as $src ) {
			$this->wg->Out->addScript( "<script type=\"{$this->wg->JsMimeType}\" src=\"{$src}\"></script>" );
		}

		// render the custom App Promo Landing body (this includes the nav bar and the custom content).
		$body = $this->app->renderView( 'AppPromoLanding', 'content', [ ] );

		// page has one column
		OasisController::addBodyClass( 'oasis-one-column' );

		// adding 'appPromo' class as a CSS helper
		OasisController::addBodyClass( 'appPromo' );

		// temporary grid transition code, remove after transition
		OasisController::addBodyClass( 'WikiaGrid' );

		// render Oasis module to the 'html' var which the AppPromoLanding_index template will just dump out.
		$this->html = $this->app->renderView( 'Oasis', 'index', [ 'body' => $body ] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * This part of the controller is responsible for dumping the "body" of the page which
	 * will include both the standard Wikia GlobalNavigation
	 */
	public function content( $params ){
		wfProfileIn( __METHOD__ );
		$this->debug = "";

		// render global and user navigation
		$this->header = $this->app->renderView( 'GlobalNavigation', 'index' );

		// Get the config for this app, from the service.
		$this->config = AppPromoLandingController::getConfigForWiki( $this->wg->CityId );

		// Create the direct-link URLs for the apps on each store.
		$this->androidUrl = $this->getAndroidUrl( $this->config );
		$this->iosUrl = $this->getIosUrl( $this->config );

		//Fetch Trending Articles images to use as the image-grid background.
		try {
			$trendingArticlesData = $this->app->sendRequest( 'ArticlesApi', 'getTop' )->getVal( 'items' );
		}
		catch ( Exception $e ) {
			$trendingArticlesData = false;
		}
		$trendingArticles = [];
		if ( !empty( $trendingArticlesData ) ) {
			$items = array_slice( $trendingArticlesData, 0, static::MAX_TRENDING_ARTICLES );
			//load data from response to template
			foreach( $items as $item ) {
				$img = $this->app->sendRequest( 'ImageServing', 'getImages', [
					'ids' => [ $item['id'] ],
					'height' => static::IMG_HEIGHT,
					'width' => static::IMG_WIDTH,
					'count' => 1
				] )->getVal( 'result' );

				$thumbnail = null;
				if( isset( $img[ $item['id'] ] ) ){
					$thumbnail = $img[$item['id']][0]['url'];
				}

				if ( empty( $thumbnail ) ) {
					// If there is no thumbnail, then it's not useful for our grid.
					$thumbnail = false;
				} else {
					$trendingArticles[] = [
						//'url' => $item['url'],
						'title' => $item['title'],
						'imgUrl' => $thumbnail,
						'width' => static::IMG_WIDTH,
						'height' => static::IMG_HEIGHT
					];
				}
			}
		}

		// Not all articles will have images, so we may have more or less than we need. Here,
		// we will right-size the array.
		$numThumbsNeeded = ( static::THUMBS_NUM_ROWS * static::THUMBS_PER_ROW );
		if(count( $trendingArticles ) > $numThumbsNeeded){
			$trendingArticles = array_slice($trendingArticles, 0, $numThumbsNeeded);
		} else if(count( $trendingArticles ) < $numThumbsNeeded ){
			// There weren't enough thumbs, so fill the remainder of the array with duplicates
			// that are selected in a random order.
			while(count( $trendingArticles ) < $numThumbsNeeded ){
				$trendingArticles[] = $trendingArticles[ rand(0, count( $trendingArticles )-1) ];
			}
		}
		
		// The app configs store the branch_app_id but not the branch_key. We need to hit the Branch API to grab that.
		$branchKeyMemcKey = wfMemcKey( static::$CACHE_KEY_BRANCH, static::$CACHE_KEY_VERSION_BRANCH );
		$this->branchKey = $this->wg->memc->get( $branchKeyMemcKey );
		if ( empty( $this->branchKey ) ){
			$branchUrl = static::BRANCH_API_URL."{$this->config->branch_app_id}?user_id=".$this->wg->BranchUserId;
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
					if(!empty( $this->branchKey )){
						// Request was successful. Cache the branch_key in memcached (faster than going over network).
						$this->wg->memc->set( $branchKeyMemcKey, $this->branchKey, static::$CACHE_EXPIRY );
					}
				}
			}
		}

		$this->thumbWidth = static::IMG_WIDTH;
		$this->thumbHeight = static::IMG_HEIGHT;
		$this->thumbRows = static::THUMBS_NUM_ROWS;
		$this->numThumbsPerRow = static::THUMBS_PER_ROW;
		$this->trendingArticles = $trendingArticles;
		$this->mainPageUrl = Title::newMainPage()->getFullUrl();
		$this->larrSvgCode = "<svg width=\"22px\" height=\"16px\" viewBox=\"0 0 22 16\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
								<title>BB56E3FE-7480-48C0-96B3-848DAFB20649</title>
								<desc>Created with sketchtool.</desc>
								<defs></defs>
								<g id=\"Landing-Page\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">
									<g id=\"1064\" transform=\"translate(-267.000000, -622.000000)\">
										<g id=\"back-nav\" transform=\"translate(267.000000, 622.000000)\">
											<path d=\"M21.99875,8.00025 C21.99875,7.44825 21.55175,7.00025 20.99875,7.00025 L3.41275,7.00025 L8.70575,1.70725 C9.09675,1.31625 9.09675,0.68425 8.70575,0.29325 C8.31475,-0.09775 7.68275,-0.09775 7.29175,0.29325 L0.29275,7.29225 C0.19975,7.38525 0.12675,7.49525 0.07575,7.61825 C-0.02525,7.86225 -0.02525,8.13825 0.07575,8.38225 C0.12675,8.50525 0.19975,8.61525 0.29275,8.70825 L7.29175,15.70725 C7.48675,15.90225 7.74275,16.00025 7.99875,16.00025 C8.25475,16.00025 8.51075,15.90225 8.70575,15.70725 C9.09675,15.31625 9.09675,14.68425 8.70575,14.29325 L3.41275,9.00025 L20.99875,9.00025 C21.55175,9.00025 21.99875,8.55225 21.99875,8.00025\" id=\"arrow-left-long\"></path>
										</g>
									</g>
								</g>
							</svg>";

		$this->androidPhoneSrc = $this->wg->ExtensionsPath."/wikia/AppPromoLanding/images/nexus6_large.png";
		$this->androidScreenShot = "http://wikia-mobile.nocookie.net/wikia-mobile/android-screenshots/{$this->config->app_tag}/1.png";
		$this->androidStoreSrc = $this->wg->ExtensionsPath."/wikia/AppPromoLanding/images/playStoreButton.png";
		
		$this->iosPhoneSrc = $this->wg->ExtensionsPath."/wikia/AppPromoLanding/images/silverIphone.png";
		$this->iosScreenShot = "http://wikia-mobile.nocookie.net/wikia-mobile/ios-screenshots/{$this->config->app_tag}/en/4.7/4.png.PNGCRUSH.png";
		$this->iosStoreSrc = $this->wg->ExtensionsPath."/wikia/AppPromoLanding/images/appleAppStoreButton.png";

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
	static private function getConfigForWiki( $cityId ){
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
			
			if(!empty( $desiredConfig )){
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
			$req = MWHttpRequest::factory( static::APP_CONFIG_SERVICE_URL, array( 'noProxy' => true ) );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException( static::APP_CONFIG_SERVICE_URL );
				} else {
					// Request was successful. Cache it in memcached (faster than going over network-card even on our internal network).
					F::app()->wg->memc->set( $memcKey, $response, static::$CACHE_EXPIRY );
				}
			}
		}

		$appConfig = json_decode( $response );
		if(empty($appConfig)){
			
			// If no config was found for this wiki (which is totally normal on sites without an app) just return an empty array.
			$appConfig = [];

		}

		wfProfileOut( __METHOD__ );
		return $appConfig;
	}

	/**
	 * @param config - associative array containing the config for a single wiki, as parsed 
	 *                 from APP_CONFIG_SERVICE_URL.
	 * @return string containing the URL of the app for android devices (eg: on Google Play Store).
	 */
	private function getAndroidUrl( $config ){
		return (empty($config) ? "" : "https://play.google.com/store/apps/details?id={$config->android_release}&utm_source=General&utm_medium=Site&utm_campaign=AppPromoLanding" );
	}

	/**
	 * @param config - associative array containing the config for a single wiki, as parsed 
	 *                 from APP_CONFIG_SERVICE_URL.
	 * @return string containing the URL of the app for iOS devices (on the iTunes App Store).
	 */
	private function getIosUrl( $config ){
		return (empty($config) ? "" : "https://itunes.apple.com/us/app/id{$config->ios_release}?utm_source=General&utm_medium=Site&utm_campaign=AppPromoLanding" );
	}

	/**
	 * We use the same general trick that Special:Chat uses to basically redirect rendering
	 * to be done by a specific Oasis module.  However, instead of being located inside of
	 * a special page, we are doing this by stealing the "Community_App" article title.
	 */
	public static function onOutputPageBeforeHTML( OutputPage &$out, &$text ){
		// Only steal this page if the wiki has an app configured.
		$config = AppPromoLandingController::getConfigForWiki( F::app()->wg->CityId );
		if($config !== null){
			$title = $out->getTitle();
			$origTitle = $title->getDBkey();
			
			if($origTitle == static::PROMO_PAGE_TITLE){
				Wikia::setVar( 'OasisEntryControllerName', 'AppPromoLanding' );
			}
		}
		return $out;
	}
}
