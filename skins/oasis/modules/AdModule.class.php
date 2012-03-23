<?php

class AdModule extends Module {

	private static $config;
	private static $slotsUseGetAd = array( 'HOME_INVISIBLE_TOP', 'INVISIBLE_TOP', 'INVISIBLE_1', 'INVISIBLE_2', 'HOME_TOP_RIGHT_BUTTON', 'TOP_RIGHT_BUTTON' );
	private static $slotsDisplayShinyAdSelfServe = array( 'CORP_TOP_RIGHT_BOXAD', 'HOME_TOP_RIGHT_BOXAD', 'TEST_TOP_RIGHT_BOXAD', 'TOP_RIGHT_BOXAD' );

	private function configure() {
		global $wgOut, $wgTitle, $wgContentNamespaces, $wgEnableFAST_HOME2, $wgEnableCorporatePageExt, $wgExtraNamespaces;

		self::$config = array();

		if(!$wgOut->isArticle() && !$wgTitle->isSpecial('Search') && !$wgTitle->isSpecial('Leaderboard')){ // RT#74422 Run ads on search results page
			return;
		}
		if(ArticleAdLogic::isWikiaHub() && ArticleAdLogic::isAdsEnabledOnWikiaHub()) {
			self::$config['HUB_TOP_LEADERBOARD'] = true;
			return;
		}
		// Ads on corporate hub pages only
		elseif($wgEnableCorporatePageExt) {
			if (BodyModule::isHubPage()) {
				self::$config['CORP_TOP_LEADERBOARD'] = true;
				self::$config['CORP_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			}
			return;
		}

		$namespace = $wgTitle->getNamespace();

		if(ArticleAdLogic::isMainPage()) {
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
			} else if($namespace == NS_SPECIAL) {
				if ($wgTitle->isSpecial('Search')) {
					// search results page
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;
					self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
					self::$config['TOP_BUTTON'] = true;
				} else if($wgTitle->isSpecial('Leaderboard')) {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;					
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
			} else if( BodyModule::isBlogListing() ) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if( BodyModule::isBlogPost() ) {
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


	public $slotname;

	public $ad;

	public function executeIndex(array $params) {
		global $wgShinyAdsSelfServeUrl;

		if(self::$config === null) {
			$this->configure();
		}

		$this->slotname = $params['slotname'];
		$this->selfServeUrl = null;
		if ($wgShinyAdsSelfServeUrl) {
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

	public $conf;

	public function executeConfig($params) {

		if(self::$config === null) {
			$this->configure();
		}

		$this->conf = self::$config;

	}

}
