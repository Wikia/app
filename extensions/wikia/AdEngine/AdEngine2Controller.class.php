<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {
	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';

	private static $EXITSTITIAL_URLS_WHITE_LIST; // links to those domains won't display exitstitial ads

	// BIG TODO: Move all show some/show some/show none logic to this file

	/**
	 * Check if for current page the ads can be displayed or not
	 * We only want ads on regular article pages plug a few
	 * special pages. The logic lays here.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage() {
		// Don't show ads on:
		if (WikiaPageType::isActionPage()) {
			return false;
		}

		$wg = F::app()->wg;
		$title = $wg->Title;

		// Show ads only on the following page types:
		$runAds = $wg->Out->isArticle()
			|| WikiaPageType::isSearch()
			|| WikiaPageType::isForum()
			|| WikiaPageType::isWikiaHub();

		if ($title) {
			$runAds = $runAds
				|| (defined('NS_WIKIA_PLAYQUIZ') && $title->inNamespace(NS_WIKIA_PLAYQUIZ))
				|| $title->isSpecial('Videos')
				|| $title->isSpecial('Leaderboard');
		}

		return $runAds;
	}

	/**
	 * Register ad-related vars on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public function onWikiaSkinTopScripts(&$vars, &$scripts) {
		wfProfileIn(__METHOD__);

		$req = $this->wg->Request;

		// AdEngine2.js
		$vars['adslots2'] = array();
		$vars['wgLoadAdsInHead'] = !empty($this->wg->LoadAdsInHead);
		$vars['wgAdsShowableOnPage'] = self::areAdsShowableOnPage();
		$vars['wgShowAds'] = $this->wg->ShowAds;

		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = array();

		// WikiaDartHelper.js
		if (!empty($this->wg->DartCustomKeyValues)) {
			$vars['wgDartCustomKeyValues'] = $this->wg->DartCustomKeyValues;
		}
		$cat = AdEngine::getCachedCategory();
		$vars['cityShort'] = $cat['short'];

		if (!empty($this->wg->DFPid)) {
			$vars['wgDFPid'] = $this->wg->DFPid;
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function onOasisSkinAssetGroups(&$jsAssets) {
		$coreGroupIndex = array_search(self::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex === false) {
			// Do nothing. oasis_shared_core_js must be present for ads to work
			return true;
		}

		if (!$this->wg->LoadAdsInHead) {
			// Add ad asset to JavaScripts loaded on bottom (with regular JavaScripts)
			array_splice($jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE);
		}
		return true;
	}

	/**
	 * Modify assets appended to the top of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if ($this->wg->LoadAdsInHead) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		}
		return true;
	}

	public function onWikiaSkinTopModules(&$scriptModules, $skin) {
		if ($this->wg->LoadAdsInHead) {
			$scriptModules[] = 'wikia.cookies';
			$scriptModules[] = 'wikia.geo';
			$scriptModules[] = 'wikia.location';
			$scriptModules[] = 'wikia.log';
			$scriptModules[] = 'wikia.querystring';
			$scriptModules[] = 'wikia.tracker';
		}
		return true;
	}

	/**
	 * Deal with external interwiki links: add exitstitial class to them if needed
	 *
	 * @param $skin
	 * @param $target
	 * @param $options
	 * @param $text
	 * @param $attribs
	 * @param $ret
	 *
	 * @return bool
	 */
	public function onLinkEnd($skin, Title $target, array $options, &$text, array &$attribs, &$ret) {
		if ($target->isExternal()) {
			$this->handleExternalLink($attribs['href'], $attribs);
		}
		return true;
	}

	/**
	 * Deal with external links: add exitstitial class to them if needed
	 *
	 * @param $url
	 * @param $text
	 * @param $link
	 * @param $attribs
	 *
	 * @return bool
	 */
	public function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs) {
		$this->handleExternalLink($url, $attribs);
		return true;
	}

	/**
	 * Add exitstitial class to the external links pointing to not-whitelisted domains
	 * if $wgEnableOutboundScreenExt is set, user is anonymous, not in editor, etc
	 *
	 * @param $url
	 * @param $attribs
	 *
	 * @return null
	 */
	private function handleExternalLink($url, &$attribs) {
		if (!$this->wg->EnableOutboundScreenExt
			|| $this->wg->RTEParserEnabled    // skip logic when in FCK
			|| empty($this->wg->Title)        // setup functions can call MakeExternalLink before wgTitle is set RT#144229
			|| $this->wg->User->isLoggedIn()  // logged in users have no exit stitial ads
			|| strpos($url, 'http://') !== 0
		) {
			return;
		}

		foreach ($this->getExitstitialUrlsWhiteList() as $whiteListedUrl) {
			if (preg_match('/' . preg_quote($whiteListedUrl) . '/i', $url)) {
				return;
			}
		}

		$attribs['class'] .= ' exitstitial';
	}

	private function getExitstitialUrlsWhiteList() {
		if (is_array(self::$EXITSTITIAL_URLS_WHITE_LIST)) {
			return self::$EXITSTITIAL_URLS_WHITE_LIST;
		}

		$whiteList = array();
		$whiteListContent = $this->wf->MsgExt('outbound-screen-whitelist', array('language' => 'en'));

		if (!empty($whiteListContent)) {
			$lines = explode("\n", $whiteListContent);
			foreach($lines as $line) {
				if(strpos($line, '* ') === 0 ) {
					$whiteList[] = trim($line, '* ');
				}
			}
		}

		$wikiDomains = WikiFactory::getDomains($this->wg->CityId);
		if ($wikiDomains !== false) {
			$whiteList = array_merge($wikiDomains, $whiteList);
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		if ($this->wg->DevelEnvironment && !empty($_SERVER['SERVER_NAME'])) {
			array_unshift($whiteList, $_SERVER['SERVER_NAME']);
		}

		// Save for later
		self::$EXITSTITIAL_URLS_WHITE_LIST = $whiteList;

		return $whiteList;
	}
}
