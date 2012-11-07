<?php

class AdController extends WikiaController {

	private static $config;
	private static $slotsUseGetAd = array( 'HOME_INVISIBLE_TOP', 'INVISIBLE_TOP', 'INVISIBLE_1', 'INVISIBLE_2', 'HOME_TOP_RIGHT_BUTTON', 'TOP_RIGHT_BUTTON' );
	private static $slotsDisplayShinyAdSelfServe = array( 'CORP_TOP_RIGHT_BOXAD', 'HOME_TOP_RIGHT_BOXAD', 'TEST_TOP_RIGHT_BOXAD', 'TOP_RIGHT_BOXAD' );

	private function configure() {
		global $wgTitle, $wgContentNamespaces, $wgEnableFAST_HOME2, $wgEnableCorporatePageExt, $wgExtraNamespaces;

		self::$config = array();

		if (!AdEngine2Controller::areAdsShowableOnPage()) {
			return;
		}

		if(WikiaPageType::isWikiaHub() && AdEngine::isAdsEnabledOnWikiaHub()) {
			self::$config['HOME_TOP_LEADERBOARD'] = true;
			self::$config['TOP_BUTTON'] = true;
			return;
		}
		// Ads on corporate hub pages only
		elseif($wgEnableCorporatePageExt) {
			if (BodyController::isHubPage()) {
				self::$config['CORP_TOP_LEADERBOARD'] = true;
				self::$config['CORP_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			}
			elseif (WikiaPageType::isSearch()) {
				if (!empty($this->wg->EnableWikiaSearchAds)) {
					// no regular ads if search ads are enabled
				} else {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;
					self::$config['TOP_BUTTON'] = true;				
				}
			}
			return;
		}

		$namespace = $wgTitle->getNamespace();

		if(WikiaPageType::isMainPage()) {
			// main page
			self::$config['HOME_TOP_LEADERBOARD'] = true;
			self::$config['INVISIBLE_1'] = true;
			self::$config['INVISIBLE_2'] = true;
			self::$config['PREFOOTER_LEFT_BOXAD'] = true;
			self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
			self::$config['HOME_INVISIBLE_TOP'] = false;	// skins used to be served from this slot, but are now served from TOP_LEADERBOARD with option dcopt=ist
			if($wgEnableFAST_HOME2) {
				self::$config['HOME_TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_HOME_TOP_RIGHT_BOXAD'] = true;
			}
			self::$config['HOME_TOP_RIGHT_BUTTON'] = true;
			self::$config['TOP_BUTTON'] = true;
		} else {
			if(in_array($namespace, $wgContentNamespaces)) {
				// content page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['MIDDLE_RIGHT_BOXAD'] = true;
				self::$config['INVISIBLE_1'] = true;
				self::$config['INVISIBLE_2'] = true;
				self::$config['LEFT_SKYSCRAPER_2'] = true;
				self::$config['LEFT_SKYSCRAPER_3'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				self::$config['INVISIBLE_TOP'] = false;	// skins used to be served from this slot, but are now served from TOP_LEADERBOARD with option dcopt=ist
				self::$config['TOP_RIGHT_BUTTON'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if($namespace == NS_FILE) {
				// file/image page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if(WikiaPageType::isForum()) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['LEFT_SKYSCRAPER_3'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
			} else if (WikiaPageType::isSearch()) {
				// search results page
				if (empty($this->wg->EnableWikiaSearchAds)) {
					// regular ads if search ads are disabled
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;
					self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
					self::$config['TOP_BUTTON'] = true;
					self::$config['LEFT_SKYSCRAPER_2'] = true;
					self::$config['LEFT_SKYSCRAPER_3'] = true;
					self::$config['PREFOOTER_LEFT_BOXAD'] = true;
					self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				}
			} else if($namespace == NS_SPECIAL) {
				if($wgTitle->isSpecial('Leaderboard')) {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;					
					self::$config['TOP_BUTTON'] = true;
				} else if($wgTitle->isSpecial('Videos')) {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_BUTTON'] = true;
				}
			} else if($namespace == NS_CATEGORY) {
				// category page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['MIDDLE_RIGHT_BOXAD'] = true;
				self::$config['LEFT_SKYSCRAPER_2'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if($namespace == NS_PROJECT) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if($namespace == NS_FORUM) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if( BodyController::isBlogListing() ) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if( BodyController::isBlogPost() ) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if (array_key_exists($namespace, $wgExtraNamespaces)) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_BUTTON'] = true;
			}
		}
	}

	/*
	public $slotname;

	public $ad;
	 */

	public function executeIndex(array $params) {
		global $wgEnableShinyAdsSelfServeUrl, $wgShinyAdsSelfServeUrl;

		if(self::$config === null) {
			$this->configure();
		}

		$this->slotname = $params['slotname'];
		$this->selfServeUrl = null;
		if ($wgEnableShinyAdsSelfServeUrl && $wgShinyAdsSelfServeUrl) {
			if (array_search($this->slotname, self::$slotsDisplayShinyAdSelfServe) !== FALSE) {
				if (!(AdEngine::getInstance()->getAdProvider($this->slotname) instanceof AdProviderNull)) {	// will we show an ad?
					$this->selfServeUrl = $wgShinyAdsSelfServeUrl;
				}
			}
		}

		if(isset(self::$config[$this->slotname])) {
			if (AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'AdDriver') {
				$this->ad = AdEngine::getInstance()->getAd($this->slotname, $params);
			}
			elseif (AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'LiftDNA') {
				$this->ad = AdEngine::getInstance()->getPlaceHolderDiv($this->slotname);
			}
			elseif (AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'DARTGP' ||
					AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'AdEngine2' ||
					AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'GamePro') {
				$this->ad = AdEngine::getInstance()->getAd($this->slotname);
			}
			else {
				if (in_array($this->slotname, self::$slotsUseGetAd)) {
					$this->ad = AdEngine::getInstance()->getAd($this->slotname);
				}
				else {
					$this->ad = AdEngine::getInstance()->getPlaceHolderIframe($this->slotname);
				}
			}
		}
		wfRunHooks('AfterAdModuleExecute', array( &$this ));

	}

	//public $conf;

	public function executeConfig($params) {

		if(self::$config === null) {
			$this->configure();
		}

		$this->conf = self::$config;

	}
	
	public function executeTop() {
		if ($this->wg->EnableTopButton) {
			if (strtolower($this->wg->EnableTopButton) == 'right') {
				$this->topAdsExtraClasses = ' WikiaTopButtonRight';
			}
			else {
				$this->topAdsExtraClasses = ' WikiaTopButtonLeft';
			}
		}
		else {
			$this->topAdsExtraClasses = '';
		}
	}

}
