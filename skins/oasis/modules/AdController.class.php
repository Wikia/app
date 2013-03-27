<?php

class AdController extends WikiaController {

	private static $config = null;

	private function configure() {
		global $wgTitle, $wgContentNamespaces, $wgEnableFAST_HOME2, $wgExtraNamespaces;

		self::$config = array();

		if (!AdEngine2Controller::areAdsShowableOnPage()) {
			return;
		}

		if(WikiaPageType::isWikiaHub() && AdEngine::isAdsEnabledOnWikiaHub()) {
			self::$config['HUB_TOP_LEADERBOARD'] = true;
			self::$config['INVISIBLE_SKIN'] = true;
			self::$config['INVISIBLE_1'] = true;
			self::$config['INVISIBLE_2'] = true;
			return;
		}

		if ($this->wg->EnableCorporatePageExt) {
			self::$config['TOP_LEADERBOARD'] = true;
			self::$config['INVISIBLE_SKIN'] = true;
			self::$config['TOP_RIGHT_BOXAD'] = true;
			self::$config['CORP_TOP_LEADERBOARD'] = true;
			self::$config['CORP_TOP_RIGHT_BOXAD'] = true;
			return;
		}

		$namespace = $wgTitle->getNamespace();

		if(WikiaPageType::isMainPage()) {
			// main page
			self::$config['HOME_TOP_LEADERBOARD'] = true;
			self::$config['INVISIBLE_SKIN'] = true;
			self::$config['INVISIBLE_1'] = true;
			self::$config['INVISIBLE_2'] = true;
			self::$config['PREFOOTER_LEFT_BOXAD'] = true;
			self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
			if($wgEnableFAST_HOME2) {
				self::$config['HOME_TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_HOME_TOP_RIGHT_BOXAD'] = true;
			}
			self::$config['HOME_TOP_RIGHT_BUTTON'] = true;
			self::$config['TOP_BUTTON'] = true;
			self::$config['TOP_BUTTON_WIDE'] = true;
		} else {
			if(in_array($namespace, $wgContentNamespaces)) {
				// content page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['MIDDLE_RIGHT_BOXAD'] = true;
				self::$config['INVISIBLE_1'] = true;
				self::$config['INVISIBLE_2'] = true;
				self::$config['LEFT_SKYSCRAPER_2'] = true;
				self::$config['LEFT_SKYSCRAPER_3'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				self::$config['TOP_RIGHT_BUTTON'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if($namespace == NS_FILE) {
				// file/image page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if(WikiaPageType::isForum()) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
				self::$config['LEFT_SKYSCRAPER_3'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
			} else if (WikiaPageType::isSearch()) {
				// search results page
				if (empty($this->wg->EnableWikiaSearchAds)) {
					// regular ads if search ads are disabled
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['INVISIBLE_SKIN'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;
					self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
					self::$config['TOP_BUTTON'] = true;
					self::$config['TOP_BUTTON_WIDE'] = true;
					self::$config['PREFOOTER_LEFT_BOXAD'] = true;
					self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				}
			} else if($namespace == NS_SPECIAL) {
				if($wgTitle->isSpecial('Leaderboard')) {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['INVISIBLE_SKIN'] = true;
					self::$config['TOP_RIGHT_BOXAD'] = true;
					self::$config['TOP_BUTTON'] = true;
					self::$config['TOP_BUTTON_WIDE'] = true;
				} else if($wgTitle->isSpecial('Videos')) {
					self::$config['TOP_LEADERBOARD'] = true;
					self::$config['INVISIBLE_SKIN'] = true;
					self::$config['TOP_BUTTON'] = true;
					self::$config['TOP_BUTTON_WIDE'] = true;
				}
			} else if($namespace == NS_CATEGORY) {
				// category page
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['MIDDLE_RIGHT_BOXAD'] = true;
				self::$config['LEFT_SKYSCRAPER_2'] = true;
				self::$config['INVISIBLE_1'] = true;
				self::$config['INVISIBLE_2'] = true;
				self::$config['PREFOOTER_LEFT_BOXAD'] = true;
				self::$config['PREFOOTER_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if($namespace == NS_PROJECT) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if( BodyController::isBlogListing() ) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if( BodyController::isBlogPost() ) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_RIGHT_BOXAD'] = true;
				self::$config['TEST_TOP_RIGHT_BOXAD'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			} else if (array_key_exists($namespace, $wgExtraNamespaces)) {
				self::$config['TOP_LEADERBOARD'] = true;
				self::$config['INVISIBLE_SKIN'] = true;
				self::$config['TOP_BUTTON'] = true;
				self::$config['TOP_BUTTON_WIDE'] = true;
			}
		}
	}

	public function executeIndex(array $params) {
		$slotname = $params['slotname'];

		if(self::$config === null) {
			$this->configure();
		}

		if (isset(self::$config[$slotname])) {
			$this->slotname = $slotname;
		}
	}

	//public $conf;

	public function executeConfig($params) {

		if(self::$config === null) {
			$this->configure();
		}

		$this->conf = self::$config;

	}
	
	public function executeTop() {
	}
}
