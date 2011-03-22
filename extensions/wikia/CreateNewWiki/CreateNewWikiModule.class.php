<?php
class CreateNewWikiModule extends Module {

	// global imports
	var $IP;
	var $wgUser;
	var $wgLanguageCode;
	var $wgOasisThemes;
	var $wgSitename;
	var $wgExtensionsPath;

	// form fields
	var $aCategories;
	var $aTopLanguages;
	var $aLanguages;

	// form field values
	var $wikiName;
	var $wikiDomain;
	var $wikiLanguage;
	var $wikiCategory;
	var $params;

	// state variables
	var $currentStep;
	var $skipWikiaPlus;

	public function executeIndex() {
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgSuppressToolbar, $fbOnLoginJsOverride, $wgRequest, $wgPageQuery, $wgUser;
		wfProfileIn( __METHOD__ );

		// hide some default oasis UI things
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = false;
		$wgSuppressAds = true;
		$wgSuppressToolbar = true;

		// fbconnected means user has gone through step 2 to login via facebook.
		// Therefore, we need to reload some values and start at the step after signup/login
		$fbconnected = $wgRequest->getVal('fbconnected');
		$fbreturn = $wgRequest->getVal('fbreturn');
		if((!empty($fbconnected) && $fbconnected === '1') || (!empty($fbreturn) && $fbreturn === '1')) {
			$this->executeLoadState();
			$this->currentStep = 'DescWiki';
		} else {
			$this->currentStep = '';
		}
		$wgPageQuery[] =

		// form field values
		$hubs = WikiFactoryHub::getInstance();
		$this->aCategories = $hubs->getCategories();
		$useLang = $wgRequest->getVal('uselang', $wgUser->getOption( 'language' ));
		$this->params['wikiLanguage'] = empty($this->params['wikiLanguage']) ? $useLang: $this->params['wikiLanguage'];
		$this->params['wikiLanguage'] = empty($useLang) ? $this->wgLanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang

		$this->aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
		$this->aLanguages = wfGetFixedLanguageNames();
		asort($this->aLanguages);

		// facebook callback overwrite on login.  CreateNewWiki re-uses current login stuff.
		$fbOnLoginJsOverride = 'WikiBuilder.fbLoginCallback();';

		// If not english, skip Wikia Plus signup step
		$this->skipWikiaPlus = $this->params['wikiLanguage'] != 'en';

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Ajax call to validate domain.
	 * Called via moduleproxy
	 */
	public function executeCheckDomain() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');
		$type  = $wgRequest->getVal('type');

		$this->response = AutoCreateWiki::checkDomainIsCorrect($name, $lang, $type);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call for validate wiki name.
	 */
	public function executeCheckWikiName() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');

		$this->response = AutoCreateWiki::checkWikiNameIsCorrect($name, $lang);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Creates wiki
	 */
	public function executeCreateWiki() {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgDevelDomains;

		$params = $wgRequest->getArray('data');

		if ( empty($params) ||
			empty($params['wikiName']) ||
			empty($params['wikiDomain']) ||
			empty($params['wikiLanguage']) ||
			empty($params['wikiCategory']) )
		{
			// do nothing
			$this->status = 'error';
			$this->statusMsg = wfMsg('cnw-error-general');
			$this->statusHeader = wfMsg('cnw-error-general-heading');
		} else {
			$createWiki = new CreateWiki($params['wikiName'], $params['wikiDomain'], $params['wikiLanguage'], $params['wikiCategory']);
			$createWiki->create();
			$this->cityId = $createWiki->getWikiInfo('city_id');
			if(empty($this->cityId)) {
				$this->status = 'backenderror';
				$this->statusMsg = wfMsg('databaseerror').'<br>'.wfMsg('cnw-error-general');
				$this->statusHeader = wfMsg('cnw-error-general-heading');
			} else {
				$this->status = 'ok';
				$this->siteName = $createWiki->getWikiInfo('sitename');
				$finishCreateTitle = GlobalTitle::newFromText("FinishCreate", NS_SPECIAL, $this->cityId);
				$this->finishCreateUrl = empty($wgDevelDomains) ? $finishCreateTitle->getFullURL() : str_replace('.wikia.com', '.'.$wgDevelDomains[0], $finishCreateTitle->getFullURL());
			}
		}


		wfProfileOut(__METHOD__);
	}

	/**
	 * Loads params from cookie.
	 */
	public function executeLoadState() {
		wfProfileIn(__METHOD__);
		if(!empty($_COOKIE['createnewwiki'])) {
			$this->params = json_decode($_COOKIE['createnewwiki'], true);
		} else {
			$this->params = array();
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * Checks if WikiPayment is enabled and handles fetching PayPal token - if disabled, displays error message
	 *
	 * @author Maciej B?aszkowski <marooned at wikia-inc.com>
	 */
	public function executeUpgradeToPlus() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$cityId = $wgRequest->getVal('cityId');

		if (method_exists('SpecialWikiPayment', 'fetchPaypalToken')) {
			$data = SpecialWikiPayment::fetchPaypalToken($cityId);
			if (empty($data['url'])) {
				$this->status = 'error';
				$this->caption = wfMsg('owb-step4-error-caption');
				$this->content = wfMsg('owb-step4-error-token-content');
			} else {
				$this->status = 'ok';
				$this->data = $data;
			}
		} else {
			$this->status = 'error';
			$this->caption = wfMsg('owb-step4-error-caption');
			$this->content = wfMsg('owb-step4-error-upgrade-content');
		}

		wfProfileOut( __METHOD__ );
	}

}