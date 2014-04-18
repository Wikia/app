<?php
use AdEngine2Service;

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {

	private static $slotsDisplayShinyAdSelfServe = ['CORP_TOP_RIGHT_BOXAD', 'HOME_TOP_RIGHT_BOXAD', 'TEST_TOP_RIGHT_BOXAD', 'TOP_RIGHT_BOXAD'];

	public static function getLiftiumOptionsScript() {
		wfProfileIn(__METHOD__);

		global $wgDBname, $wgTitle, $wgLang, $wgDartCustomKeyValues;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
		if (is_object($wgTitle)){
			$options['kv_article_id'] = $wgTitle->getArticleID();
			$options['kv_wpage'] = $wgTitle->getPartialURL();
		}
		$cat = self::getCachedCategory();
		$options['kv_Hub'] = $cat['name'];
		$options['kv_skin'] = RequestContext::getMain()->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];
		$options['kv_isMainPage'] = WikiaPageType::isMainPage();
		$options['kv_page_type'] = WikiaPageType::getPageType();
		$options['geoUrl'] = "http://geoiplookup.wikia.com/";
		if (!empty($wgDartCustomKeyValues)) {
			$options['kv_dart'] = $wgDartCustomKeyValues;
		}

		$options['kv_domain'] = $_SERVER['HTTP_HOST'];
		$options['hasMoreCalls'] = true;
		$options['isCalledAfterOnload'] = true;
		$options['maxLoadDelay'] = 6000;

		$js = "LiftiumOptions = " . json_encode($options) . ";\n";

		$out = "\n<!-- Liftium options -->\n";
		$out .= Html::inlineScript( $js )."\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Action to display an ad (or not)
	 */
	public function ad() {
		$wgEnableShinyAdsSelfServeUrl = $this->wg->EnableShinyAdsSelfServeUrl;
		$wgShinyAdsSelfServeUrl = $this->wg->ShinyAdsSelfServeUrl;

		$this->slotname = $this->request->getVal('slotname');

		$this->selfServeUrl = null;
		if ($wgEnableShinyAdsSelfServeUrl && $wgShinyAdsSelfServeUrl) {
			if (array_search($this->slotname, self::$slotsDisplayShinyAdSelfServe) !== FALSE) {
				$this->selfServeUrl = $wgShinyAdsSelfServeUrl;
			}
		}

		$this->pageLevel = self::getAdLevelForPage();
		$this->slotLevel = self::getAdLevelForSlot($this->slotname);

		$this->showAd = (self::compareAdLevels($this->pageLevel, $this->slotLevel) >= 0);
	}
}
