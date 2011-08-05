<?php

class AdModule extends Module {

	private static $config;
	private static $slotsUseGetAd = array( 'HOME_INVISIBLE_TOP', 'INVISIBLE_TOP', 'INVISIBLE_1', 'INVISIBLE_2', 'HOME_TOP_RIGHT_BUTTON', 'TOP_RIGHT_BUTTON' );

	private function configure() {
		global $wgOut, $wgTitle, $wgContentNamespaces, $wgEnableFAST_HOME2, $wgEnableCorporatePageExt;

		self::$config = array();

		if(!$wgOut->isArticle() && !$wgTitle->isSpecial('Search')){ // RT#74422 Run ads on search results page
			return;
		}
		// Ads on corporate hub pages only
		if($wgEnableCorporatePageExt) {
			if (BodyModule::isHubPage()) {
				self::$config['CORP_TOP_LEADERBOARD'] = true;
				self::$config['CORP_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				// wlee: we can serve Skins and Footer Ads out of TOP_LEADERBOARD, using option dcopt=ist, Don't need INVISIBLE_* slots
				//self::$config['INVISIBLE_1'] = true;
				//self::$config['INVISIBLE_2'] = true;
				//self::$config['INVISIBLE_TOP'] = true;
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
			self::$config['HOME_INVISIBLE_TOP'] = true;
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
				self::$config['INVISIBLE_TOP'] = true;
				self::$config['TOP_RIGHT_BUTTON'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if($namespace == NS_FILE) {
				// file/image page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_BUTTON'] = true;
			} else if($namespace == NS_SPECIAL && $wgTitle->isSpecial('Search')) {
				// search results page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
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
			} else if( BodyModule::isBlogPost() ) {
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
			}
		}
	}


	public $slotname;

	public $ad;

	public function executeIndex($params) {

		if(self::$config === null) {
			$this->configure();
		}

		$this->slotname = $params['slotname'];

		if(isset(self::$config[$this->slotname])) {
			if (AdEngine::getInstance()->getProviderNameForSlotname($this->slotname) == 'AdDriver') {
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

	public $conf;

	public function executeConfig($params) {

		if(self::$config === null) {
			$this->configure();
		}

		$this->conf = self::$config;

	}

}
